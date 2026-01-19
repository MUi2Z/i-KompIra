<?php
    // Mulakan sesi untuk akses data sesi sedia ada
    session_start();
    
    // Kosongkan semua pembolehubah sesi
    $_SESSION = array();
    
    // Musnahkan sesi di server
    session_destroy();
    
    // Redirect ke halaman utama (index.php)
    header("Location: ../public/index.php");
    exit();
?>