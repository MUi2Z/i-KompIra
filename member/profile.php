<?php
session_start();
include '../config/connection.php';
include '../src/components/header.php';
include '../src/components/navbar.php';

// Pastikan pengguna sudah log masuk
if (!isset($_SESSION['userID'])) {
    header("Location: ../public/login.php");
    exit();
}

$userID = $_SESSION['userID'];

// Ambil maklumat user & profil (jika ada)
$sql = "SELECT u.email, u.role, m.* FROM users u 
        LEFT JOIN members m ON u.userID = m.userID
        WHERE u.userID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();
?>

<?php
// Display success message
if (isset($_SESSION['success'])) {
    echo '<div class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-lg z-50" role="alert">
            <span class="block sm:inline">' . $_SESSION['success'] . '</span>
          </div>';
    unset($_SESSION['success']);
}

// Display error messages
if (isset($_SESSION['error'])) {
    echo '<div class="fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-lg z-50" role="alert">
            <span class="block sm:inline">' . $_SESSION['error'] . '</span>
          </div>';
    unset($_SESSION['error']);
}

// Display validation errors
if (isset($_SESSION['errors'])) {
    echo '<div class="fixed top-4 right-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded shadow-lg z-50" role="alert">
            <ul class="list-disc ml-4">';
    foreach ($_SESSION['errors'] as $error) {
        echo '<li>' . $error . '</li>';
    }
    echo '</ul></div>';
    unset($_SESSION['errors']);
}
?>

<?php
// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<form action="../backend/process_request_member.php" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    
    <!-- Rest of your form fields -->
</form>

<div class="min-h-screen bg-gray-50 p-6 lg:p-10">
    <div class="max-w-4xl mx-auto">
        
        <div class="bg-white rounded-xl shadow-sm p-8 mb-6 border border-gray-100">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="h-24 w-24 bg-[#D4A259] rounded-full flex items-center justify-center text-white text-4xl font-bold">
                    <?php echo strtoupper(substr($userData['email'], 0, 1)); ?>
                </div>
                <div class="text-center md:text-left">
                    <h1 class="text-2xl font-bold text-gray-800"><?php echo $userData['fullName'] ?? 'Pengguna Baru'; ?></h1>
                    <p class="text-gray-500"><?php echo $userData['email']; ?></p>
                    <span class="mt-2 inline-block px-3 py-1 rounded-full text-xs font-bold uppercase 
                        <?php 
                            if($userData['role'] == 'member') echo 'bg-green-100 text-green-700';
                            else echo 'bg-blue-100 text-blue-700';
                        ?>">
                        Peranan: <?php echo $userData['role']; ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
            
            <?php if ($userData['role'] == 'user' && !isset($userData['status'])): ?>
                <div class="p-8">
                    <h2 class="text-xl font-bold mb-4 text-gray-800">Mohon Menjadi Ahli</h2>
                    <p class="mb-6 text-gray-600 text-sm">Sila lengkapkan maklumat tambahan di bawah untuk menyertai komuniti i-KompIra secara rasmi.</p>
                    
                    <form action="../backend/process_request_member.php" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Nama Penuh (Seperti dalam IC)</label>
                            <input type="text" name="fullName" required class="mt-1 block w-full px-3 py-2 border rounded-md outline-none focus:ring-[#D4A259] focus:border-[#D4A259]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">No. Kad Pengenalan</label>
                            <input type="text" name="NRIC" placeholder="Tanpa -" required class="mt-1 block w-full px-3 py-2 border rounded-md outline-none focus:ring-[#D4A259] focus:border-[#D4A259]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kohort</label>
                            <input type="number" name="kohort" value="2025" class="mt-1 block w-full px-3 py-2 border rounded-md outline-none focus:ring-[#D4A259] focus:border-[#D4A259]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Program</label>
                            <select name="programme" class="mt-1 block w-full px-3 py-2 border rounded-md">
                                <option>Diploma</option>
                                <option>Sarjana Muda</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jenis Irama</label>
                            <select name="beatRoleType" class="mt-1 block w-full px-3 py-2 border rounded-md">
                                <option>Melalu</option>
                                <option>Menyilang</option>
                            </select>
                        </div>
                        <div class="md:col-span-2 mt-4">
                            <button type="submit" class="bg-[#D4A259] text-white px-6 py-2 rounded-lg font-bold hover:bg-[#b88a4a] transition w-full md:w-auto">
                                HANTAR PERMOHONAN
                            </button>
                        </div>
                    </form>
                </div>

            <?php elseif ($userData['status'] == 'pending'): ?>
                <div class="p-12 text-center">
                    <div class="mx-auto h-16 w-16 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Permohonan Sedang Disemak</h2>
                    <p class="text-gray-500 mt-2">Terima kasih! Admin sedang menyemak maklumat anda. Sila log masuk semula dalam masa 24 jam.</p>
                </div>

            <?php else: ?>
                <div class="p-8">
                    <h2 class="text-xl font-bold mb-6 text-gray-800 border-b pb-2">Maklumat Ahli</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6">
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold">No. Kad Pengenalan</p>
                            <p class="text-gray-700 font-medium"><?php echo $userData['NRIC']; ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold">Program Pengajian</p>
                            <p class="text-gray-700 font-medium"><?php echo $userData['programme']; ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold">Jenis Irama Utama</p>
                            <p class="text-gray-700 font-medium"><?php echo $userData['beatRoleType']; ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold">Kohort</p>
                            <p class="text-gray-700 font-medium"><?php echo $userData['kohort']; ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php include '../src/components/footer.php'; ?>