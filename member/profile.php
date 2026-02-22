<?php
session_start();
include '../config/connection.php';
include '../src/components/header.php';
include '../src/components/navbar.php';

if (!isset($_SESSION['userID'])) {
    header("Location: ../public/login.php");
    exit();
}

$userID = $_SESSION['userID'];

// Ambil maklumat user & profil
$sql = "SELECT u.email, u.userName, u.role, u.created_at, m.status, m.fullName, m.NRIC, m.programme, m.beatRoleType, m.kohort 
        FROM users u 
        LEFT JOIN members m ON u.userID = m.userID
        WHERE u.userID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

// Logik paparan borang
$showForm = false;
if ($userData['role'] == 'user') {
    if (!isset($userData['status']) || $userData['status'] == 'rejected') {
        $showForm = true;
    }
}
?>

<div class="flex min-h-screen bg-gray-50">
    <?php include '../src/components/sidebar_member.php'; ?>

    <div class="flex-1 flex flex-col min-h-screen">
        <?php if (isset($_SESSION['success']) || isset($_SESSION['error'])): ?>
            <div id="notification-container" class="fixed top-6 right-6 z-[100] space-y-3 w-80">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="bg-green-500 text-white p-4 rounded-xl shadow-2xl flex items-center justify-between gap-3 animate-bounce">
                        <p class="font-bold text-sm"><?= $_SESSION['success']; ?></p>
                        <button onclick="this.parentElement.remove()">×</button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="bg-red-500 text-white p-4 rounded-xl shadow-2xl flex items-center justify-between gap-3">
                        <p class="font-bold text-sm"><?= $_SESSION['error']; ?></p>
                        <button onclick="this.parentElement.remove()">×</button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
            </div>
            <script>
                setTimeout(() => { document.getElementById('notification-container')?.remove(); }, 5000);
            </script>
        <?php endif; ?>

        <main class="p-4 lg:p-8">
            <div class="mb-6 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-6">
                    <div class="flex flex-col lg:flex-row items-center gap-6">
                        <div class="h-24 w-24 rounded-full overflow-hidden border-4 border-[#E7D8B8] shadow-sm">
                            <img src="../src/img/default_pfp.png" alt="Profile Picture" class="h-full w-full object-cover">
                        </div>

                        <div class="text-center lg:text-left">
                            <h1 class="text-2xl font-black text-gray-800"><?= $userData['fullName'] ?? $userData['userName']; ?></h1>
                            <p class="text-gray-500 text-sm"><?= $userData['email']; ?></p>
                            <div class="mt-3 flex flex-wrap justify-center lg:justify-start gap-2">
                                <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-bold uppercase">Role: <?= $userData['role']; ?></span>
                                <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-bold uppercase">Sejak: <?= date('Y', strtotime($userData['created_at'])); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <button onclick="openEditModal(<?= htmlspecialchars(json_encode($userData)); ?>, <?= $userData['profileID'] ?? 0; ?>)" 
                                class="flex items-center gap-2 px-6 py-3 bg-white border-2 border-[#D4A259] text-[#D4A259] hover:bg-[#D4A259] hover:text-white transition-all duration-300 rounded-xl font-bold text-sm shadow-sm group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            KEMASKINI PROFIL
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <?php if ($showForm): ?>
                    <div class="p-8">
                        <?php if(isset($userData['status']) && $userData['status'] == 'rejected'): ?>
                            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl">
                                <h3 class="text-red-800 font-bold text-sm uppercase">Permohonan Ditolak</h3>
                                <p class="text-red-600 text-sm italic">Sila kemaskini butiran anda di bawah.</p>
                            </div>
                        <?php endif; ?>

                        <h2 class="text-xl font-bold text-gray-800 mb-6">Lengkapkan Profil Ahli</h2>
                        <form action="../backend/process_request_member.php" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="text-xs font-bold text-gray-400 uppercase">Nama Penuh</label>
                                <input type="text" name="fullName" value="<?= $userData['fullName'] ?? ''; ?>" required class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4A259] outline-none">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase">No. IC</label>
                                <input type="text" name="NRIC" value="<?= $userData['NRIC'] ?? ''; ?>" required class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4A259] outline-none">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase">Kohort</label>
                                <input type="number" name="kohort" value="<?= $userData['kohort'] ?? '2025'; ?>" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4A259] outline-none">
                            </div>
                            <div class="md:col-span-2 mt-4">
                                <button type="submit" class="bg-[#D4A259] text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-[#b88a4a] transition-all">
                                    HANTAR PERMOHONAN
                                </button>
                            </div>
                        </form>
                    </div>

                <?php elseif (isset($userData['status']) && $userData['status'] == 'pending'): ?>
                    <div class="p-16 text-center">
                        <div class="h-16 w-16 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">!</div>
                        <h2 class="text-xl font-bold text-gray-800">Permohonan Sedang Disemak</h2>
                        <p class="text-gray-500 mt-2">Admin sedang mengesahkan permohonan anda.</p>
                    </div>

                <?php else: ?>
                    <div class="p-8">
                        <div class="flex justify-between items-center mb-6 border-b pb-4">
                            <h2 class="text-xl font-bold text-gray-800">Butiran Keahlian</h2>
                            <div class="flex gap-2">
                                <span class="px-4 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase">Status: ACTIVE</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div><p class="text-xs text-gray-400 uppercase font-bold">Nama</p><p class="font-bold text-gray-700"><?= $userData['fullName']; ?></p></div>
                            <div><p class="text-xs text-gray-400 uppercase font-bold">No. IC</p><p class="font-bold text-gray-700"><?= $userData['NRIC']; ?></p></div>
                            <div><p class="text-xs text-gray-400 uppercase font-bold">Kohort</p><p class="font-bold text-gray-700"><?= $userData['kohort']; ?></p></div>
                            <div><p class="text-xs text-gray-400 uppercase font-bold">Program</p><p class="font-bold text-gray-700"><?= $userData['programme']; ?></p></div>
                            <div><p class="text-xs text-gray-400 uppercase font-bold">Peranan Pukulan</p><p class="font-bold text-gray-700"><?= $userData['beatRoleType']; ?></p></div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <script>
                function toggleModal(modalId, cardId) {
                    const modal = document.getElementById(modalId);
                    const card = document.getElementById(cardId);
                    
                    if (modal.classList.contains('hidden')) {
                        modal.classList.remove('hidden');
                        setTimeout(() => {
                            modal.classList.remove('pointer-events-none');
                            card.classList.remove('scale-95', 'opacity-0', 'translate-y-4');
                        }, 10);
                    } else {
                        card.classList.add('scale-95', 'opacity-0', 'translate-y-4');
                        setTimeout(() => {
                            modal.classList.add('hidden', 'pointer-events-none');
                        }, 300);
                    }
                }
                
                function openEditModal(data, profileID) {
                    // Isi data ke dalam form modal
                    document.getElementById('edit_profileID').value = profileID;
                    document.getElementById('edit_userID').value = <?= $userID; ?>; // UserID dari session
                    document.getElementById('edit_email').value = data.email;
                    document.getElementById('edit_fullName').value = data.fullName;
                    document.getElementById('edit_NRIC').value = data.NRIC;
                    document.getElementById('edit_kohort').value = data.kohort;
                    document.getElementById('edit_programme').value = data.programme;
                    document.getElementById('edit_beatRoleType').value = data.beatRoleType;
                
                    toggleModal('editMemberModal', 'editMemberCard');
                }
                </script>
            </div>
        </main>
    </div>
</div>

<?php include '../src/components/modal_edit_member.php'; ?>
<?php include '../src/components/footer.php'; ?>