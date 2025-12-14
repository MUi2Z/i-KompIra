<?php
    // process_add_member.php

    // 1. Sertakan fail sambungan pangkalan data
    // Pastikan path ini betul berdasarkan lokasi fail process_add_member.php anda
    include '../config/connection.php'; 

    // 2. Semak jika borang dihantar melalui kaedah POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // 3. Ambil data dari borang dan bersihkan/validate
        // Gunakan fungsi trim() untuk membuang whitespace dan htmlspecialchars() untuk keselamatan XSS
        $fullName       = trim($_POST['fullName'] ?? '');
        $nric           = trim($_POST['NRIC'] ?? '');
        $programme      = trim($_POST['programme'] ?? '');
        $beatRoleType   = trim($_POST['beatRoleType'] ?? '');
        $kohort         = (int)($_POST['kohort'] ?? 0);
        $status         = trim($_POST['status'] ?? 'pending'); // Default to 'pending' or 'active'
        $userID         = (int)($_POST['userID'] ?? 0); // Pastikan ini datang dari SESSION ID pengguna yang log masuk sebenar

        // Validasi Asas
        if (empty($fullName) || empty($nric) || empty($programme) || empty($beatRoleType) || $kohort == 0 || $userID == 0) {
            // Redirect balik ke laman senarai dengan mesej ralat
            header("Location: ../admin/member_list.php?status=error&message=Sila%20lengkapkan%20semua%20medan%20yang%20diperlukan.");
            exit();
        }

        // 4. Sediakan pertanyaan SQL menggunakan Prepared Statements
        $sql = "INSERT INTO members (fullName, NRIC, programme, beatRoleType, kohort, status, userID) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        // Buat Prepared Statement
        if ($stmt = $conn->prepare($sql)) {

            // Ikat pemboleh ubah ke Prepared Statement sebagai parameter
            // s: string, i: integer
            $stmt->bind_param(
                "ssssisi", // Jenis data: 4 string, 1 integer, 1 string, 1 integer
                $fullName, 
                $nric, 
                $programme, 
                $beatRoleType, 
                $kohort, 
                $status,
                $userID 
            );

            // 5. Laksanakan Statement
            if ($stmt->execute()) {
                // Berjaya
                $message = urlencode("Ahli baru, $fullName, telah berjaya didaftarkan.");
                header("Location: ../admin/member_list.php?status=success&message=$message");
            } else {
                // Ralat pelaksanaan
                $message = urlencode("Ralat pendaftaran ahli: " . $stmt->error);
                header("Location: ../admin/member_list.php?status=error&message=$message");
            }

            // Tutup Statement
            $stmt->close();

        } else {
            // Ralat penyediaan Statement
            $message = urlencode("Ralat SQL (Prepare): " . $conn->error);
            header("Location: ../admin/member_list.php?status=error&message=$message");
        }

        // Tutup sambungan pangkalan data
        $conn->close();

    } else {
        // Jika tidak dihantar melalui POST, redirect kembali
        header("Location: ../admin/member_list.php");
        exit();
    }
?>