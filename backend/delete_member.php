<?php
session_start();
include_once '../config/connection.php';

// 1. Kawalan Akses: Hanya Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../public/login.php");
    exit();
}

// 2. Semak jika ID dihantar
if (isset($_GET['id'])) {
    $userID = (int)$_GET['id'];

    // Mula Transaction (Supaya kedua-dua arahan SQL berjaya atau gagal serentak)
    $conn->begin_transaction();

    try {
        // A. Padam rekod dari table 'members'
        $sqlDeleteMember = "DELETE FROM members WHERE userID = ?";
        $stmtDelete = $conn->prepare($sqlDeleteMember);
        $stmtDelete->bind_param("i", $userID);
        $stmtDelete->execute();

        // B. Kemaskini peranan dalam table 'users' kepada 'user'
        $sqlUpdateRole = "UPDATE users SET role = 'user' WHERE userID = ?";
        $stmtUpdate = $conn->prepare($sqlUpdateRole);
        $roleDefault = 'user';
        $stmtUpdate->bind_param("i", $userID);
        $stmtUpdate->execute();

        // Jika semua OK, simpan perubahan
        $conn->commit();

        header("Location: ../admin/members.php?status=success&message=Ahli+berjaya+dikeluarkan+dan+diturunkan+pangkat+ke+user.");
        
    } catch (Exception $e) {
        // Jika ada ralat, batalkan semua perubahan
        $conn->rollback();
        header("Location: ../admin/members.php?status=error&message=Ralat+semasa+memproses:+".$e->getMessage());
    }

    $stmtDelete->close();
    $stmtUpdate->close();
    $conn->close();

} else {
    header("Location: ../admin/members.php?status=error&message=ID+pengguna+tidak+sah.");
}