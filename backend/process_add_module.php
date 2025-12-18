<?php
// process_add_module.php

// Sertakan fail sambungan
include '../config/connection.php'; 

// Tetapan direktori muat naik
$thumbnail_dir = "../uploads/modules/thumbnails/"; 
$docs_dir = "../uploads/modules/documents/";

// Pastikan direktori muat naik wujud
if (!is_dir($thumbnail_dir)) { mkdir($thumbnail_dir, 0777, true); }
if (!is_dir($docs_dir)) { mkdir($docs_dir, 0777, true); }


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $moduleName     = trim($_POST['moduleName'] ?? '');
    $moduleDesc     = trim($_POST['moduleDesc'] ?? '');
    $userID         = (int)($_POST['userID'] ?? 0); 
    $thumbnailPath  = NULL;
    $docsPath       = NULL;
    $errorRedirect  = "Location: ../admin/module_list.php?status=error&message=";


    // Validasi Asas
    if (empty($moduleName) || empty($moduleDesc) || $userID == 0) {
        header($errorRedirect . urlencode("Sila lengkapkan semua medan yang diperlukan."));
        exit();
    }
    
    // ===================================
    // 1. Fungsi Bantuan Muat Naik Fail
    // ===================================

    /**
     * Mengendalikan pemprosesan muat naik satu fail
     * @param array $fileArray $_FILES array untuk fail tertentu
     * @param string $targetDir Direktori untuk menyimpan fail
     * @param array $allowedTypes Jenis fail yang dibenarkan (extensions)
     * @param int $maxSize Saiz maksimum fail dalam bytes
     * @param string $prefix Prefix untuk nama fail unik
     * @return string|false Path fail yang berjaya dimuat naik atau FALSE jika gagal
     */
    function handleFileUpload($fileArray, $targetDir, $allowedTypes, $maxSize, $prefix) {
    if ($fileArray["error"] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => "Ralat sistem muat naik."];
    }

    $fileType = strtolower(pathinfo($fileArray["name"], PATHINFO_EXTENSION));
    
    if ($fileArray["size"] > $maxSize) {
        return ['success' => false, 'message' => "Saiz fail terlalu besar."];
    }
    if (!in_array($fileType, $allowedTypes)) {
        return ['success' => false, 'message' => "Jenis fail tidak dibenarkan."];
    }

    $uniqueFilename = uniqid($prefix . '_', true) . '.' . $fileType;
    $target_file = $targetDir . $uniqueFilename;

    if (move_uploaded_file($fileArray["tmp_name"], $target_file)) {
        // Jika berjaya, pulangkan success = true dan path
        return ['success' => true, 'path' => $target_file];
    } else {
        return ['success' => false, 'message' => "Gagal memindahkan fail ke folder."];
    }
}


    // ===================================
    // 2. Proses Muat Naik Thumbnail
    // ===================================
    $thumbnailResult = handleFileUpload(
        $_FILES["moduleThumbnail"], 
        $thumbnail_dir, 
        ['jpg', 'jpeg', 'png', 'gif'], 
        5000000, 
        'thumb'
    );
    
    if (!$thumbnailResult['success']) {
        header($errorRedirect . urlencode("Ralat Thumbnail: " . $thumbnailResult['message']));
        exit();
    }
    $thumbnailPath = $thumbnailResult['path']; // Ambil path jika berjaya
    
    
    // ===================================
    // 3. Proses Muat Naik Dokumen
    // ===================================
    $docsResult = handleFileUpload(
        $_FILES["moduleDocs"], 
        $docs_dir, 
        ['pdf', 'doc', 'docx'], 
        10000000, 
        'doc'
    );
    
    if (!$docsResult['success']) {
        if (file_exists($thumbnailPath)) { unlink($thumbnailPath); }
        header($errorRedirect . urlencode("Ralat Dokumen: " . $docsResult['message']));
        exit();
    }
    $docsPath = $docsResult['path']; // Ambil path jika berjaya


    // ===================================
    // 4. Masukkan Data ke Pangkalan Data
    // ===================================
    $sql = "INSERT INTO modules (moduleName, moduleDesc, moduleThumbnail, moduleDocs, created_at, updated_at, userID) 
            VALUES (?, ?, ?, ?, NOW(), NOW(), ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        
        // Ikat pemboleh ubah: 4 string, 1 integer
        $stmt->bind_param("ssssi", 
            $moduleName, 
            $moduleDesc, 
            $thumbnailPath, 
            $docsPath, 
            $userID 
        );
        
        if ($stmt->execute()) {
            $message = urlencode("Modul '$moduleName' telah berjaya ditambahkan.");
            header("Location: ../admin/module_list.php?status=success&message=$message");
        } else {
            // Jika ralat DB, padam kedua-dua fail yang dimuat naik
            if (file_exists($thumbnailPath)) { unlink($thumbnailPath); }
            if (file_exists($docsPath)) { unlink($docsPath); }
            header($errorRedirect . urlencode("Ralat pangkalan data: " . $stmt->error));
        }

        $stmt->close();
        
    } else {
        header($errorRedirect . urlencode("Ralat SQL (Prepare): " . $conn->error));
    }

    $conn->close();

} else {
    header("Location: ../admin/module_list.php");
    exit();
}
?>