<?php
// backend/process_add_member.php
include '../config/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password!
    $fullName = $_POST['fullName'];
    $nric = $_POST['NRIC'];
    $programme = $_POST['programme'];
    $beatRoleType = $_POST['beatRoleType'];
    $kohort = $_POST['kohort'];
    $status = 'active'; // Admin tambah terus jadi active
    $role = 'member';   // Admin tambah terus jadi member

    // Mulakan Transaksi SQL
    $conn->begin_transaction();

    try {
        // 1. Masukkan ke jadual USERS
        $stmt1 = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
        $stmt1->bind_param("sss", $email, $password, $role);
        $stmt1->execute();
        
        // Ambil userID yang baru dicipta
        $newUserID = $conn->insert_id;

        // 2. Masukkan ke jadual MEMBER_PROFILES
        $stmt2 = $conn->prepare("INSERT INTO members (userID, fullName, NRIC, programme, beatRoleType, kohort, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt2->bind_param("issssss", $newUserID, $fullName, $nric, $programme, $beatRoleType, $kohort, $status);
        $stmt2->execute();

        // Jika semua OK, commit
        $conn->commit();
        header("Location: ../admin/member_list.php?status=success&message=Ahli baru berjaya didaftarkan");

    } catch (Exception $e) {
        // Jika ralat, batalkan semua (rollback)
        $conn->rollback();
        header("Location: ../admin/member_list.php?status=error&message=Gagal daftar: " . $e->getMessage());
    }
}
?>