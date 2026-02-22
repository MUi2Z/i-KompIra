<?php
include_once '../config/connection.php';
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: ../public/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_account'])) {
    $uID = $_SESSION['userID'];
    $newUserName = trim($_POST['userName']);
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // 1. Update Username dahulu (Wajib)
    if (empty($newUserName)) {
        header("Location: " . $_SERVER['HTTP_REFERER'] . "?status=error&msg=Username tidak boleh kosong");
        exit();
    }

    // 2. Semak jika mahu tukar password
    if (!empty($newPassword)) {
        if ($newPassword !== $confirmPassword) {
            header("Location: " . $_SERVER['HTTP_REFERER'] . "?status=error&msg=Kata laluan tidak sepadan");
            exit();
        }
        if (strlen($newPassword) < 6) {
            header("Location: " . $_SERVER['HTTP_REFERER'] . "?status=error&msg=Kata laluan terlalu pendek");
            exit();
        }

        // Update Username & Password
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET userName = ?, password = ? WHERE userID = ?");
        $stmt->bind_param("ssi", $newUserName, $hashed, $uID);
    } else {
        // Update Username sahaja
        $stmt = $conn->prepare("UPDATE users SET userName = ? WHERE userID = ?");
        $stmt->bind_param("si", $newUserName, $uID);
    }

    if ($stmt->execute()) {
        // Update session supaya UI berubah serta-merta
        $_SESSION['userName'] = $newUserName;
        header("Location: " . $_SERVER['HTTP_REFERER'] . "?status=success");
    } else {
        header("Location: " . $_SERVER['HTTP_REFERER'] . "?status=error");
    }
    $stmt->close();
}