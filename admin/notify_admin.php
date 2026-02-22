<?php
// admin/notify_admin.php

function notifyAdminNewApplication($userID, $fullName, $NRIC, $conn) {
    $type = 'membership_application';
    $title = 'Permohonan Ahli Baru';
    $message = "Pengguna $fullName ($NRIC) telah menghantar permohonan menjadi ahli baru.";
    
    // Pastikan susunan kolum sama dengan struktur table anda
    $sql = "INSERT INTO admin_notifications (userID, type, title, message, is_read, created_at) 
            VALUES (?, ?, ?, ?, 0, NOW())";
            
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("isss", $userID, $type, $title, $message);
        return $stmt->execute();
    }
    
    return false;
}