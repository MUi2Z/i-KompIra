<?php
session_start();
include '../config/connection.php';

if (isset($_GET['id']) && isset($_GET['status'])) {
    $targetID = $_GET['id'];
    $newStatus = $_GET['status'];

    // 1. Kemaskini status dalam jadual members
    $stmt = $conn->prepare("UPDATE members SET status = ? WHERE userID = ?");
    $stmt->bind_param("si", $newStatus, $targetID);
    
    if ($stmt->execute()) {
        // 2. Jika diterima, tukar role dalam jadual users kepada 'member'
        if ($newStatus === 'active') {
            $updateRole = $conn->prepare("UPDATE users SET role = 'member' WHERE userID = ?");
            $updateRole->bind_param("i", $targetID);
            $updateRole->execute();
        }
        
        header("Location: ../admin/pending_requests.php?msg=success");
    } else {
        header("Location: ../admin/pending_requests.php?msg=error");
    }
}