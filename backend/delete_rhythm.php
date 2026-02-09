<?php
session_start();
include_once '../config/connection.php';

// 1. Kawalan Akses: Hanya Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../public/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $rhythmID = (int)$_GET['id'];
    $targetDir = "../uploads/rhythms/";

    // 2. Ambil nama fail MIDI sebelum rekod dipadam
    $sqlFetch = "SELECT midiSrc FROM rhythms WHERE rhythmID = ?";
    $stmtFetch = $conn->prepare($sqlFetch);
    $stmtFetch->bind_param("i", $rhythmID);
    $stmtFetch->execute();
    $result = $stmtFetch->get_result();

    if ($result->num_rows > 0) {
        $rhythm = $result->fetch_assoc();
        $midiFile = $rhythm['midiSrc'];

        // 3. Padam rekod dari pangkalan data
        $sqlDelete = "DELETE FROM rhythms WHERE rhythmID = ?";
        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->bind_param("i", $rhythmID);

        if ($stmtDelete->execute()) {
            // 4. Padam fail fizikal (.mid) dari server jika wujud
            if (!empty($midiFile) && file_exists($targetDir . $midiFile)) {
                unlink($targetDir . $midiFile);
            }

            header("Location: ../admin/rhythms.php?status=success&message=Irama+berjaya+dipadam+secara+kekal.");
        } else {
            header("Location: ../admin/rhythms.php?status=error&message=Gagal+memadam+rekod+irama.");
        }
        $stmtDelete->close();
    } else {
        header("Location: ../admin/rhythms.php?status=error&message=Irama+tidak+ditemui.");
    }

    $stmtFetch->close();
    $conn->close();
} else {
    header("Location: ../admin/rhythms.php?status=error&message=ID+irama+tidak+sah.");
}