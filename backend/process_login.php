<?php
session_start();
include '../config/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = trim($_POST['password']);

    // 1. Cari pengguna berdasarkan email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // 2. Semak kata laluan (password_verify untuk hash)
        if (password_verify($password, $user['password'])) {
            
            // 3. Set Session
            $_SESSION['userID'] = $user['userID'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['username'] = $user['userName'];

            // 4. Redirect mengikut Role
            if ($user['role'] === 'admin') {
                header("Location: ../admin/dashboard.php");
            } elseif ($user['role'] === 'member') {
                header("Location: ../member/profile.php");
            } else {
                header("Location: ../public/index.php");
            }
            exit();

        } else {
            $error = urlencode("Kata laluan salah!");
            header("Location: ../public/login.php?error=$error");
        }
    } else {
        $error = urlencode("Akaun tidak ditemui!");
        header("Location: ../public/login.php?error=$error");
    }
    
    $stmt->close();
    $conn->close();
}