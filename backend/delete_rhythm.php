<?php
session_start();
include_once '../config/connection.php';

// Kawalan Akses: Hanya Admin
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    header("Location: ../public/login.php");
    exit();
}

// Ambil ID dari URL
if (isset($_GET['id'])) {
    $rhythmID = mysqli_real_escape_string($conn, $_GET['id']);

    // SQL Delete
    $sql = "DELETE FROM rhythms WHERE rhythmID = '$rhythmID'";

    if ($conn->query($sql)) {
        // Berjaya padam, kembali ke senarai dengan mesej kejayaan
        header("Location: ../admin/rhythms.php?status=success&message=Irama berjaya dipadamkan!");
    } else {
        // Gagal padam
        header("Location: ../admin/rhythms.php?status=error&message=Gagal memadam irama: " . $conn->error);
    }
} else {
    header("Location: ../admin/rhythms.php");
}

$conn->close();
?>