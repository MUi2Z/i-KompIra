<?php
session_start();
include_once '../config/connection.php';
include '../src/components/header.php';
include '../src/components/navbar.php';

// Kawalan Akses: Hanya Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../public/login.php");
    exit();
}

// Ambil data irama, nama pencipta, dan maklumat baru (audio & difficulty)
$sql = "SELECT r.*, u.userName 
        FROM rhythms r 
        JOIN users u ON r.userID = u.userID 
        ORDER BY r.created_at DESC";
$result = $conn->query($sql);
?>

<div class="flex min-h-screen bg-gray-50">
    <?php include '../src/components/sidebar_admin.php'; ?>

    <main class="flex-1 p-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Perpustakaan Irama Digital</h1>
                <p class="text-gray-600 mt-1">Uruskan skrip JSON irama dan fail audio panduan ahli.</p>
            </div>
            
            <button onclick="toggleModal('addRhythmModal')" 
                    class="inline-flex items-center px-5 py-2.5 bg-[#D4A259] text-white font-semibold rounded-xl shadow-md hover:bg-[#b88a4a] transition-all transform hover:-translate-y-1">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah JSON Irama
            </button>
        </div>

        <?php if (isset($_GET['status'])): ?>
            <div class="mb-6 p-4 rounded-xl border <?php echo ($_GET['status'] == 'success') ? 'bg-green-50 border-green-200 text-green-700' : 'bg-red-50 border-red-200 text-red-700'; ?> flex items-center shadow-sm">
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
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Audio</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900"><?php echo htmlspecialchars($row['title']); ?></div>
                                        <div class="mt-1 flex gap-1">
                                            <?php 
                                            $diffColor = [
                                                'Easy' => 'bg-green-100 text-green-700',
                                                'Medium' => 'bg-yellow-100 text-yellow-700',
                                                'Hard' => 'bg-red-100 text-red-700'
                                            ];
                                            $color = $diffColor[$row['difficulty']] ?? 'bg-gray-100 text-gray-700';
                                            ?>
                                            <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase <?php echo $color; ?>">
                                                <?php echo $row['difficulty']; ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-gray-600 line-clamp-2 w-48 italic">
                                            "<?php echo htmlspecialchars($row['description']); ?>"
                                        </p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs font-bold text-gray-700"><?php echo $row['beatSpeed']; ?> BPM</div>
                                        <div class="mt-1 flex items-center text-[10px] text-blue-600 font-mono bg-blue-50 px-2 py-1 rounded inline-block">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" stroke-width="2"></path></svg>
                                            <?php echo htmlspecialchars($row['source']); ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if($row['audio_path']): ?>
                                            <audio controls class="h-8 w-40">
                                                <source src="../uploads/audio/<?php echo $row['audio_path']; ?>" type="audio/mpeg">
                                            </audio>
                                        <?php else: ?>
                                            <span class="text-xs text-gray-400 italic">Tiada audio</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm font-medium">
                                        <div class="flex justify-center gap-2">
                                            <button onclick='openEditModal(<?php echo json_encode($row); ?>)' 
                                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </button>
                                            <a href="../backend/process_delete_rhythm.php?id=<?php echo $row['rhythmID']; ?>" 
                                               onclick="return confirm('Adakah anda pasti mahu memadam JSON irama ini?')"
                                               class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m4-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">Tiada data irama ditemui.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<?php include '../src/components/modal_add_rhythm.php'; ?>
<?php include '../src/components/modal_edit_rhythm.php'; ?>
<script src="../src/js/modal-logic.js"></script>

<?php include '../src/components/footer.php'; ?>