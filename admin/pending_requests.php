<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../config/connection.php';
include '../src/components/header.php';

// Kawalan Akses: Hanya Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../public/login.php");
    exit();
}

// Ambil senarai permohonan pending
$sql = "SELECT m.*, u.email 
        FROM members m 
        JOIN users u ON m.userID = u.userID 
        WHERE m.status = 'pending' 
        ORDER BY m.applied_at ASC";

$result = $conn->query($sql);
?>

<div class="flex min-h-screen bg-gray-50">
    <?php include '../src/components/sidebar_admin.php'; ?>

    <main class="flex-1 p-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Senarai Permohonan Ahli</h1>
            <p class="text-gray-600">Semak dan sahkan permohonan baru untuk menjadi ahli i-KompIra.</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Penuh</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Program/Kohort</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tarikh Mohon</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($row['fullName']); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo htmlspecialchars($row['email']); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?php echo htmlspecialchars($row['programme']); ?></div>
                                    <div class="text-sm text-gray-500">Kohort: <?php echo htmlspecialchars($row['kohort']); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo date('d M Y', strtotime($row['applied_at'])); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center gap-2">
                                        <a href="../backend/approve_action.php?id=<?php echo $row['userID']; ?>&status=active" 
                                           onclick="return confirm('Sahkan permohonan ini?')"
                                           class="bg-green-100 text-green-700 px-3 py-1 rounded-md hover:bg-green-200">Terima</a>
                                        
                                        <a href="../backend/approve_action.php?id=<?php echo $row['userID']; ?>&status=rejected" 
                                           onclick="return confirm('Tolak permohonan ini?')"
                                           class="bg-red-100 text-red-700 px-3 py-1 rounded-md hover:bg-red-200">Tolak</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500">Tiada permohonan baru buat masa ini.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<?php include '../src/components/footer.php'; ?>