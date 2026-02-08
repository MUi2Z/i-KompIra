<?php
session_start();
require_once '../config/connection.php';

// Semakan akses Admin
if (!isset($_SESSION['userID']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../public/login.php");
    exit();
}

$moduleID = $_GET['id'] ?? 0;

// Ambil butiran modul dan email admin yang mencipta
$sql = "SELECT m.*, u.email as creatorEmail 
        FROM modules m 
        JOIN users u ON m.userID = u.userID 
        WHERE m.moduleID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $moduleID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: modules.php?status=error&message=Modul tidak ditemui");
    exit();
}

$module = $result->fetch_assoc();
include '../src/components/header.php';
?>

<div class="flex min-h-screen bg-gray-50">
    <?php include '../src/components/sidebar_admin.php'; ?>
    
    <main class="flex-1 p-6 lg:p-10">
        <div class="mb-6">
            <a href="modules.php" class="text-blue-600 hover:text-blue-800 flex items-center font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Senarai Modul
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden max-w-5xl mx-auto border border-gray-100">
            <div class="relative h-48 bg-gradient-to-r from-blue-700 to-indigo-800 p-8 flex items-end">
                <div class="z-10">
                    <span class="px-3 py-1 bg-white/20 text-white text-xs font-bold rounded-full uppercase tracking-wider backdrop-blur-sm">
                        Modul Pembelajaran
                    </span>
                    <h1 class="text-3xl font-bold text-white mt-2"><?php echo htmlspecialchars($module['moduleName']); ?></h1>
                </div>
            </div>
            
            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-8">
                        <div>
                            <h2 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                                <span class="w-2 h-6 bg-blue-600 rounded-full mr-3"></span>
                                Penerangan Modul
                            </h2>
                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                                <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                                    <?php echo nl2br(htmlspecialchars($module['moduleDesc'])); ?>
                                </p>
                            </div>
                        </div>

                        <div>
                            <h2 class="text-lg font-bold text-gray-800 mb-3">Dokumen Lampiran</h2>
                            <div class="flex items-center p-4 bg-white border-2 border-dashed border-gray-200 rounded-2xl hover:border-blue-300 transition-colors">
                                <div class="p-3 bg-red-100 rounded-lg text-red-600 mr-4">
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-gray-800">Fail Modul (PDF/DOCX)</p>
                                    <p class="text-xs text-gray-500"><?php echo htmlspecialchars($module['moduleDocs']); ?></p>
                                </div>
                                <a href="../uploads/modules/docs/<?php echo $module['moduleDocs']; ?>" target="_blank" 
                                   class="px-4 py-2 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition">
                                    Buka Fail
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="rounded-2xl overflow-hidden border border-gray-200 shadow-sm">
                            <p class="p-3 text-xs font-bold text-gray-500 bg-gray-50 border-b">Thumbnail Modul</p>
                            <img src="../uploads/modules/thumbs/<?php echo $module['moduleThumbnail']; ?>" 
                                 alt="Thumbnail" class="w-full h-40 object-cover">
                        </div>

                        <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100 space-y-4">
                            <div>
                                <h3 class="text-xs font-bold text-gray-400 uppercase">Dicipta Oleh</h3>
                                <p class="text-sm font-bold text-gray-800"><?php echo htmlspecialchars($module['creatorEmail']); ?></p>
                            </div>
                            <div>
                                <h3 class="text-xs font-bold text-gray-400 uppercase">Tarikh Dibuat</h3>
                                <p class="text-sm text-gray-700"><?php echo date('d M Y, h:i A', strtotime($module['createdAt'])); ?></p>
                            </div>
                            <div>
                                <h3 class="text-xs font-bold text-gray-400 uppercase">Kemaskini Terakhir</h3>
                                <p class="text-sm text-gray-700"><?php echo date('d M Y, h:i A', strtotime($module['updatedAt'])); ?></p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-3">
                            <button onclick='openEditModal("editModuleModal", "editModuleCard", {
                                moduleID: "<?php echo $module['moduleID']; ?>",
                                moduleName: "<?php echo addslashes($module['moduleName']); ?>",
                                moduleDesc: "<?php echo addslashes($module['moduleDesc']); ?>"
                            })' class="w-full flex justify-center items-center px-4 py-3 bg-amber-500 text-white font-bold rounded-xl hover:bg-amber-600 transition shadow-lg shadow-amber-100">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Modul
                            </button>
                            <button onclick="deleteModule(<?php echo $module['moduleID']; ?>)" 
                               class="px-4 py-3 bg-white text-red-500 font-bold rounded-xl border border-red-100 hover:bg-red-50 transition">
                                Padam Modul
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
</div>

<script>
function deleteModule(id) {
    if (confirm('Adakah anda pasti ingin memadam modul ini? Semua fail berkaitan akan dihapuskan.')) {
        window.location.href = '../backend/delete_module.php?id=' + id;
    }
}
</script>

<?php include '../src/components/modal_add_module.php'; ?>
<?php include '../src/components/modal_edit_module.php'; ?>
<script src="../src/js/modal-logic.js"></script>

<?php include '../src/components/footer.php'; ?>