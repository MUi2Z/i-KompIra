<?php
session_start();
include_once '../config/connection.php';

// 1. Kawalan Akses: Pastikan hanya Admin boleh padam
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    header("Location: ../public/login.php");
    exit();
}

// 2. Semak jika ID dihantar melalui URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $activityID = mysqli_real_escape_string($conn, $_GET['id']);

    // 3. Ambil nama fail gambar sebelum padam rekod (untuk delete fail fizikal)
    $sql_img = "SELECT activityThumbnail FROM activities WHERE activityID = '$activityID'";
    $result_img = $conn->query($sql_img);
    
    if ($result_img->num_rows > 0) {
        $row = $result_img->fetch_assoc();
        $imageName = $row['activityThumbnail'];
        $imagePath = "../uploads/activities/" . $imageName;

        // 4. Mula Proses Pemadaman Rekod
        // Gunakan Prepared Statement untuk keselamatan (SQL Injection)
        $stmt = $conn->prepare("DELETE FROM activities WHERE activityID = ?");
        $stmt->bind_param("s", $activityID);

        if ($stmt->execute()) {
            // 5. Jika rekod berjaya dipadam, padam fail gambar dari folder (jika bukan default/empty)
            if (!empty($imageName) && file_exists($imagePath)) {
                unlink($imagePath); // Padam fail fizikal
            }

            $status = "success";
            $message = "Aktiviti berjaya dipadamkan sepenuhnya.";
        } else {
            $status = "error";
            $message = "Gagal memadam rekod: " . $conn->error;
        }
        $stmt->close();
    } else {
        $status = "error";
        $message = "Aktiviti tidak dijumpai dalam pangkalan data.";
    }
} else {
    $status = "error";
    $message = "ID Aktiviti tidak sah.";
}

// 6. Kembali ke halaman pengurusan dengan status
header("Location: ../admin/activities.php?status=$status&message=" . urlencode($message));
exit();