<?php
session_start();
include_once '../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $beatSpeed = intval($_POST['beatSpeed']);
    $difficulty = mysqli_real_escape_string($conn, $_POST['difficulty']);
    $source = mysqli_real_escape_string($conn, $_POST['source']); // Ambil JSON mentah
    $userID = $_SESSION['userID'];

    // Simpan ke DB
    $sql = "INSERT INTO rhythms (title, beatSpeed, difficulty, source, userID, created_at) 
            VALUES ('$title', $beatSpeed, '$difficulty', '$source', $userID, NOW())";

    if ($conn->query($sql)) {
        header("Location: ../admin/rhythms.php?status=success&message=Irama baru berjaya ditambah!");
    } else {
        header("Location: ../admin/rhythms.php?status=error&message=Gagal menyimpan data.");
    }
}