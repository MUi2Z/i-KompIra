<?php
session_start();
include_once '../config/connection.php';

// 1. Kawalan Akses
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    header("Location: ../public/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 2. Ambil data dari form modal
    $activityID    = mysqli_real_escape_string($conn, $_POST['activityID']);
    $activityTitle = mysqli_real_escape_string($conn, $_POST['activityTitle']);
    $activityDesc  = mysqli_real_escape_string($conn, $_POST['activityDesc']);
    
    // Flag untuk semak jika ada ralat fail
    $uploadOk = true;
    $newThumbnail = "";

    // 3. Logik Pengurusan Gambar
    if (isset($_FILES['activityThumbnail']) && $_FILES['activityThumbnail']['error'] === 0) {
        $targetDir = "../uploads/activities/";
        $fileName = time() . "_" . basename($_FILES["activityThumbnail"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Semak format fail
        $allowTypes = array('jpg', 'png', 'jpeg', 'webp');
        if (in_array(strtolower($fileType), $allowTypes)) {
            if (move_uploaded_file($_FILES["activityThumbnail"]["tmp_name"], $targetFilePath)) {
                $newThumbnail = $fileName;

                // Padam gambar lama dari folder untuk jimat ruang
                $result = $conn->query("SELECT activityThumbnail FROM activities WHERE activityID = '$activityID'");
                $oldData = $result->fetch_assoc();
                if ($oldData && !empty($oldData['activityThumbnail'])) {
                    $oldPath = $targetDir . $oldData['activityThumbnail'];
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
            } else {
                $uploadOk = false;
                $message = "Gagal memuat naik imej baharu.";
            }
        } else {
            $uploadOk = false;
            $message = "Format fail tidak disokong (Hanya JPG, PNG, WEBP).";
        }
    }

    if ($uploadOk) {
        // 4. Bina Query SQL Dynamically
        // Jika ada gambar baru, kemaskini sekali thumbnail. Jika tidak, kekalkan yang lama.
        if (!empty($newThumbnail)) {
            $sql = "UPDATE activities SET activityTitle = ?, activityDesc = ?, activityThumbnail = ?, updatedAt = NOW() WHERE activityID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $activityTitle, $activityDesc, $newThumbnail, $activityID);
        } else {
            $sql = "UPDATE activities SET activityTitle = ?, activityDesc = ?, updatedAt = NOW() WHERE activityID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $activityTitle, $activityDesc, $activityID);
        }

        if ($stmt->execute()) {
            $status = "success";
            $message = "Aktiviti berjaya dikemaskini!";
        } else {
            $status = "error";
            $message = "Ralat pangkalan data: " . $conn->error;
        }
        $stmt->close();
    } else {
        $status = "error";
        // $message sudah diisi di bahagian logik gambar
    }
} else {
    $status = "error";
    $message = "Capaian tidak sah.";
}

// 5. Kembali ke halaman utama dengan maklum balas
header("Location: ../admin/activities.php?status=$status&message=" . urlencode($message));
exit();