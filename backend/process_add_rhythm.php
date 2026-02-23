<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include_once '../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? null;
    $beatSpeed = intval($_POST['beatSpeed'] ?? 5);
    $source = $_POST['source'] ?? ''; 
    $difficulty = $_POST['difficulty'] ?? 'Mudah';
    $userID = intval($_SESSION['userID'] ?? 0);

    // Semak jika JSON kosong
    if (empty($source) || strlen($source) < 5) {
        die("Ralat: Data JSON tidak sah atau terlalu pendek.");
    }

    // Pastikan susunan bind_param sepadan dengan susunan VALUES dalam SQL
    $sql = "INSERT INTO rhythms (title, description, beatSpeed, source, difficulty, userID, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";
    
    $stmt = $conn->prepare($sql);
    
    // Jenis data: 
    // s (title), s (description), i (beatSpeed), s (source), s (difficulty), i (userID)
    $stmt->bind_param("ssissi", $title, $description, $beatSpeed, $source, $difficulty, $userID);

    if ($stmt->execute()) {
        header("Location: ../admin/rhythms.php?status=success&message=Irama berjaya ditambah!");
        exit();
    } else {
        die("SQL Error: " . $stmt->error);
    }
}