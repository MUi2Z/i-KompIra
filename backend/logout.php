<?php
session_start();
session_unset(); // Kosongkan semua pembolehubah sesi
session_destroy(); // Musnahkan sesi sepenuhnya

// Redirect ke halaman utama
header("Location: ../public/index.php");
exit();
?>