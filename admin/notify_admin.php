<?php
// notify_admin.php
function notifyAdminNewApplication($userID, $fullName, $conn) {
    $notif_sql = "INSERT INTO admin_notifications (userID, type, message, is_read) 
                  VALUES (?, 'new_member', ?, 0)";
    
    $notif_stmt = $conn->prepare($notif_sql);
    $message = "Permohonan ahli baru dari: " . $fullName . " (Masa: " . date('d/m/Y H:i:s') . ")";
    
    $notif_stmt->bind_param("is", $userID, $message);
    return $notif_stmt->execute();
}
?>