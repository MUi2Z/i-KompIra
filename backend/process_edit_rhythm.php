<?php
session_start();
include_once '../config/connection.php';

// Kawalan Akses: Hanya Admin
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    header("Location: ../public/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil dan bersihkan input
    $rhythmID = mysqli_real_escape_string($conn, $_POST['rhythmID']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $beatSpeed = intval($_POST['beatSpeed']);
    $difficulty = mysqli_real_escape_string($conn, $_POST['difficulty']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $source = mysqli_real_escape_string($conn, $_POST['source']); // JSON data

    // SQL Update
    $sql = "UPDATE rhythms SET 
            title = '$title', 
            beatSpeed = '$beatSpeed', 
            difficulty = '$difficulty', 
            description = '$description', 
            source = '$source' 
            WHERE rhythmID = '$rhythmID'";

    if ($conn->query($sql)) {
        header("Location: ../admin/rhythms.php?status=success&message=Irama berjaya dikemaskini!");
    } else {
        header("Location: ../admin/rhythms.php?status=error&message=Gagal mengemaskini irama: " . $conn->error);
    }
} else {
    header("Location: ../admin/rhythms.php");
}
$conn->close();
?>