<?php
session_start();
include_once '../config/connection.php';
include '../src/components/header.php';
include '../src/components/navbar.php';

if (!isset($_GET['id'])) { header("Location: activities.php"); exit(); }

$activityID = mysqli_real_escape_string($conn, $_GET['id']);

// Ambil maklumat aktiviti
$actQuery = "SELECT * FROM activities WHERE activityID = '$activityID'";
$activity = $conn->query($actQuery)->fetch_assoc();

// Ambil senarai peserta (Join participations -> users -> members)
$participantsQuery = "SELECT m.fullName, m.programme, u.email, p.joinedAt 
                      FROM participations p 
                      JOIN users u ON p.userID = u.userID 
                      JOIN members m ON u.userID = m.userID 
                      WHERE p.activityID = '$activityID' 
                      ORDER BY m.fullName ASC";
$participants = $conn->query($participantsQuery);
?>

<div class="flex min-h-screen bg-gray-50">
    <?php include '../src/components/sidebar_admin.php'; ?>

    <main class="flex-1 p-8">
        <div class="mb-8">
            <a href="activities.php" class="text-[#D4A259] hover:underline text-sm mb-2 inline-block">&larr; Kembali ke Senarai</a>
            <div class="flex justify-between items-end">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800"><?php echo $activity['activityTitle']; ?></h1>
                    <p class="text-gray-500">Pengurusan kehadiran dan maklumat peserta.</p>
                </div>
                <a href="../backend/generate_attendance_pdf.php?id=<?php echo $activityID; ?>" target="_blank"
                   class="bg-red-600 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-red-700 shadow-lg transition-all flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Cetak Kehadiran (PDF)
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <img src="../uploads/activities/<?php echo $activity['activityThumbnail']; ?>" class="w-full h-48 object-cover rounded-xl mb-4">
                    <h3 class="font-bold text-gray-800 mb-2">Penerangan</h3>
                    <p class="text-gray-600 text-sm leading-relaxed"><?php echo nl2br($activity['activityDesc']); ?></p>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800">Senarai Peserta Berdaftar</h3>
                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">
                            <?php echo $participants->num_rows; ?> Orang
                        </span>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Nama Ahli</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Program</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Tarikh Daftar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <?php if ($participants->num_rows > 0): ?>
                                <?php while($p = $participants->fetch_assoc()): ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <?php echo htmlspecialchars($p['fullName']); ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?php echo htmlspecialchars($p['programme']); ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?php echo date('d/m/Y', strtotime($p['joinedAt'])); ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<?php include '../src/components/footer.php'; ?>