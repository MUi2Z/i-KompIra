<?php
include_once '../config/connection.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- 1. LOGIK PENGURUSAN SESI & DATA USER ---
$displayRole = "Guest";
$isLoggedIn = false;
$displayName = "Tetamu";
$email = "";
$profileRedirect = "../public/login.php";
$message = '';
$message_type = ''; 

if (isset($_SESSION['userID'])) {
    $isLoggedIn = true;
    $uID = $_SESSION['userID'];
    
    // Ambil maklumat terkini dari database
    $stmt = $conn->prepare("SELECT role, userName, email FROM users WHERE userID = ?");
    $stmt->bind_param("i", $uID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($user = $result->fetch_assoc()) {
        $displayRole = ucfirst($user['role']); 
        $displayName = $user['userName'];
        $email = $user['email'];

        // Redirection logic
        if ($displayRole == 'Admin') {
            $profileRedirect = '../admin/dashboard.php';
        } elseif ($displayRole == 'Member' || $displayRole == 'User') {
            $profileRedirect = "../member/profile.php";
        }
    }

    // --- 2. LOGIK KEMAS KINI KATA LALUAN (POST) ---
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_account'])) {
        
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if (empty($new_password) || empty($confirm_password)) {
            $message = 'Sila isi kedua-dua medan kata laluan.';
            $message_type = 'error';
        } elseif ($new_password !== $confirm_password) {
            $message = 'Kata laluan baru dan pengesahan tidak sepadan.';
            $message_type = 'error';
        } elseif (strlen($new_password) < 6) {
            $message = 'Kata laluan mestilah sekurang-kurangnya 6 aksara.';
            $message_type = 'error';
        } else {
            // Hash kata laluan
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            
            // Kemaskini ke Database
            $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE userID = ?");
            $update_stmt->bind_param("si", $hashed_password, $uID);
            
            if ($update_stmt->execute()) {
                $message = 'Kata laluan anda telah berjaya dikemaskini!';
                $message_type = 'success';
            } else {
                $message = 'Ralat teknikal: Gagal mengemaskini kata laluan.';
                $message_type = 'error';
            }
            $update_stmt->close();
        }
    }
} else {
    // Jika tidak login, hantar ke login page
    header("Location: ../public/login.php");
    exit();
}

