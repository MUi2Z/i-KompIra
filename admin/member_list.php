<?php
    include '../config/connection.php'; 
    include '../src/components/header.php'; 
    include '../src/components/navbar.php';

    // 1. Sertakan sesi untuk semakan role (Optional tapi digalakkan)
    session_start();
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        // Jika bukan admin, tendang ke login atau home
        // header("Location: ../public/login.php"); exit(); 
    }

    // 2. Fetch data dari jadual member_profiles yang berstatus 'active'
    // Kita gunakan profileID sebagai ID paparan
    $sql = "SELECT profileID, fullName, NRIC, beatRoleType, status 
            FROM members 
            WHERE status = 'active' 
            ORDER BY applied_at DESC";
    
    $result = $conn->query($sql);

    $members = [];
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $members[] = $row;
        }
    }
    $conn->close();
?>

    <div class="flex flex-col lg:flex-row min-h-screen bg-gray-50">
        <?php include '../src/components/sidebar_admin.php'; ?>

        <main class="flex-1 p-6 lg:p-10">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <h1 class="text-3xl font-bold text-gray-800">Senarai Ahli Aktif</h1>
                
                <a href="pending_requests.php" class="bg-blue-100 text-blue-700 px-4 py-2 rounded-lg border border-blue-300 hover:bg-blue-200 transition">
                    Semak Permohonan Baru
                </a>
            </div>

            <?php if (isset($_GET['message'])): ?>
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                    <?php echo htmlspecialchars($_GET['message']); ?>
                </div>
            <?php endif; ?>

            <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto border border-gray-100">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID PROFIL</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NAMA PENUH</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NO. KAD PENGENALAN</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">JENIS IRAMA</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">TINDAKAN</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (empty($members)): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-8 whitespace-nowrap text-sm text-gray-500 text-center italic">Tiada ahli aktif ditemui dalam sistem.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($members as $member): ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-600">#<?php echo htmlspecialchars($member['profileID']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900"><?php echo htmlspecialchars($member['fullName']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?php echo htmlspecialchars($member['NRIC']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">
                                            <?php echo htmlspecialchars($member['beatRoleType']); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="py-1.5 px-4 bg-indigo-600 text-white rounded shadow hover:bg-indigo-700 transition">PROFIL</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="mt-8 flex justify-center">
                    <button 
                        id="openAddMemberModal"
                        class="py-2.5 px-8 bg-green-600 text-white font-bold rounded-full shadow-lg hover:bg-green-700 hover:-translate-y-1 transition duration-200"
                    >
                        + TAMBAH AHLI
                    </button>
                </div>
            </div>
        </main>
    </div>

<?php 
    include '../src/components/add_member_modal.php'; 
?>

<script>
    // Logic Toggle Modal
    const modal = document.getElementById('addMemberModal');
    const openBtn = document.getElementById('openAddMemberModal');
    const closeBtn = document.getElementById('closeAddMemberModal');

    openBtn.onclick = () => modal.classList.remove('hidden');
    closeBtn.onclick = () => modal.classList.add('hidden');
    
    window.onclick = (e) => {
        if (e.target === modal) modal.classList.add('hidden');
    }
</script>

<?php include '../src/components/footer.php'; ?>