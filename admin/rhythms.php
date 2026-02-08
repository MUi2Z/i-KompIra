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

// Ambil data irama dan nama pencipta (JOIN dengan users)
$sql = "SELECT r.*, u.username 
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
                <h1 class="text-3xl font-bold text-gray-800">Pengurusan Irama Kompang</h1>
                <p class="text-gray-600 mt-1">Simpan, kemaskini, dan uruskan fail MIDI untuk rujukan ahli.</p>
            </div>
            
            <button onclick="toggleModal('addRhythmModal', 'rhythmCard')" 
                    class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white font-semibold rounded-xl shadow-md hover:bg-green-700 transition-all transform hover:-translate-y-1">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Irama Baharu
            </button>
        </div>

        <?php if (isset($_GET['status']) && isset($_GET['message'])): 
            $status = htmlspecialchars($_GET['status']);
            $message = htmlspecialchars($_GET['message']);
            $color = ($status == 'success') ? 'bg-green-50 border-green-200 text-green-700' : 'bg-red-50 border-red-200 text-red-700';
        ?>
            <div class="mb-6 p-4 border rounded-xl <?php echo $color; ?> flex items-center shadow-sm">
                <span class="text-sm font-medium"><?php echo $message; ?></span>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Maklumat Irama</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Huraian</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">BPM / MIDI</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0 bg-green-100 rounded-lg flex items-center justify-center text-green-600">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-gray-900"><?php echo htmlspecialchars($row['title']); ?></div>
                                                <div class="text-xs text-gray-500">Oleh: <?php echo htmlspecialchars($row['username']); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-600 line-clamp-2 max-w-xs">
                                            <?php echo htmlspecialchars($row['description']); ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                            <?php echo htmlspecialchars($row['beatSpeed']); ?> BPM
                                        </span>
                                        <div class="mt-1 text-xs text-blue-600 font-medium hover:underline">
                                            <a href="../uploads/rhythms/<?php echo $row['midiSrc']; ?>" target="_blank" class="flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                                MIDI File
                                            </a>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-3">
                                            <button onclick='openEditModal("editRhythmModal", "editRhythmCard", {
                                                rhythmID: "<?php echo $row['rhythmID']; ?>",
                                                title: "<?php echo addslashes($row['title']); ?>",
                                                description: "<?php echo addslashes($row['description']); ?>",
                                                beatSpeed: "<?php echo $row['beatSpeed']; ?>",
                                                midiSrc: "<?php echo $row['midiSrc']; ?>"
                                            })' class="text-blue-500 hover:text-blue-700 p-2 hover:bg-blue-50 rounded-lg transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </button>
                                            
                                            <a href="../backend/delete_rhythm.php?id=<?php echo $row['rhythmID']; ?>" 
                                               onclick="return confirm('Padam irama ini secara kekal?')"
                                               class="text-red-400 hover:text-red-600 p-2 hover:bg-red-50 rounded-lg transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m4-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic">
                                    Tiada irama ditemui. Sila tambah irama baharu.
                                </td>
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