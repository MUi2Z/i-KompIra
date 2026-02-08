<?php
session_start();
include_once '../config/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rhythmID    = mysqli_real_escape_string($conn, $_POST['rhythmID']);
    $title       = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $beatSpeed   = (int)$_POST['beatSpeed'];
    
    $newMidiName = "";
    $targetDir = "../uploads/rhythms/";

    // 1. Semak jika ada fail MIDI baharu
    if (isset($_FILES['midiSrc']) && $_FILES['midiSrc']['error'] == 0) {
        $fileExt = strtolower(pathinfo($_FILES["midiSrc"]["name"], PATHINFO_EXTENSION));

        if (in_array($fileExt, ['mid', 'midi'])) {
            $newMidiName = "rhythm_" . time() . "_" . uniqid() . "." . $fileExt;
            
            // Ambil nama fail lama untuk dipadam
            $res = $conn->query("SELECT midiSrc FROM rhythms WHERE rhythmID = '$rhythmID'");
            $oldData = $res->fetch_assoc();
            
            if (move_uploaded_file($_FILES["midiSrc"]["tmp_name"], $targetDir . $newMidiName)) {
                // Padam fail fizikal lama jika wujud
                if (!empty($oldData['midiSrc']) && file_exists($targetDir . $oldData['midiSrc'])) {
                    unlink($targetDir . $oldData['midiSrc']);
                }
            }
        }
    }

    // 2. Kemaskini Database secara Dinamik
    if (!empty($newMidiName)) {
        $sql = "UPDATE rhythms SET title=?, description=?, beatSpeed=?, midiSrc=?, updated_at=NOW() WHERE rhythmID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisi", $title, $description, $beatSpeed, $newMidiName, $rhythmID);
    } else {
        $sql = "UPDATE rhythms SET title=?, description=?, beatSpeed=?, updated_at=NOW() WHERE rhythmID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssis", $title, $description, $beatSpeed, $rhythmID);
    }

    if ($stmt->execute()) {
        header("Location: ../admin/rhythms.php?status=success&message=Irama+berjaya+dikemaskini.");
    } else {
        header("Location: ../admin/rhythms.php?status=error&message=Gagal+mengemaskini+irama.");
    }
    $stmt->close();
    $conn->close();
}