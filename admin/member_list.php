<?php
    include '../config/connection.php'; 
    include '../src/components/header.php'; 
    include '../src/components/navbar.php';

    // 2. Fetch data from the MySQL View
    $sql = "SELECT memberID, fullName, NRIC, beatRoleType FROM members";
    $result = $conn->query($sql);

    $members = [];
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $members[] = $row;
        }
    }
    $conn->close();
?>

    <div class="flex flex-col lg:flex-row min-h-screen">
        <?php include '../src/components/sidebar_admin.php'; ?>

        <button id="sidebarToggle" class="lg:hidden p-2 text-gray-700 focus:outline-none z-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
        <main class="flex-1 p-6 lg:p-10">
            <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Senarai Ahli Kelab</h1>
            <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
                
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NAMA</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NO. KAD PENGENALAN</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">JENIS IRAMA</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">SEMAK</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (empty($members)): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tiada ahli ditemui.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($members as $member): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($member['memberID']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($member['fullName']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($member['NRIC']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($member['beatRoleType']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="py-2 px-4 bg-yellow-600 text-white rounded-md shadow-sm hover:bg-yellow-700 transition duration-200">SEMAK</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="mt-6 text-center">
                    <button 
                        id="openAddMemberModal"
                        class="py-2 px-6 bg-green-600 text-white font-semibold rounded-md shadow-md hover:bg-green-700 transition duration-200"
                    >
                        TAMBAH
                    </button>
                </div>
            </div>
        </main>
    </div>

<?php 
    // 3. Include the modal file (will be hidden by default)
    include '../src/components/add_member_modal.php'; 
?>

<script>
    document.getElementById('openAddMemberModal').addEventListener('click', function() {
        document.getElementById('addMemberModal').classList.remove('hidden');
    });

    document.getElementById('closeAddMemberModal').addEventListener('click', function() {
        document.getElementById('addMemberModal').classList.add('hidden');
    });

    // Close modal when clicking outside the content
    document.getElementById('addMemberModal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });
</script>

<?php include '../src/components/footer.php'; ?>