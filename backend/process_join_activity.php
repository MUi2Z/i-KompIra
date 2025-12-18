<?php
include '../config/connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['userID'])) {
    
    $activityID = (int)$_POST['activityID'];
    $userID = $_SESSION['userID'];

    // Semak jika sudah wujud (Double protection)
    $check = $conn->prepare("SELECT participationID FROM participations WHERE activityID = ? AND userID = ?");
    $check->bind_param("ii", $activityID, $userID);
    $check->execute();
    $res = $check->get_result();

    if ($res->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO participations (activityID, userID) VALUES (?, ?)");
        $stmt->bind_param("ii", $activityID, $userID);
        
        if ($stmt->execute()) {
            header("Location: ../member/participate.php?status=success&message=Penyertaan Berjaya!");
        } else {
            header("Location: ../member/participate.php?status=error&message=Gagal menyertai.");
        }
        $stmt->close();
    } else {
        header("Location: ../member/participate.php?status=warning&message=Anda sudah menyertai aktiviti ini.");
    }
    
    $conn->close();
} else {
    header("Location: ../public/login.php");
}
?>