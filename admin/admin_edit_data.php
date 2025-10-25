<?php
// Start the session to manage user data
session_start();

// --- MOCK USER DATA ---
// In a real application, this data would come from a database after the user logs in.
// We'll store it in the session for this example.
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 101;
    $_SESSION['user_email'] = 'lyv4memusic@gmail.com';
}

// --- VARIABLES ---
$email = $_SESSION['user_email'];
$message = '';
$message_type = ''; // 'success' or 'error'

// --- FORM PROCESSING LOGIC ---
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_account'])) {
    
    // 1. Get data from the form
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // 2. Validate the data
    if (empty($new_password) || empty($confirm_password)) {
        $message = 'Sila isi kedua-dua medan kata laluan.';
        $message_type = 'error';
    } elseif ($new_password !== $confirm_password) {
        $message = 'Kata laluan baru dan pengesahan kata laluan tidak sepadan.';
        $message_type = 'error';
    } else {
        // 3. Process the data (if validation passes)
        
        // Hash the new password for security
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        // --- DATABASE UPDATE SIMULATION ---
        // In a real application, you would run an UPDATE query here.
        // Example:
        // $userId = $_SESSION['user_id'];
        // $query = "UPDATE users SET password = ? WHERE id = ?";
        // $stmt = $pdo->prepare($query);
        // $stmt->execute([$hashed_password, $userId]);
        
        // For this example, we'll just show a success message.
        $message = 'Akaun anda telah berjaya dikemaskini!';
        $message_type = 'success';
    }
}
?>
