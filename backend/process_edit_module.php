<?php
session_start();
require_once '../config/connection.php';

// Semakan akses Admin
if (!isset($_SESSION['userID']) || $_SESSION['role'] !== 'admin') {
    exit("Akses tidak dibenarkan");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $moduleID   = $_POST['moduleID'];
    $moduleName = $_POST['moduleName'];
    $moduleDesc = $_POST['moduleDesc'];
    
    // Path folder mengikut struktur yang anda berikan
    $thumbDir = "../uploads/modules/thumbs/";
    $docDir   = "../uploads/modules/docs/";

    // Ambil data lama untuk proses pemadaman fail asal
    $stmtOld = $conn->prepare("SELECT moduleThumbnail, moduleDocs FROM modules WHERE moduleID = ?");
    $stmtOld->bind_param("i", $moduleID);
    $stmtOld->execute();
    $oldData = $stmtOld->get_result()->fetch_assoc();

    $newThumb = $oldData['moduleThumbnail'];
    $newDoc   = $oldData['moduleDocs'];

    // 1. Logik Muat Naik Thumbnail (Jika ada)
    if (!empty($_FILES['moduleThumbnail']['name'])) {
        $newThumb = time() . "_thumb_" . $_FILES['moduleThumbnail']['name'];
        if (move_uploaded_file($_FILES['moduleThumbnail']['tmp_name'], $thumbDir . $newThumb)) {
            // Padam fail lama jika wujud
            if (!empty($oldData['moduleThumbnail']) && file_exists($thumbDir . $oldData['moduleThumbnail'])) {
                unlink($thumbDir . $oldData['moduleThumbnail']);
            }
        }
    }

    // 2. Logik Muat Naik Dokumen (Jika ada)
    if (!empty($_FILES['moduleDocs']['name'])) {
        $newDoc = time() . "_doc_" . $_FILES['moduleDocs']['name'];
        if (move_uploaded_file($_FILES['moduleDocs']['tmp_name'], $docDir . $newDoc)) {
            // Padam fail lama jika wujud
            if (!empty($oldData['moduleDocs']) && file_exists($docDir . $oldData['moduleDocs'])) {
                unlink($docDir . $oldData['moduleDocs']);
            }
        }
    }

    // 3. Kemaskini Semua Data Menggunakan Prepared Statement (Format seperti Aktiviti)
    $sql = "UPDATE modules SET 
            moduleName = ?, 
            moduleDesc = ?, 
            moduleThumbnail = ?, 
            moduleDocs = ?, 
            updatedAt = NOW() 
            WHERE moduleID = ?";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $moduleName, $moduleDesc, $newThumb, $newDoc, $moduleID);

    if ($stmt->execute()) {
        header("Location: ../admin/view_module.php?id=$moduleID&status=success&message=Modul berjaya dikemaskini");
    } else {
        header("Location: ../admin/view_module.php?id=$moduleID&status=error&message=Gagal mengemaskini pangkalan data");
    }
    $stmt->close();
    $conn->close();
}