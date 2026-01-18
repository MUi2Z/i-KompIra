<?php
include '../config/connection.php'; 
include '../src/components/header.php'; 
include '../src/components/navbar.php'; 

// Fetch data dari jadual 'modules'
$sql = "SELECT moduleID, moduleName, moduleDesc, created_at FROM modules ORDER BY created_at DESC";
$result = $conn->query($sql);

$modules = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $modules[] = $row;
    }
}
?>

<div class="flex min-h-screen">
    <?php include '../src/components/sidebar_admin.php'; ?>
    
    <div class="flex-1">
        <main class="p-6 lg:p-10">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Senarai Modul Pembelajaran</h1>
                <p class="text-gray-600">Urus dan lihat semua modul pembelajaran</p>
            </div>

            <?php 
            if (isset($_GET['status']) && isset($_GET['message'])) {
                $status = htmlspecialchars($_GET['status']);
                $message = htmlspecialchars($_GET['message']);
                $color = ($status == 'success') ? 'bg-green-100 border-green-500 text-green-700' : 'bg-red-100 border-red-500 text-red-700';
                echo "
                <div class='mb-6 p-4 border-l-4 $color rounded-lg shadow-sm' role='alert'>
                    <p class='font-bold'>" . ucfirst($status) . "!</p>
                    <p>$message</p>
                </div>";
            }
            ?>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <!-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th> -->
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NAMA MODUL</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">KETERANGAN</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TARIKH DIBUAT</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">TINDAKAN</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (empty($modules)): ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <p>Tiada modul ditemui. Sila tambah modul baharu.</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($modules as $module): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <!-- <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <?php // echo htmlspecialchars($module['moduleID']); ?>
                                        </span>
                                    </td> -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($module['moduleName']); ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-500 max-w-xs truncate">
                                            <?php echo htmlspecialchars($module['moduleDesc']); ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo date('d/m/Y', strtotime($module['created_at'])); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <a href="view_module.php?id=<?php echo htmlspecialchars($module['moduleID']); ?>" 
                                           class="inline-block py-2 px-4 bg-blue-600 text-white rounded-md shadow-sm hover:bg-blue-700 transition duration-200 text-xs">
                                            LIHAT
                                        </a>
                                        <a href="edit_module.php?id=<?php echo htmlspecialchars($module['moduleID']); ?>" 
                                           class="inline-block py-2 px-4 bg-yellow-600 text-white rounded-md shadow-sm hover:bg-yellow-700 transition duration-200 text-xs">
                                            EDIT
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-8 text-center">
                <button 
                    id="openAddModuleModal"
                    class="py-3 px-6 bg-[#D4A259] text-white font-semibold rounded-lg shadow-md hover:bg-[#b88a4a] transition duration-200 inline-flex items-center"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    TAMBAH MODUL BAHARU
                </button>
            </div>
        </main>
    </div>
</div>

<?php 
include '../src/components/add_module_modal.php'; 
include '../src/components/footer.php'; 
?>

<script>
    // Fix modal opening/closing
    document.getElementById('openAddModuleModal').addEventListener('click', function(e) {
        e.stopPropagation();
        document.getElementById('addModuleModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    });

    document.getElementById('closeAddModuleModal').addEventListener('click', function(e) {
        e.stopPropagation();
        document.getElementById('addModuleModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    });

    // Close modal when clicking outside
    document.getElementById('addModuleModal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.getElementById('addModuleModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    });
</script>