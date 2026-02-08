<?php
session_start();
include_once '../config/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $moduleID   = $_POST['moduleID'];
    $moduleName = mysqli_real_escape_string($conn, $_POST['moduleName']);
    $moduleDesc = mysqli_real_escape_string($conn, $_POST['moduleDesc']);
    
    $targetDir = "../uploads/modules/";
    
    // Ambil data lama untuk proses padam fail asal
    $oldData = $conn->query("SELECT moduleThumbnail, moduleDocs FROM modules WHERE moduleID = '$moduleID'")->fetch_assoc();

    // Logik Imej Thumbnail
    if (!empty($_FILES['moduleThumbnail']['name'])) {
        $thumbName = time() . "_thumb_" . $_FILES['moduleThumbnail']['name'];
        move_uploaded_file($_FILES['moduleThumbnail']['tmp_name'], $targetDir . $thumbName);
        if (file_exists($targetDir . $oldData['moduleThumbnail'])) unlink($targetDir . $oldData['moduleThumbnail']);
        $conn->query("UPDATE modules SET moduleThumbnail = '$thumbName' WHERE moduleID = '$moduleID'");
    }

    // Logik Dokumen PDF
    if (!empty($_FILES['moduleDocs']['name'])) {
        $docName = time() . "_doc_" . $_FILES['moduleDocs']['name'];
        move_uploaded_file($_FILES['moduleDocs']['tmp_name'], $targetDir . $docName);
        if (file_exists($targetDir . $oldData['moduleDocs'])) unlink($targetDir . $oldData['moduleDocs']);
        $conn->query("UPDATE modules SET moduleDocs = '$docName' WHERE moduleID = '$moduleID'");
    }

    // Kemaskini Teks
    $sql = "UPDATE modules SET moduleName=?, moduleDesc=?, updatedAt=NOW() WHERE moduleID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $moduleName, $moduleDesc, $moduleID);

    if ($stmt->execute()) {
        header("Location: ../admin/modules.php?status=success&message=Modul+berjaya+dikemaskini.");
    } else {
        header("Location: ../admin/modules.php?status=error&message=Gagal+kemaskini+modul.");
    }
}