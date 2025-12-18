<?php
include '../config/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // 1. Validasi: Pastikan kata laluan sepadan
    if ($password !== $confirm_password) {
        header("Location: ../public/register.php?error=" . urlencode("Kata laluan tidak sepadan!"));
        exit();
    }

    // 2. Semak jika email sudah didaftarkan
    $checkEmail = $conn->prepare("SELECT userID FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        header("Location: ../public/register.php?error=" . urlencode("Email ini sudah digunakan!"));
        exit();
    }

    // 3. Hash Kata Laluan untuk keselamatan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $default_role = 'user';

    // 4. Masukkan ke dalam Pangkalan Data
    $sql = "INSERT INTO users (email, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $email, $hashed_password, $default_role);

    if ($stmt->execute()) {
        // Berjaya! Hantar ke login dengan mesej kejayaan
        header("Location: ../public/login.php?success=" . urlencode("Akaun berjaya dicipta. Sila log masuk."));
    } else {
        header("Location: ../public/register.php?error=" . urlencode("Ralat sistem: " . $conn->error));
    }

    $stmt->close();
    $conn->close();
}