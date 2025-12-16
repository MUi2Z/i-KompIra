<?php
    // process_add_activity.php

    // Sertakan fail sambungan
    include '../config/connection.php'; 

    // Tetapan direktori muat naik (UBAH INI MENGIKUT KEPERLUAN ANDA)
    $target_dir = "../uploads/activities/"; 

    // Pastikan direktori muat naik wujud
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $activityTittle  = trim($_POST['activityTittle'] ?? '');
        $activityDesc   = trim($_POST['activityDesc'] ?? '');
        $userID         = (int)($_POST['userID'] ?? 0); 
        $thumbnailPath  = NULL; // Akan menyimpan path fail yang dimuat naik

        // Validasi Asas
        if (empty($activityTittle) || empty($activityDesc) || $userID == 0) {
            $message = urlencode("Sila lengkapkan semua medan yang diperlukan.");
            header("Location: ../admin/activity_list.php?status=error&message=$message");
            exit();
        }

        // ===================================
        // 1. Proses Muat Naik Fail (Thumbnail)
        // ===================================
        if (isset($_FILES["activityThumbnail"]) && $_FILES["activityThumbnail"]["error"] == 0) {
            $file = $_FILES["activityThumbnail"];
            $fileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
            $uniqueFilename = uniqid('thumb_', true) . '.' . $fileType;
            $target_file = $target_dir . $uniqueFilename;

            // Semak saiz, jenis, dan cuba pindahkan fail
            if ($file["size"] > 5000000) { // Had 5MB
                $message = urlencode("Ralat muat naik: Saiz imej terlalu besar.");
                header("Location: ../admin/activity_list.php?status=error&message=$message");
                exit();
            }
            if (!in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                $message = urlencode("Ralat muat naik: Hanya format JPG, JPEG, PNG & GIF dibenarkan.");
                header("Location: ../admin/activity_list.php?status=error&message=$message");
                exit();
            }

            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                $thumbnailPath = $target_file;
            } else {
                $message = urlencode("Ralat muat naik: Gagal memindahkan fail.");
                header("Location: ../admin/activity_list.php?status=error&message=$message");
                exit();
            }
        } else {
            $message = urlencode("Ralat muat naik imej: Tiada fail dipilih atau ralat berlaku.");
            header("Location: ../admin/activity_list.php?status=error&message=$message");
            exit();
        }

        // ===================================
        // 2. Masukkan Data ke Pangkalan Data
        // ===================================
        $sql = "INSERT INTO activities (activityTittle, activityDesc, activityThumbnail, createdAt, updatedAt, userID) 
                VALUES (?, ?, ?, NOW(), NOW(), ?)";

        if ($stmt = $conn->prepare($sql)) {

            // Ikat pemboleh ubah: 3 string, 1 integer
            $stmt->bind_param("sssi", 
                $activityTittle, 
                $activityDesc, 
                $thumbnailPath, // Simpan path fail yang dimuat naik
                $userID 
            );

            if ($stmt->execute()) {
                $message = urlencode("Aktiviti '$activityTittle' telah berjaya ditambahkan.");
                header("Location: ../admin/activity_list.php?status=success&message=$message");
            } else {
                // Jika ralat DB, padam fail yang dimuat naik (rollback manual)
                if (file_exists($thumbnailPath)) {
                    unlink($thumbnailPath);
                }
                $message = urlencode("Ralat pangkalan data: " . $stmt->error);
                header("Location: ../admin/activity_list.php?status=error&message=$message");
            }

            $stmt->close();

        } else {
            $message = urlencode("Ralat SQL (Prepare): " . $conn->error);
            header("Location: ../admin/activity_list.php?status=error&message=$message");
        }

        $conn->close();

    } else {
        header("Location: ../admin/activity_list.php");
        exit();
    }
?>