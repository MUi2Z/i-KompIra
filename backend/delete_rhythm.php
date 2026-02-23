<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once '../config/connection.php';

// Kawalan Akses: Hanya Admin yang boleh padam
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    header("Location: ../public/login.php");
    exit();
}

// Semak jika ID wujud dalam URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Gunakan Prepared Statement untuk keselamatan
    $sql = "DELETE FROM rhythms WHERE rhythmID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Jika berjaya padam
        header("Location: ../admin/rhythms.php?status=success&message=Irama berjaya dipadam secara kekal.");
    } else {
        // Jika gagal (mungkin ada masalah kekangan kunci asing)
        header("Location: ../admin/rhythms.php?status=error&message=Gagal memadam irama: " . $stmt->error);
    }

    $stmt->close();
} else {
    // Jika ID tidak dihantar
    header("Location: ../admin/rhythms.php?status=error&message=ID irama tidak sah.");
}

$conn->close();
exit();
?>