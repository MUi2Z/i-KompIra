<?php
session_start();
include '../config/connection.php'; 

// Tetapan direktori (Pastikan path ini betul mengikut struktur folder anda)
$thumbnail_dir = "../uploads/modules/thumbs/"; 
$docs_dir      = "../uploads/modules/docs/";

// Pastikan direktori muat naik wujud
if (!is_dir($thumbnail_dir)) { mkdir($thumbnail_dir, 0777, true); }
if (!is_dir($docs_dir)) { mkdir($docs_dir, 0777, true); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $moduleName    = trim($_POST['moduleName'] ?? '');
    $moduleDesc    = trim($_POST['moduleDesc'] ?? '');
    $userID        = (int)($_POST['userID'] ?? 0); 
    $errorRedirect = "Location: ../admin/modules.php?status=error&message=";

    // 1. Validasi Input Asas
    if (empty($moduleName) || empty($moduleDesc) || $userID == 0) {
        header($errorRedirect . urlencode("Sila lengkapkan semua medan yang diperlukan."));
        exit();
    }

    // ===================================
    // 2. Fungsi Pengendalian Muat Naik
    // ===================================
    function handleFileUpload($fileArray, $targetDir, $allowedTypes, $maxSize, $prefix) {
        if (!isset($fileArray) || $fileArray["error"] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => "Fail tidak dikesan atau ralat sistem."];
        }

        $fileType = strtolower(pathinfo($fileArray["name"], PATHINFO_EXTENSION));
        
        if ($fileArray["size"] > $maxSize) {
            return ['success' => false, 'message' => "Saiz fail melebihi had yang dibenarkan."];
        }
        if (!in_array($fileType, $allowedTypes)) {
            return ['success' => false, 'message' => "Format .$fileType tidak dibenarkan."];
        }

        // Simpan hanya nama fail unik dalam DB
        $uniqueFilename = uniqid($prefix . '_', true) . '.' . $fileType;
        $destination = $targetDir . $uniqueFilename;

        if (move_uploaded_file($fileArray["tmp_name"], $destination)) {
            return ['success' => true, 'filename' => $uniqueFilename];
        } else {
            return ['success' => false, 'message' => "Gagal menyimpan fail ke pelayan."];
        }
    }

    // ===================================
    // 3. Proses Muat Naik
    // ===================================

    // Muat naik Thumbnail (Had 5MB)
    $thumbRes = handleFileUpload($_FILES["moduleThumbnail"], $thumbnail_dir, ['jpg', 'jpeg', 'png'], 5000000, 'thumb');
    if (!$thumbRes['success']) {
        header($errorRedirect . urlencode("Ralat Imej: " . $thumbRes['message']));
        exit();
    }

    // Muat naik Dokumen (Had 10MB)
    $docsRes = handleFileUpload($_FILES["moduleDocs"], $docs_dir, ['pdf', 'doc', 'docx'], 10000000, 'doc');
    if (!$docsRes['success']) {
        // Padam semula thumbnail jika dokumen gagal
        if (file_exists($thumbnail_dir . $thumbRes['filename'])) { unlink($thumbnail_dir . $thumbRes['filename']); }
        header($errorRedirect . urlencode("Ralat Dokumen: " . $docsRes['message']));
        exit();
    }

    // ===================================
    // 4. Simpan ke Database (Struktur Baru)
    // ===================================
    
    // Gunakan nama kolum createdAt & updatedAt mengikut cadangan struktur tadi
    $sql = "INSERT INTO modules (moduleName, moduleDesc, moduleThumbnail, moduleDocs, createdAt, updatedAt, userID) 
            VALUES (?, ?, ?, ?, NOW(), NOW(), ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssi", 
            $moduleName, 
            $moduleDesc, 
            $thumbRes['filename'], 
            $docsRes['filename'], 
            $userID 
        );
        
        if ($stmt->execute()) {
            header("Location: ../admin/modules.php?status=success&message=" . urlencode("Modul berjaya ditambah!"));
        } else {
            // Padam fail jika DB gagal
            unlink($thumbnail_dir . $thumbRes['filename']);
            unlink($docs_dir . $docsRes['filename']);
            header($errorRedirect . urlencode("Ralat DB: " . $stmt->error));
        }
        $stmt->close();
    } else {
        header($errorRedirect . urlencode("Ralat SQL Prepare."));
    }

    $conn->close();
} else {
    header("Location: ../admin/modules.php");
    exit();
}