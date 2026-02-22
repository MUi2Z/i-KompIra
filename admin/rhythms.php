<?php
session_start();
include_once '../config/connection.php';
include '../src/components/header.php';
include '../src/components/navbar.php';

// Kawalan Akses: Hanya Admin
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    header("Location: ../public/login.php");
    exit();
}

// --- LOGIK PAGINATION ---
$limit = 10; // Bilangan irama per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page > 1) ? ($page * $limit) - $limit : 0;

// 1. Dapatkan jumlah rekod keseluruhan irama
$total_query = $conn->query("SELECT COUNT(*) as id FROM rhythms");
$total_results = $total_query->fetch_assoc()['id'];
$pages = ceil($total_results / $limit);

// 2. Ambil data dengan LIMIT dan OFFSET
$sql = "SELECT r.*, u.userName 
        FROM rhythms r 
        JOIN users u ON r.userID = u.userID 
        ORDER BY r.created_at DESC
        LIMIT $start, $limit";
$result = $conn->query($sql);
?>

<div class="flex min-h-screen">
    <?php include '../src/components/sidebar_admin.php'; ?>

    <main class="flex-1 p-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Senarai Irama Digital</h1>
                <p class="text-gray-600 mt-1">Uruskan irama dan fail audio panduan ahli.</p>
            </div>
            
            <button onclick="toggleModal('addRhythmModal', 'rhythmCard')" 
                    class="inline-flex items-center px-5 py-2.5 bg-[#D4A259] text-white font-semibold rounded-xl shadow-md hover:bg-[#b88a4a] transition-all transform hover:-translate-y-1">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Irama
            </button>
        </div>

        <?php if (isset($_GET['status'])): ?>
            <div class="mb-6 p-4 rounded-xl border <?php echo ($_GET['status'] == 'success') ? 'bg-green-50 border-green-200 text-green-700' : 'bg-red-50 border-red-200 text-red-700'; ?> flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                <span class="text-sm font-bold">
                    <?php echo isset($_GET['message']) ? htmlspecialchars($_GET['message']) : 'Operasi berjaya.'; ?>
                </span>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Irama & Tahap</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Huraian</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Teknikal (BPM/JSON)</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900"><?php echo htmlspecialchars($row['title']); ?></div>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase bg-blue-100 text-blue-700">
                                        <?php echo $row['difficulty']; ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 italic">
                                    <?php echo htmlspecialchars($row['description']); ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-xs font-bold"><?php echo $row['beatSpeed']; ?> BPM</div>
                                    <div class="text-[10px] text-green-600 font-mono mt-1">
                                        <span class="bg-green-50 px-2 py-1 rounded">✓ JSON Ready (<?php echo strlen($row['source']); ?> chars)</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button onclick='openEditModal("editRhythmModal", "editRhythmCard", <?php echo json_encode($row); ?>)' 
                                                class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-width="2"></path>
                                            </svg>
                                        </button>
                                        <a href="../backend/process_delete_rhythm.php?id=<?php echo $row['rhythmID']; ?>" 
                                           onclick="return confirm('Adakah anda pasti mahu memadam irama ini? Semak semula sebelum padam.')"
                                           class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                           title="Padam Irama">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" 
                                                      stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-600">
                    Menunjukkan <span class="font-semibold text-gray-800"><?php echo ($total_results > 0) ? ($start + 1) : 0; ?></span> hingga <span class="font-semibold text-gray-800"><?php echo min($start + $limit, $total_results); ?></span> daripada <span class="font-semibold text-gray-800"><?php echo $total_results; ?></span> irama digital
                </div>
                
                <div class="flex items-center space-x-1">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>" class="px-3 py-1 bg-white border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50 shadow-sm transition-all">&larr;</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $pages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>" class="px-3 py-1 <?php echo ($page == $i) ? 'bg-[#D4A259] text-white border-[#D4A259]' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'; ?> border rounded-md text-sm font-medium shadow-sm transition-all">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($page < $pages): ?>
                        <a href="?page=<?php echo $page + 1; ?>" class="px-3 py-1 bg-white border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50 shadow-sm transition-all">&rarr;</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</div>

<?php include '../src/components/modal_add_rhythm.php'; ?>
<?php include '../src/components/modal_edit_rhythm.php'; ?>
<script src="../src/js/modal-logic.js"></script>

<?php include '../src/components/footer.php'; ?>