<?php
session_start();
include_once '../config/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $profileID    = $_POST['profileID'];
    $userID       = $_POST['userID'];
    $email        = mysqli_real_escape_string($conn, $_POST['email']);
    $fullName     = mysqli_real_escape_string($conn, $_POST['fullName']);
    $NRIC         = mysqli_real_escape_string($conn, $_POST['NRIC']);
    $programme    = $_POST['programme'];
    $beatRoleType = $_POST['beatRoleType'];
    $kohort       = (int)$_POST['kohort'];
    $password     = $_POST['password'];

    // 1. Kemaskini Jadual Users (Email & Password jika diisi)
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sqlUser = "UPDATE users SET email = ?, password = ? WHERE userID = ?";
        $stmtUser = $conn->prepare($sqlUser);
        $stmtUser->bind_param("ssi", $email, $hashedPassword, $userID);
    } else {
        $sqlUser = "UPDATE users SET email = ? WHERE userID = ?";
        $stmtUser = $conn->prepare($sqlUser);
        $stmtUser->bind_param("si", $email, $userID);
    }
    $stmtUser->execute();

    // 2. Kemaskini Jadual Members
    $sqlMember = "UPDATE members SET fullName=?, NRIC=?, programme=?, beatRoleType=?, kohort=?, updated_at=NOW() WHERE profileID=?";
    $stmtMember = $conn->prepare($sqlMember);
    $stmtMember->bind_param("ssssii", $fullName, $NRIC, $programme, $beatRoleType, $kohort, $profileID);

    if ($stmtMember->execute()) {
        header("Location: ../admin/members.php?status=success&message=Maklumat+ahli+dikemaskini.");
    } else {
        header("Location: ../admin/members.php?status=error&message=Gagal+kemaskini+ahli.");
    }
}