<?php
    // process_add_activity.php
    session_start();
    include_once '../config/connection.php';

    $target_dir = "../uploads/activities/";

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $activityTitle  = trim($_POST['activityTitle'] ?? '');
        $activityDesc   = trim($_POST['activityDesc'] ?? '');
        $userID         = (int)($_POST['userID'] ?? 0); 
        $uniqueFilename = NULL; // Kita akan simpan nama fail sahaja di sini

        if (empty($activityTitle) || empty($activityDesc) || $userID == 0) {
            $message = urlencode("Sila lengkapkan semua medan yang diperlukan.");
            header("Location: ../admin/activities.php?status=error&message=$message");
            exit();
        }

        if (isset($_FILES["activityThumbnail"]) && $_FILES["activityThumbnail"]["error"] == 0) {
            $file = $_FILES["activityThumbnail"];
            $fileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
            
            // Mencipta nama fail unik
            $uniqueFilename = uniqid('thumb_', true) . '.' . $fileType;
            $target_file = $target_dir . $uniqueFilename;

            if ($file["size"] > 5000000) { 
                $message = urlencode("Ralat muat naik: Saiz imej terlalu besar.");
                header("Location: ../admin/activities.php?status=error&message=$message");
                exit();
            }

            if (!in_array($fileType, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $message = urlencode("Ralat muat naik: Format tidak dibenarkan.");
                header("Location: ../admin/activities.php?status=error&message=$message");
                exit();
            }

            if (!move_uploaded_file($file["tmp_name"], $target_file)) {
                $message = urlencode("Ralat muat naik: Gagal memindahkan fail.");
                header("Location: ../admin/activities.php?status=error&message=$message");
                exit();
            }
        } else {
            $message = urlencode("Sila muat naik imej thumbnail.");
            header("Location: ../admin/activities.php?status=error&message=$message");
            exit();
        }

        // PERBAIKAN DI SINI:
        // Pastikan nama kolom di SQL (createdAt, updatedAt) sama dengan di database anda
        $sql = "INSERT INTO activities (activityTitle, activityDesc, activityThumbnail, createdAt, updatedAt, userID) 
                VALUES (?, ?, ?, NOW(), NOW(), ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Kita gunakan $uniqueFilename yang kita buat di atas tadi
            $stmt->bind_param("sssi", 
                $activityTitle, 
                $activityDesc, 
                $uniqueFilename, 
                $userID
            );

            if ($stmt->execute()) {
                $message = urlencode("Aktiviti berjaya ditambahkan.");
                header("Location: ../admin/activities.php?status=success&message=$message");
            } else {
                // Rollback: Padam fail jika DB gagal
                if ($uniqueFilename && file_exists($target_dir . $uniqueFilename)) {
                    unlink($target_dir . $uniqueFilename);
                }
                $message = urlencode("Ralat DB: " . $stmt->error);
                header("Location: ../admin/activities.php?status=error&message=$message");
            }
            $stmt->close();
        } else {
            $message = urlencode("Ralat SQL: " . $conn->error);
            header("Location: ../admin/activities.php?status=error&message=$message");
        }
        $conn->close();
    }
?>