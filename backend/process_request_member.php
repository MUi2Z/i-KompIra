<?php
session_start();
require_once '../config/connection.php';

// CSRF protection
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['error'] = "Token keselamatan tidak sah. Sila cuba semula.";
    header("Location: ../member/profile.php");
    exit();
}

// Pastikan pengguna sudah log masuk
if (!isset($_SESSION['userID'])) {
    header("Location: ../public/login.php");
    exit();
}

// Pastikan request adalah POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../member/profile.php");
    exit();
}

$userID = $_SESSION['userID'];

// Validate and sanitize input
$fullName = trim($_POST['fullName'] ?? '');
$NRIC = trim($_POST['NRIC'] ?? '');
$programme = trim($_POST['programme'] ?? 'Diploma');
$beatRoleType = trim($_POST['beatRoleType'] ?? 'Melalu');
$kohort = intval($_POST['kohort'] ?? 2025);

// Validation
$errors = [];

if (empty($fullName)) {
    $errors[] = "Nama penuh diperlukan";
}

if (empty($NRIC) || strlen($NRIC) < 12) {
    $errors[] = "No. Kad Pengenalan tidak sah (minimum 12 digit tanpa -)";
}

if (!is_numeric($kohort) || $kohort < 2000 || $kohort > 2100) {
    $errors[] = "Kohort tidak sah";
}

// Check if user already has a pending or active membership
$check_sql = "SELECT status FROM members WHERE userID = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("i", $userID);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    $existing = $check_result->fetch_assoc();
    if ($existing['status'] === 'pending') {
        $_SESSION['error'] = "Anda sudah mempunyai permohonan yang sedang diproses.";
        header("Location: ../member/profile.php");
        exit();
    } elseif ($existing['status'] === 'active') {
        $_SESSION['error'] = "Anda sudah menjadi ahli aktif.";
        header("Location: ../member/profile.php");
        exit();
    }
}

// If there are validation errors
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: ../member/profile.php");
    exit();
}

// Process the membership application
try {
    // Start transaction
    $conn->begin_transaction();

    // Insert into members table
    $insert_sql = "INSERT INTO members (userID, fullName, NRIC, programme, beatRoleType, kohort, status) 
                   VALUES (?, ?, ?, ?, ?, ?, 'pending')";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("issssi", $userID, $fullName, $NRIC, $programme, $beatRoleType, $kohort);
    
    if (!$insert_stmt->execute()) {
        throw new Exception("Gagal menyimpan permohonan: " . $insert_stmt->error);
    }

    // Optional: Update users table role to 'pending_member' if you have such a field
    // $update_sql = "UPDATE users SET role = 'pending_member' WHERE userID = ?";
    // $update_stmt = $conn->prepare($update_sql);
    // $update_stmt->bind_param("i", $userID);
    // $update_stmt->execute();

    // After successful commit
    $conn->commit();
    
    // Send notification to admin
    require_once 'notify_admin.php';
    notifyAdminNewApplication($userID, $fullName, $NRIC, $conn);
    
    // Success - redirect with success message
    $_SESSION['success'] = "Permohonan anda telah berjaya dihantar! Admin akan menyemaknya dalam masa 24 jam.";
    header("Location: ../member/profile.php");
    exit();

} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    
    // Log error (for debugging)
    error_log("Membership application error: " . $e->getMessage());
    
    // Set error message
    $_SESSION['error'] = "Ralat sistem: " . $e->getMessage();
    header("Location: ../member/profile.php");
    exit();
}
?>