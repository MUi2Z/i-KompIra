<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once '../config/connection.php';
include '../src/components/header.php';
include '../src/components/navbar.php';

// Kawalan Akses: Hanya Admin
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    header("Location: ../public/login.php");
    exit();
}

// Fetch data dari jadual 'activities' dengan pengiraan peserta
$sql = "SELECT a.*, COUNT(p.participationID) as total_participants 
        FROM activities a 
        LEFT JOIN participations p ON a.activityID = p.activityID 
        GROUP BY a.activityID
        ORDER BY a.createdAt DESC";
$result = $conn->query($sql);
?>

<div class="flex min-h-screen">
    <?php include '../src/components/sidebar_admin.php'; ?>

    <main class="flex-1 p-8">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Pengurusan Aktiviti</h1>
                <p class="text-gray-600 mt-1">Lihat, tambah, dan kemaskini aktiviti kelab i-KompIra.</p>
            </div>
            
            <button onclick="toggleModal('addActivityModal', 'activityCard')" 
                    class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white font-semibold rounded-xl shadow-md hover:bg-green-700 transition-all transform hover:-translate-y-1">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Aktiviti Baharu
            </button>
        </div>

        <?php if (isset($_GET['status']) && isset($_GET['message'])): 
            $status = htmlspecialchars($_GET['status']);
            $message = htmlspecialchars($_GET['message']);
            $color = ($status == 'success') ? 'bg-green-50 border-green-200 text-green-700' : 'bg-red-50 border-red-200 text-red-700';
        ?>
            <div class="mb-6 p-4 border rounded-xl <?php echo $color; ?> flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-sm font-medium"><?php echo $message; ?></span>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Maklumat Aktiviti</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Penerangan Ringkas</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Statistik</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-14 w-24 flex-shrink-0">
                                                <img class="h-14 w-24 object-cover rounded-lg shadow-sm border border-gray-100" 
                                                     src="../uploads/activities/<?php echo $row['activityThumbnail']; ?>" 
                                                     alt="Thumbnail">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-gray-900"><?php echo htmlspecialchars($row['activityTitle']); ?></div>
                                                <div class="text-xs text-gray-500">Dikemaskini: <?php echo date('d M Y', strtotime($row['updatedAt'])); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-600 line-clamp-2 max-w-xs">
                                            <?php echo htmlspecialchars($row['activityDesc']); ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                            </svg>
                                            <?php echo $row['total_participants']; ?> Peserta
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-3">
                                            <button onclick="openEditModal('editActivityModal', 'editActivityCard', {activityID: '<?php echo $row['activityID']; ?>',activityTitle: '<?php echo addslashes($row['activityTitle']); ?>',activityDesc: '<?php echo addslashes($row['activityDesc']); ?>',imagePath: '../uploads/activities/<?php echo $row['activityThumbnail']; ?>'})" 
                                                    class="text-blue-500 hover:text-blue-700 p-2 hover:bg-blue-50 rounded-lg transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            
                                            <a href="../backend/delete_activity.php?id=<?php echo $row['activityID']; ?>" 
                                               onclick="return confirm('Anda pasti ingin memadam aktiviti ini? Rekod penyertaan juga akan terjejas.')"
                                               class="text-red-400 hover:text-red-600 p-2 hover:bg-red-50 rounded-lg transition-all" 
                                               title="Padam Aktiviti">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m4-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        Tiada aktiviti ditemui. Sila tambah aktiviti baru.
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<?php include '../src/components/modal_add_activity.php'; ?>
<?php include '../src/components/modal_edit_activity.php'; ?>
<script src="../src/js/modal-logic.js"></script>

<?php include '../src/components/footer.php'; ?>