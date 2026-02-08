<?php
include_once '../config/connection.php';
session_start();

// Semak jika permohonan melalui POST dan pengguna sudah log masuk
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['userID'])) {
    
    $activityID = (int)$_POST['activityID']; // ID Aktiviti dari form
    $userID = $_SESSION['userID']; // ID Pengguna dari sesi

    // 1. Semak jika rekod penyertaan memang wujud sebelum memadam
    $check = $conn->prepare("SELECT participationID FROM participations WHERE activityID = ? AND userID = ?");
    $check->bind_param("ii", $activityID, $userID);
    $check->execute();
    $res = $check->get_result();

    if ($res->num_rows > 0) {
        // 2. Jika wujud, laksanakan proses pemadaman (Cancel)
        $stmt = $conn->prepare("DELETE FROM participations WHERE activityID = ? AND userID = ?");
        $stmt->bind_param("ii", $activityID, $userID);
        
        if ($stmt->execute()) {
            // Berjaya padam
            header("Location: ../member/participate.php?status=success&message=Penyertaan telah dibatalkan.");
        } else {
            // Ralat semasa pemadaman
            header("Location: ../member/participate.php?status=error&message=Gagal membatalkan penyertaan.");
        }
        $stmt->close();
    } else {
        // Jika rekod memang tidak wujud dalam database
        header("Location: ../member/participate.php?status=warning&message=Rekod penyertaan tidak ditemui.");
    }
    
    $conn->close();
} else {
    // Jika cuba akses terus tanpa login atau POST
    header("Location: ../public/login.php");
}
?>