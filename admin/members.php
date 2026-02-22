<?php
session_start();
include_once '../config/connection.php';
include '../src/components/navbar.php';
include '../src/components/header.php';

// Kawalan Akses: Hanya Admin
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    header("Location: ../public/login.php");
    exit();
}

// --- LOGIK PAGINATION ---
$limit = 6; // Bilangan ahli per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page > 1) ? ($page * $limit) - $limit : 0;

// 1. Dapatkan jumlah rekod ahli yang aktif
$total_results = $conn->query("SELECT COUNT(*) as id FROM members WHERE status = 'active'")->fetch_assoc()['id'];
$pages = ceil($total_results / $limit);

// 2. Ambil data dengan LIMIT dan OFFSET
$sql = "SELECT m.*, u.email 
        FROM members m 
        JOIN users u ON m.userID = u.userID 
        WHERE m.status = 'active' 
        ORDER BY m.fullName ASC
        LIMIT $start, $limit";
$result = $conn->query($sql);
?>

<div class="flex min-h-screen bg-gray-50">
    <?php include '../src/components/sidebar_admin.php'; ?>

    <main class="flex-1 p-8">
        <?php if (isset($_GET['status'])): ?>
            <div class="mb-6 p-4 rounded-xl <?php echo $_GET['status'] == 'success' ? 'bg-green-50 border-green-200 text-green-700' : 'bg-red-50 border-red-200 text-red-700'; ?> border flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                <span class="text-sm font-medium"><?php echo htmlspecialchars($_GET['message']); ?></span>
            </div>
        <?php endif; ?>

        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Senarai Ahli i-KompIra</h1>
                <p class="text-gray-600 mt-1">Menguruskan maklumat ahli dan peranan mereka dalam kumpulan.</p>
            </div>
            
            <button onclick="toggleModal('addMemberModal', 'memberCard')" 
                    class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white font-semibold rounded-xl shadow-md hover:bg-blue-700 transition-all transform hover:-translate-y-1">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Ahli Baru
            </button>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Maklumat Ahli</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Program & Kohort</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Jenis Irama</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">
                                                <?php echo strtoupper(substr($row['fullName'], 0, 1)); ?>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-gray-900"><?php echo htmlspecialchars($row['fullName']); ?></div>
                                                <div class="text-xs text-gray-500"><?php echo htmlspecialchars($row['email']); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs font-medium bg-green-50 text-green-700 rounded-lg italic">
                                            <?php echo htmlspecialchars($row['programme']); ?>
                                        </span>
                                        <div class="text-xs text-gray-500 mt-1 uppercase">Kohort: <?php echo htmlspecialchars($row['kohort']); ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-700 font-medium"><?php echo htmlspecialchars($row['beatRoleType']); ?></div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-3">
                                            <button onclick='openEditModal("editMemberModal", "editMemberCard", {
                                                profileID: "<?php echo $row['profileID']; ?>",
                                                userID: "<?php echo $row['userID']; ?>",
                                                fullName: "<?php echo addslashes($row['fullName']); ?>",
                                                email: "<?php echo $row['email']; ?>",
                                                NRIC: "<?php echo $row['NRIC']; ?>",
                                                kohort: "<?php echo $row['kohort']; ?>",
                                                programme: "<?php echo $row['programme']; ?>",
                                                beatRoleType: "<?php echo $row['beatRoleType']; ?>"
                                            })' class="text-blue-500 hover:text-blue-700 p-2 hover:bg-blue-50 rounded-lg transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>
                                            <a href="../backend/delete_member.php?id=<?php echo $row['userID']; ?>" 
                                               onclick="return confirm('Padam ahli ini? Semua rekod berkaitan akan hilang.')"
                                               class="text-red-400 hover:text-red-600 p-2 hover:bg-red-50 rounded-lg transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m4-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic">Tiada ahli berdaftar ditemui.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-600">
                    Menunjukkan <span class="font-semibold text-gray-800"><?php echo ($total_results > 0) ? ($start + 1) : 0; ?></span> hingga <span class="font-semibold text-gray-800"><?php echo min($start + $limit, $total_results); ?></span> daripada <span class="font-semibold text-gray-800"><?php echo $total_results; ?></span> ahli aktif
                </div>
                
                <div class="flex items-center space-x-1">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>" class="px-3 py-1 bg-white border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50 shadow-sm transition-all">&larr;</a>
                    <?php endif; ?>

                    <?php 
                    // Paparkan navigasi nombor
                    for ($i = 1; $i <= $pages; $i++): 
                    ?>
                        <a href="?page=<?php echo $i; ?>" class="px-3 py-1 <?php echo ($page == $i) ? 'bg-[#D4A259] text-white border-[#D4A259]' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'; ?> border rounded-md text-sm font-medium shadow-sm transition-all">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($page < $pages): ?>
                        <a href="?page=<?php echo $page + 1; ?>" class="px-3 py-1 bg-white border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50 shadow-sm transition-all">&rarr;</a>
                    <?php endif; ?>
            <script>
            function toggleModal(modalId, cardId) {
                const modal = document.getElementById(modalId);
                const card = document.getElementById(cardId);
                
                if (modal.classList.contains('hidden')) {
                    modal.classList.remove('hidden');
                    setTimeout(() => {
                        modal.classList.remove('pointer-events-none');
                        card.classList.remove('scale-95', 'opacity-0', 'translate-y-4');
                    }, 10);
                } else {
                    card.classList.add('scale-95', 'opacity-0', 'translate-y-4');
                    setTimeout(() => {
                        modal.classList.add('hidden', 'pointer-events-none');
                    }, 300);
                }
            }
            
            function openEditModal(data, profileID) {
                // Isi data ke dalam form modal
                document.getElementById('edit_profileID').value = profileID;
                document.getElementById('edit_userID').value = <?= $userID; ?>; // UserID dari session
                document.getElementById('edit_email').value = data.email;
                document.getElementById('edit_fullName').value = data.fullName;
                document.getElementById('edit_NRIC').value = data.NRIC;
                document.getElementById('edit_kohort').value = data.kohort;
                document.getElementById('edit_programme').value = data.programme;
                document.getElementById('edit_beatRoleType').value = data.beatRoleType;
            
                toggleModal('editMemberModal', 'editMemberCard');
            }
            </script>
                </div>
            </div>

        </div>
    </main>
</div>

<?php include '../src/components/modal_add_member.php'; ?>
<?php include '../src/components/modal_edit_member.php'; ?>
<script src="../src/js/modal-logic.js"></script>
<?php include '../src/components/footer.php'; ?>