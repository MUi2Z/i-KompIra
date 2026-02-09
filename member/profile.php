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

// Ambil maklumat user & profil (JOIN table users & members)
$sql = "SELECT u.email, u.userName, u.role, u.created_at, m.* FROM users u 
        LEFT JOIN members m ON u.userID = m.userID
        WHERE u.userID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

// Generate CSRF token untuk borang permohonan
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<div class="flex min-h-screen">
    <?php include '../src/components/sidebar_member.php'; ?>

    <div class="flex-1 lg:flex-row min-h-screen">
        <?php if (isset($_SESSION['success']) || isset($_SESSION['error']) || isset($_SESSION['errors'])): ?>
            <div class="fixed top-6 right-6 z-[100] space-y-3 w-80">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="bg-green-500 text-white p-4 rounded-xl shadow-2xl flex items-center gap-3 animate-bounce">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <p class="font-bold text-sm"><?= $_SESSION['success'] ?></p>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="bg-red-500 text-white p-4 rounded-xl shadow-2xl flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        <p class="font-bold text-sm"><?= $_SESSION['error'] ?></p>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <main class="flex-1 py-2 px-4 lg:p-8">
            <div class="my-4 bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <div class="flex flex-col lg:flex-row items-center gap-8">
                    <div class="relative">
                        <div class="h-32 w-32 bg-[#E7D8B8] rounded-full flex items-center justify-center text-[#D4A259] text-5xl font-bold border-4 border-white shadow-xl">
                            <?php echo strtoupper(substr($userData['userName'], 0, 1)); ?>
                        </div>
                        <div class="absolute bottom-1 right-1 h-8 w-8 bg-green-500 border-4 border-white rounded-full"></div>
                    </div>

                    <div class="flex-1 text-center lg:text-left">
                        <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">
                            <?php echo $userData['fullName'] ?? $userData['userName']; ?>
                        </h1>
                        <p class="text-gray-500 flex items-center justify-center lg:justify-start gap-2 mt-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <?php echo $userData['email']; ?>
                        </p>
                        
                        <div class="flex flex-wrap justify-center lg:justify-start gap-3 mt-4">
                            <span class="px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest bg-[#D4A259]/10 text-[#D4A259] border border-[#D4A259]/20">
                                ROLE: <?php echo $userData['role']; ?>
                            </span>
                            <span class="px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest bg-gray-100 text-gray-600 border border-gray-200">
                                SEJAK: <?php echo date('Y', strtotime($userData['created_at'])); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                
                <?php if ($userData['role'] == 'user' && !isset($userData['status'])): ?>
                    <div class="p-8 lg:p-12">
                        <div class="max-w-2xl">
                            <h2 class="text-2xl font-bold text-gray-800">Lengkapkan Profil Ahli</h2>
                            <p class="text-gray-500 mt-2 mb-8">Sertai komuniti i-KompIra dengan melengkapkan butiran di bawah untuk kelulusan admin.</p>
                            
                            <form action="../backend/process_request_member.php" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-black text-gray-400 uppercase mb-2">Nama Penuh (IC)</label>
                                    <input type="text" name="fullName" required placeholder="NAMA SEPERTI DALAM KAD PENGENALAN" 
                                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4A259] focus:bg-white outline-none transition-all">
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase mb-2">No. Kad Pengenalan</label>
                                    <input type="text" name="NRIC" required placeholder="00010101XXXX" 
                                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4A259] focus:bg-white outline-none transition-all">
                                </div>

                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase mb-2">Kohort</label>
                                    <input type="number" name="kohort" value="2025" 
                                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4A259] focus:bg-white outline-none transition-all">
                                </div>

                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase mb-2">Program Pengajian</label>
                                    <select name="programme" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4A259] outline-none transition-all">
                                        <option>Diploma</option>
                                        <option>Sarjana Muda</option>
                                        <option>Pascasiswazah</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase mb-2">Kepakaran Irama</label>
                                    <select name="beatRoleType" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4A259] outline-none transition-all">
                                        <option value="Melalu">Melalu (Pemain Utama)</option>
                                        <option value="Menyilang">Menyilang (Pemain Tingkah)</option>
                                    </select>
                                </div>

                                <div class="md:col-span-2 pt-4">
                                    <button type="submit" class="w-full md:w-auto px-10 py-4 bg-[#D4A259] text-white font-bold rounded-xl shadow-lg shadow-amber-200 hover:bg-[#b88a4a] transform hover:-translate-y-1 transition-all">
                                        HANTAR PERMOHONAN AHLI
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                <?php elseif (isset($userData['status']) && $userData['status'] == 'pending'): ?>
                    <div class="p-16 text-center">
                        <div class="inline-flex items-center justify-center h-20 w-20 bg-amber-100 text-amber-600 rounded-full mb-6">
                            <svg class="w-10 h-10 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Permohonan Sedang Disemak</h2>
                        <p class="text-gray-500 mt-2 max-w-sm mx-auto">Sila tunggu sebentar. Admin i-KompIra sedang melakukan pengesahan maklumat NRIC anda.</p>
                    </div>

                <?php else: ?>
                    <div class="p-8 lg:p-10">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-6 mb-8">
                            <h2 class="text-xl font-bold text-gray-800">Butiran Keahlian Rasmi</h2>
                            <span class="px-4 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase tracking-widest shadow-sm">
                                STATUS: <?php echo $userData['status']; ?>
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                            <div>
                                <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Nama Penuh</p>
                                <p class="text-lg font-bold text-gray-700"><?php echo $userData['fullName']; ?></p>
                            </div>
                            <div>
                                <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">No. Kad Pengenalan</p>
                                <p class="text-lg font-bold text-gray-700"><?php echo $userData['NRIC']; ?></p>
                            </div>
                            <div>
                                <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Kohort</p>
                                <p class="text-lg font-bold text-gray-700">Kumpulan <?php echo $userData['kohort']; ?></p>
                            </div>
                            <div>
                                <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Program Pengajian</p>
                                <p class="text-lg font-bold text-gray-700"><?php echo $userData['programme']; ?></p>
                            </div>
                            <div>
                                <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Peranan Pukulan</p>
                                <p class="text-lg font-bold text-gray-700 flex items-center gap-2">
                                    <span class="h-2 w-2 bg-[#D4A259] rounded-full"></span>
                                    <?php echo $userData['beatRoleType']; ?>
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Tarikh Mohon</p>
                                <p class="text-lg font-bold text-gray-700"><?php echo date('d/m/Y', strtotime($userData['applied_at'])); ?></p>
                            </div>
                        </div>

                        <div class="mt-12 p-6 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                            <p class="text-sm text-gray-500 italic text-center">Untuk menukar maklumat sensitif (Nama/NRIC), sila hubungi Admin Kelab.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>

<?php include '../src/components/footer.php'; ?>