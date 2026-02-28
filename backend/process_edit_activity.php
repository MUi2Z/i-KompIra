<?php
session_start();
include_once '../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $activityID      = $_POST['activityID'];
    $activityTitle   = $_POST['activityTitle'];
    $activityDesc    = $_POST['activityDesc'];
    $trainDate       = $_POST['trainDate'];
    $showDate        = $_POST['showDate'];
    $location        = $_POST['location'];
    $status          = $_POST['status'];
    $newThumbnail    = "";

    // Logik Gambar
    if (isset($_FILES['activityThumbnail']) && $_FILES['activityThumbnail']['error'] === 0) {
        $targetDir = "../uploads/activities/";
        $fileName = time() . "_" . basename($_FILES["activityThumbnail"]["name"]);
        if (move_uploaded_file($_FILES["activityThumbnail"]["tmp_name"], $targetDir . $fileName)) {
            $newThumbnail = $fileName;
        }
    }

// Jika ada gambar baru (Update dengan 8 pembolehubah)
if (!empty($newThumbnail)) {
    $sql = "UPDATE activities SET activityTitle=?, activityDesc=?, activityThumbnail=?, trainDate=?, showDate=?, location=?, status=?, updatedAt=NOW() WHERE activityID=?";
    $stmt = $conn->prepare($sql);
    // Ada 8 pembolehubah: 7 string (s) + 1 integer (i) untuk ID
    $stmt->bind_param("sssssssi", $activityTitle, $activityDesc, $newThumbnail, $trainDate, $showDate, $location, $status, $activityID);
} 
// Jika TIADA gambar baru (Update dengan 7 pembolehubah)
else {
    $sql = "UPDATE activities SET activityTitle=?, activityDesc=?, trainDate=?, showDate=?, location=?, status=?, updatedAt=NOW() WHERE activityID=?";
    $stmt = $conn->prepare($sql);
    // Ada 7 pembolehubah: 6 string (s) + 1 integer (i) untuk ID
    // SEBELUM INI MUNGKIN ANDA LETAK "sssssssi", SEPATUTNYA "ssssssi"
    $stmt->bind_param("ssssssi", $activityTitle, $activityDesc, $trainDate, $showDate, $location, $status, $activityID);
}

    if ($stmt->execute()) {
        header("Location: ../admin/activities.php?status=success&message=Data+dikemaskini");
    } else {
        header("Location: ../admin/activities.php?status=error&message=" . urlencode($conn->error));
    }
}
?>