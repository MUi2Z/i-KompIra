<?php
include '../config/connection.php'; 
include '../src/components/header.php';
include '../src/components/navbar.php';

// Fetch data dengan kolum baru (createdAt dan moduleThumbnail)
$sql = "SELECT moduleID, moduleName, moduleDesc, moduleThumbnail, createdAt FROM modules ORDER BY createdAt DESC";
$result = $conn->query($sql);

$modules = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $modules[] = $row;
    }
}
?>

<div class="flex min-h-screen bg-gray-50">
    <?php include '../src/components/sidebar_admin.php'; ?>
    
    <div class="flex-1">
        <main class="p-6 lg:p-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Modul</h1>
                    <p class="text-gray-600">Urus bahan rujukan dan nota teknikal kompang.</p>
                </div>
                <button onclick="toggleModal('addModuleModal', 'moduleCard')" class="mt-4 md:mt-0 py-2.5 px-5 bg-[#D4A259] text-white font-bold rounded-xl shadow-lg shadow-gold-100 hover:bg-[#b88a4a] transition-all flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Modul
                </button>
            </div>

            <?php if (isset($_GET['status'])): ?>
                <div class="mb-6 p-4 border-l-4 <?php echo ($_GET['status'] == 'success') ? 'bg-green-50 border-green-500 text-green-700' : 'bg-red-50 border-red-500 text-red-700'; ?> rounded-xl shadow-sm animate-fade-in">
                    <div class="flex items-center">
                        <span class="font-bold uppercase text-xs mr-2"><?php echo htmlspecialchars($_GET['status']); ?>:</span>
                        <span class="text-sm"><?php echo htmlspecialchars($_GET['message'] ?? ''); ?></span>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Modul</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Keterangan</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tarikh Dibuat</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            <?php if (empty($modules)): ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-16 h-16 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                            <p class="text-lg font-medium text-gray-400">Tiada modul pembelajaran buat masa ini.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($modules as $module): ?>
                                <tr class="hover:bg-blue-50/30 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-12 w-12 flex-shrink-0 rounded-lg overflow-hidden border border-gray-200 bg-gray-100">
                                                <img src="../uploads/modules/thumbs/<?php echo htmlspecialchars($module['moduleThumbnail']); ?>" 
                                                     alt="" class="h-full w-full object-cover">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-gray-900"><?php echo htmlspecialchars($module['moduleName']); ?></div>
                                                <div class="text-xs text-gray-400 uppercase tracking-tighter">ID: #<?php echo $module['moduleID']; ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-gray-500 max-w-xs truncate">
                                            <?php echo htmlspecialchars($module['moduleDesc']); ?>
                                        </p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                        <?php echo date('d M Y', strtotime($module['createdAt'])); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center space-x-2">
                                            <a href="view_module.php?id=<?php echo $module['moduleID']; ?>" 
                                               class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition-all" title="Lihat">
                                               <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<?php 
include '../src/components/modal_add_module.php'; // Pastikan nama fail modal betul
include '../src/components/footer.php'; 
?>
<script src="../assets/js/modal-logic.js"></script>