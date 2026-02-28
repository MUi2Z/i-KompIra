<?php
    // process_add_activity.php
    session_start();
    include_once '../config/connection.php';

    $target_dir = "../uploads/activities/";
    if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $activityTitle   = trim($_POST['activityTitle'] ?? '');
        $activityDesc    = trim($_POST['activityDesc'] ?? '');
        $trainDate       = $_POST['trainDate'];
        $showDate        = $_POST['showDate'];
        $location        = trim($_POST['location'] ?? '');
        $maxParticipants = (int)$_POST['maxParticipants'];
        $userID          = (int)($_POST['userID'] ?? 0); 
        $uniqueFilename  = NULL;

        // Validasi thumbnail
        if (isset($_FILES["activityThumbnail"]) && $_FILES["activityThumbnail"]["error"] == 0) {
            $file = $_FILES["activityThumbnail"];
            $fileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
            $uniqueFilename = uniqid('thumb_', true) . '.' . $fileType;
            move_uploaded_file($file["tmp_name"], $target_dir . $uniqueFilename);
        }

        // SQL updated dengan struktur baru
        $sql = "INSERT INTO activities (activityTitle, activityDesc, activityThumbnail, trainDate, showDate, maxParticipants, location, status, createdAt, updatedAt, userID) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 'open', NOW(), NOW(), ?)";

        if ($stmt = $conn->prepare($sql)) {
            // s = string, i = integer
            $stmt->bind_param("sssssisi", 
                $activityTitle, $activityDesc, $uniqueFilename, $trainDate, $showDate, $maxParticipants, $location, $userID
            );

            if ($stmt->execute()) {
                header("Location: ../admin/activities.php?status=success&message=Aktiviti+ditambah");
            } else {
                header("Location: ../admin/activities.php?status=error&message=" . urlencode($stmt->error));
            }
            $stmt->close();
        }
        $conn->close();
    }
?>