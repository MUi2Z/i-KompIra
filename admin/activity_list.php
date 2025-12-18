<?php    
    include '../config/connection.php'; 
    include '../src/components/header.php'; 
    include '../src/components/navbar.php'; 

    // Fetch data dari jadual 'activities'
    $sql = "SELECT a.*, COUNT(p.participationID) as total_participants 
            FROM activities a 
            LEFT JOIN participations p ON a.activityID = p.activityID 
            GROUP BY a.activityID";
    $result = $conn->query($sql);
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
            <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto mt-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gambar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tajuk Aktiviti</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peserta</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="px-6 py-4">
                                <img src="<?php echo $row['activityThumbnail']; ?>" class="h-12 w-20 object-cover rounded">
                            </td>
                            <td class="px-6 py-4 font-medium"><?php echo $row['activityTittle']; ?></td>
                            <td class="px-6 py-4 text-sm text-blue-600 font-bold">
                                <?php echo $row['total_participants']; ?> Orang
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                                <button class="text-red-600 hover:text-red-900">Padam</button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
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