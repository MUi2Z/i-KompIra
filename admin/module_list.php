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
$conn->close();
?>

    <div class="flex flex-col lg:flex-row min-h-screen">
        <?php include '../src/components/sidebar_admin.php'; ?>

        <main class="flex-1 p-6 lg:p-10">
            <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Senarai Modul Pembelajaran</h1>

            <?php 
            if (isset($_GET['status']) && isset($_GET['message'])) {
                $status = htmlspecialchars($_GET['status']);
                $message = htmlspecialchars($_GET['message']);
                $color = ($status == 'success') ? 'bg-green-100 border-green-500 text-green-700' : 'bg-red-100 border-red-500 text-red-700';
                echo "
                <div class='mb-4 p-4 border-l-4 $color rounded-lg' role='alert'>
                    <p class='font-bold'>Status:</p>
                    <p>$message</p>
                </div>";
            }
            ?>
            <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
                
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NAMA MODUL</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TARIKH DIBUAT</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">TINDAKAN</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (empty($modules)): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tiada modul ditemui.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($modules as $module): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($module['moduleID']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($module['moduleName']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo date('d M Y', strtotime($module['created_at'])); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="py-2 px-4 bg-blue-600 text-white rounded-md shadow-sm hover:bg-blue-700 transition duration-200">LIHAT</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="mt-6 text-center">
                    <button 
                        id="openAddModuleModal"
                        class="py-2 px-6 bg-green-600 text-white font-semibold rounded-md shadow-md hover:bg-green-700 transition duration-200"
                    >
                        TAMBAH MODUL
                    </button>
                </div>
            </div>
        </main>
    </div>

<?php 
// Sertakan fail modal modul
include '../src/components/add_module_modal.php'; 
?>

<script>
    document.getElementById('openAddModuleModal').addEventListener('click', function() {
        document.getElementById('addModuleModal').classList.remove('hidden');
    });

    document.getElementById('closeAddModuleModal').addEventListener('click', function() {
        document.getElementById('addModuleModal').classList.add('hidden');
    });

    document.getElementById('addModuleModal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });
</script>

<?php include '../src/components/footer.php'; ?>