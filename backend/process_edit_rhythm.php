<?php
session_start();
include_once '../config/connection.php';

// Kawalan Akses: Hanya Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../public/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rhythmID    = mysqli_real_escape_string($conn, $_POST['rhythmID']);
    $title       = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $beatSpeed   = (int)$_POST['beatSpeed'];
    $difficulty  = mysqli_real_escape_string($conn, $_POST['difficulty']);
    
    $jsonDir  = "../uploads/rhythms/";
    $audioDir = "../uploads/audio/";

    // Ambil data lama untuk rujukan pemadaman fail
    $res = $conn->query("SELECT source, audio_path FROM rhythms WHERE rhythmID = '$rhythmID'");
    $oldData = $res->fetch_assoc();

    $newJsonName = $oldData['source']; // Default kekal lama
    $newAudioName = $oldData['audio_path']; // Default kekal lama

    // 1. Proses Fail JSON Baharu (Jika ada)
    if (isset($_FILES['source']) && $_FILES['source']['error'] == 0) {
        $jsonExt = strtolower(pathinfo($_FILES["source"]["name"], PATHINFO_EXTENSION));
        if ($jsonExt === 'json') {
            $newJsonName = "json_" . time() . "_" . uniqid() . ".json";
            if (move_uploaded_file($_FILES["source"]["tmp_name"], $jsonDir . $newJsonName)) {
                // Padam fail JSON lama jika wujud
                if (!empty($oldData['source']) && file_exists($jsonDir . $oldData['source'])) {
                    unlink($jsonDir . $oldData['source']);
                }
            }
        }
    }

    // 2. Proses Fail Audio Baharu (Jika ada)
    if (isset($_FILES['audio_path']) && $_FILES['audio_path']['error'] == 0) {
        $audioExt = strtolower(pathinfo($_FILES["audio_path"]["name"], PATHINFO_EXTENSION));
        $allowed = ['mp3', 'wav', 'ogg'];
        
        if (in_array($audioExt, $allowed)) {
            $newAudioName = "audio_" . time() . "_" . uniqid() . "." . $audioExt;
            if (move_uploaded_file($_FILES["audio_path"]["tmp_name"], $audioDir . $newAudioName)) {
                // Padam fail audio lama jika wujud
                if (!empty($oldData['audio_path']) && file_exists($audioDir . $oldData['audio_path'])) {
                    unlink($audioDir . $oldData['audio_path']);
                }
            }
        }
    }

    // 3. Kemaskini Database
    $sql = "UPDATE rhythms SET 
            title = ?, 
            description = ?, 
            beatSpeed = ?, 
            source = ?, 
            audio_path = ?, 
            difficulty = ?, 
            updated_at = NOW() 
            WHERE rhythmID = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisssi", $title, $description, $beatSpeed, $newJsonName, $newAudioName, $difficulty, $rhythmID);

    if ($stmt->execute()) {
        header("Location: ../admin/rhythms.php?status=success&message=Irama berjaya dikemaskini.");
    } else {
        header("Location: ../admin/rhythms.php?status=error&message=Ralat DB: " . urlencode($stmt->error));
    }

    $stmt->close();
    $conn->close();
}