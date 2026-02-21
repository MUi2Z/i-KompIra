<?php
session_start();
include_once '../config/connection.php';

$id = mysqli_real_escape_string($conn, $_GET['id']);

// Ambil info aktiviti
$act = $conn->query("SELECT * FROM activities WHERE activityID = '$id'")->fetch_assoc();

// Ambil list peserta dari table members
$sql = "SELECT m.fullName, m.programme 
        FROM participations p 
        JOIN members m ON p.userID = m.userID 
        WHERE p.activityID = '$id' 
        ORDER BY m.fullName ASC";
$list = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kehadiran - <?php echo $act['activityTitle']; ?></title>
    <style>
        body { font-family: 'Helvetica', sans-serif; padding: 30px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #D4A259; padding-bottom: 10px; margin-bottom: 20px; }
        .info { margin-bottom: 20px; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 12px; text-align: left; font-size: 12px; }
        th { background-color: #f9f9f9; color: #555; }
        .footer-sign { margin-top: 50px; display: flex; justify-content: space-between; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h1 style="margin:0; color:#D4A259;">i-KompIra</h1>
        <h3 style="margin:5px 0;">BORANG KEHADIRAN AKTIVITI</h3>
    </div>

    <div class="info">
        <table style="border:none; width: auto;">
            <tr style="border:none;"><td style="border:none; font-weight:bold;">Aktiviti:</td><td style="border:none;"><?php echo strtoupper($act['activityTitle']); ?></td></tr>
            <tr style="border:none;"><td style="border:none; font-weight:bold;">Lokasi:</td><td style="border:none;"><?php echo $act['location']; ?></td></tr>
            <tr style="border:none;"><td style="border:none; font-weight:bold;">Tarikh:</td><td style="border:none;"><?php echo date('d/m/Y', strtotime($act['trainDate'])); ?></td></tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th>Nama Penuh</th>
                <th width="20%">Program/Kursus</th>
                <th width="25%">Tandatangan</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; while($row = $list->fetch_assoc()): ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo strtoupper($row['fullName']); ?></td>
                <td><?php echo strtoupper($row['programme']); ?></td>
                <td></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="footer-sign" style="margin-top: 60px;">
        <div>
            <p>Disahkan oleh:</p>
            <br><br>
            <p>_______________________<br><strong>(Penyelaras Aktiviti)</strong></p>
        </div>
        <div style="text-align: right;">
            <p>Tarikh: <?php echo date('d/m/Y'); ?></p>
        </div>
    </div>
</body>
</html>