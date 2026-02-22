<?php
session_start();
require_once '../config/connection.php';

if (!isset($_SESSION['userID'])) {
    header("Location: ../public/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../member/profile.php");
    exit();
}

$userID = $_SESSION['userID'];
$fullName = trim($_POST['fullName'] ?? '');
$NRIC = trim($_POST['NRIC'] ?? '');
$programme = trim($_POST['programme'] ?? '');
$beatRoleType = trim($_POST['beatRoleType'] ?? 'Melalu');
$kohort = intval($_POST['kohort'] ?? 2025);

// Validasi
if (empty($fullName) || strlen($NRIC) < 12) {
    $_SESSION['error'] = "Maklumat tidak lengkap atau No. IC tidak sah.";
    header("Location: ../member/profile.php");
    exit();
}

try {
    $conn->begin_transaction();

    // Nota: Kolum 'updated_at' biasanya automatik di DB (CURRENT_TIMESTAMP)
    // Jika tidak, kita masukkan secara manual dalam query
    $sql = "INSERT INTO members (userID, fullName, NRIC, programme, beatRoleType, kohort, status, applied_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW(), NOW())
            ON DUPLICATE KEY UPDATE 
            fullName = VALUES(fullName),
            NRIC = VALUES(NRIC),
            programme = VALUES(programme),
            beatRoleType = VALUES(beatRoleType),
            kohort = VALUES(kohort),
            status = 'pending',
            updated_at = NOW()";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssi", $userID, $fullName, $NRIC, $programme, $beatRoleType, $kohort);
    
    if (!$stmt->execute()) {
        throw new Exception("Gagal melancarkan query: " . $stmt->error);
    }

    $conn->commit();
    
    // Notifikasi Admin (Optional)
    $notify_path = '../admin/notify_admin.php';
        if (file_exists($notify_path)) {
            require_once $notify_path;

            // PENTING: Hantar $conn sebagai parameter terakhir
            notifyAdminNewApplication($userID, $fullName, $NRIC, $conn);
        }

        $_SESSION['success'] = "Permohonan berjaya dihantar!";
        header("Location: ../member/profile.php");
        exit();

} catch (Exception $e) {
    $conn->rollback();
    $_SESSION['error'] = "Ralat Database: " . $e->getMessage(); 
    header("Location: ../member/profile.php");
    exit();
}

?>