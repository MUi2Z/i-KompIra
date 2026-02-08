<?php
session_start();
include_once '../config/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title       = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $beatSpeed   = (int)$_POST['beatSpeed'];
    $userID      = (int)$_POST['userID'];
    
    $targetDir = "../uploads/rhythms/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

    $fileName = NULL;

    // Logik Muat Naik MIDI
    if (isset($_FILES['midiSrc']) && $_FILES['midiSrc']['error'] == 0) {
        $fileExt = strtolower(pathinfo($_FILES["midiSrc"]["name"], PATHINFO_EXTENSION));
        
        // Hanya benarkan .mid atau .midi
        if (in_array($fileExt, ['mid', 'midi'])) {
            $fileName = "rhythm_" . time() . "_" . uniqid() . "." . $fileExt;
            $targetFilePath = $targetDir . $fileName;

            if (!move_uploaded_file($_FILES["midiSrc"]["tmp_name"], $targetFilePath)) {
                header("Location: ../admin/rhythms.php?status=error&message=Gagal+muat+naik+fail+MIDI.");
                exit();
            }
        } else {
            header("Location: ../admin/rhythms.php?status=error&message=Format+fail+tidak+sah.+Sila+guna+.mid+atau+.midi");
            exit();
        }
    }

    $sql = "INSERT INTO rhythms (title, description, beatSpeed, midiSrc, userID, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisi", $title, $description, $beatSpeed, $fileName, $userID);

    if ($stmt->execute()) {
        header("Location: ../admin/rhythms.php?status=success&message=Irama+berjaya+ditambah!");
    } else {
        header("Location: ../admin/rhythms.php?status=error&message=Ralat+DB:+" . urlencode($stmt->error));
    }
    $stmt->close();
    $conn->close();
}