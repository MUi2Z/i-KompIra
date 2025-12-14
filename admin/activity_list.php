<?php    
    include '../config/connection.php'; 
    include '../src/components/header.php'; 
    include '../src/components/navbar.php'; 

    // Fetch data dari jadual 'activities'
    $sql = "SELECT activityID, activityTitle, activityDesc, createdAt FROM activities ORDER BY createdAt DESC";
    $result = $conn->query($sql);

    $activities = [];
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $activities[] = $row;
        }
    }
    $conn->close();
?>

    <div class="flex flex-col lg:flex-row min-h-screen">
        <?php include '../src/components/sidebar_admin.php'; ?>

        <main class="flex-1 p-6 lg:p-10">
            <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Senarai Aktiviti Kelab</h1>

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
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TAJUK AKTIVITI</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TARIKH DIBUAT</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">TINDAKAN</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (empty($activities)): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tiada aktiviti ditemui.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($activities as $activity): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($activity['activityID']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($activity['activityTitle']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo date('d M Y', strtotime($activity['createdAt'])); ?></td>
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
                        id="openAddActivityModal"
                        class="py-2 px-6 bg-green-600 text-white font-semibold rounded-md shadow-md hover:bg-green-700 transition duration-200"
                    >
                        TAMBAH AKTIVITI
                    </button>
                </div>
            </div>
        </main>
    </div>

<?php 
// Sertakan fail modal aktiviti
include '../src/components/add_activity_modal.php'; 
?>

<script>
    document.getElementById('openAddActivityModal').addEventListener('click', function() {
        document.getElementById('addActivityModal').classList.remove('hidden');
    });

    document.getElementById('closeAddActivityModal').addEventListener('click', function() {
        document.getElementById('addActivityModal').classList.add('hidden');
    });

    document.getElementById('addActivityModal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });
</script>

<?php include '../src/components/footer.php'; ?>