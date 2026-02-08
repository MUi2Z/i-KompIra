<?php
session_start();
include_once '../config/connection.php';

// 1. Kawalan Akses: Hanya Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../public/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $moduleID = (int)$_GET['id'];
    $targetDir = "../uploads/modules/";

    // 2. Ambil nama fail sebelum rekod dipadam
    $sqlFetch = "SELECT moduleThumbnail, moduleDocs FROM modules WHERE moduleID = ?";
    $stmtFetch = $conn->prepare($sqlFetch);
    $stmtFetch->bind_param("i", $moduleID);
    $stmtFetch->execute();
    $result = $stmtFetch->get_result();

    if ($result->num_rows > 0) {
        $module = $result->fetch_assoc();
        $thumbFile = $module['moduleThumbnail'];
        $docFile = $module['moduleDocs'];

        // 3. Padam rekod dari pangkalan data
        $sqlDelete = "DELETE FROM modules WHERE moduleID = ?";
        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->bind_param("i", $moduleID);

        if ($stmtDelete->execute()) {
            // 4. Padam fail fizikal dari server jika wujud
            if (!empty($thumbFile) && file_exists($targetDir . $thumbFile)) {
                unlink($targetDir . $thumbFile);
            }
            if (!empty($docFile) && file_exists($targetDir . $docFile)) {
                unlink($targetDir . $docFile);
            }

            header("Location: ../admin/modules.php?status=success&message=Modul+dan+fail+berkaitan+telah+dipadam.");
        } else {
            header("Location: ../admin/modules.php?status=error&message=Gagal+memadam+modul+dari+pangkalan+data.");
        }
        $stmtDelete->close();
    } else {
        header("Location: ../admin/modules.php?status=error&message=Modul+tidak+ditemui.");
    }

    $stmtFetch->close();
    $conn->close();
} else {
    header("Location: ../admin/modules.php?status=error&message=ID+modul+tidak+sah.");
}