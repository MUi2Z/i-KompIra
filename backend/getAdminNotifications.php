<?php
// getAdminNotifications.php
function getUnreadAdminNotifications($conn, $limit = 10) {
    $sql = "SELECT n.*, u.email, u.username 
            FROM admin_notifications n
            LEFT JOIN users u ON n.userID = u.userID
            WHERE n.is_read = 0
            ORDER BY 
                CASE n.priority 
                    WHEN 'urgent' THEN 1
                    WHEN 'high' THEN 2
                    WHEN 'medium' THEN 3
                    WHEN 'low' THEN 4
                END,
                n.created_at DESC
            LIMIT ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    return $stmt->get_result();
}

function markNotificationAsRead($notificationID, $adminID, $conn) {
    $sql = "UPDATE admin_notifications 
            SET is_read = 1, read_at = NOW(), read_by_admin = ?
            WHERE notificationID = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $adminID, $notificationID);
    return $stmt->execute();
}
?>