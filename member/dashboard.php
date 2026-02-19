<?php 
    session_start();
    include '../config/connection.php';
    include '../src/components/header.php';
    include '../src/components/navbar.php';

    // Kawalan Akses: Benarkan 'user' dan 'member'
    if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'user' && $_SESSION['role'] !== 'member')) {
        header("Location: ../public/login.php"); 
        exit(); 
    }

    $userID = $_SESSION['userID'];
    $role = $_SESSION['role']; // Ambil role dari session

    // 1. Get Data Berdasarkan Role
    if ($role === 'member') {
        // Ambil data dari table members
        $profile_query = "SELECT m.*, u.email FROM members m JOIN users u ON m.userID = u.userID WHERE m.userID = ?";
        $stmt = $conn->prepare($profile_query);
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $userData = $stmt->get_result()->fetch_assoc();
        $displayName = $userData['fullName'];
        $displayRole = $userData['beatRoleType'] ?? 'Ahli Aktif';
    } else {
        // Ambil data asas dari table users sahaja untuk user biasa
        $profile_query = "SELECT email, username FROM users WHERE userID = ?";
        $stmt = $conn->prepare($profile_query);
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $userData = $stmt->get_result()->fetch_assoc();
        $displayName = $userData['username'];
        $displayRole = 'Bukan Ahli';
    }

    // 2. Get Statistics (Hanya ahli boleh nampak penyertaan sebenar)
    $stats = ['my_activities' => 0, 'total_modules' => 0, 'total_rhythms' => 0, 'notifications' => 0];

    if ($role === 'member') {
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM participations WHERE userID = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $stats['my_activities'] = $stmt->get_result()->fetch_assoc()['count'];
    }

    $stats['total_modules'] = $conn->query("SELECT COUNT(*) as count FROM modules")->fetch_assoc()['count'];
    $stats['total_rhythms'] = $conn->query("SELECT COUNT(*) as count FROM rhythms")->fetch_assoc()['count'];

    // 3. Get Upcoming Activities & Modules
    $upcoming_activities = $conn->query("SELECT * FROM activities WHERE status = 'ongoing' ORDER BY trainDate ASC LIMIT 3");
    $latest_modules = $conn->query("SELECT * FROM modules ORDER BY moduleID DESC LIMIT 3");
?>

<div class="flex min-h-screen">
    <?php include '../src/components/sidebar_member.php'; ?>
    
    <div class="flex-1 lg:flex-row min-h-screen">
        <main class="flex-1 py-2 px-4 lg:p-8">
            
            <div class="my-4 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex flex-col lg:flex-row items-center gap-6">
                    <div class="w-24 h-24 <?php echo ($role === 'member') ? 'bg-[#E7D8B8]' : 'bg-gray-200'; ?> rounded-full flex items-center justify-center border-4 border-white shadow-md">
                        <svg class="w-16 h-16 <?php echo ($role === 'member') ? 'text-[#D4A259]' : 'text-gray-400'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    
                    <div class="flex-1 text-center lg:text-left">
                        <h2 class="text-xl font-bold text-gray-800"><?php echo htmlspecialchars($displayName); ?></h2>
                        <p class="text-gray-600 mt-1">Status: <?php echo ($role === 'member') ? 'ID Ahli: #'.str_pad($userID, 4, '0', STR_PAD_LEFT) : 'Pelawat Terdaftar'; ?></p>
                        
                        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-2">
                                <p class="font-semibold text-gray-700 sm:text-right text-sm">EMAIL :</p>
                                <p class="bg-gray-50 border border-gray-200 rounded-md p-2 text-sm truncate sm:col-span-2"><?php echo $userData['email']; ?></p>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-2">
                                <p class="font-semibold text-gray-700 sm:text-right text-sm">PERANAN :</p>
                                <p class="bg-gray-50 border border-gray-200 rounded-md p-2 text-sm sm:col-span-2">
                                    <span class="px-2 py-1 <?php echo ($role === 'member') ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-600'; ?> rounded text-xs font-bold uppercase">
                                        <?php echo $displayRole; ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <?php if ($role === 'user'): ?>
                        <div>
                            <button onclick="location.href='register_member.php'" 
                                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-xl shadow-md transition animate-bounce">
                                DAFTAR AHLI SEKARANG
                            </button>
                        </div>
                    <?php else: ?>
                        <div>
                            <button onclick="location.href='profile.php'" 
                                    class="bg-[#D4A259] hover:bg-[#B88A4A] text-white font-bold py-2 px-6 rounded-xl shadow-md transition">
                                PROFIL SAYA
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Penyertaan Saya</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1"><?php echo $stats['my_activities']; ?></p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-xl"><svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></div>
                    </div>
                </div>
                </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="space-y-8">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h2 class="text-lg font-semibold text-gray-800">Sertai Aktiviti</h2>
                        </div>
                        <div class="p-6">
                            <?php if ($role === 'member'): ?>
                                <div class="space-y-4">
                                    <?php while ($act = $upcoming_activities->fetch_assoc()): ?>
                                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-transparent hover:border-[#D4A259]/20 transition">
                                            <div>
                                                <p class="font-bold text-gray-800"><?php echo htmlspecialchars($act['activityTitle']); ?></p>
                                                <p class="text-xs text-gray-500"><?php echo date('d M Y', strtotime($act['trainDate'])); ?></p>
                                            </div>
                                            <form action="../backend/process_join_activity.php" method="POST">
                                                <input type="hidden" name="activityID" value="<?php echo $act['activityID']; ?>">
                                                <button type="submit" class="px-4 py-2 bg-white border border-[#D4A259] text-[#D4A259] text-xs font-bold rounded-lg hover:bg-[#D4A259] hover:text-white transition">SERTAI</button>
                                            </form>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-6 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    <p class="text-sm text-gray-600 font-medium">Hanya ahli berdaftar boleh menyertai aktiviti.</p>
                                    <a href="register_member.php" class="text-[#D4A259] text-xs font-bold hover:underline mt-2 inline-block">DAFTAR SEBAGAI AHLI SEKARANG →</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-lg relative overflow-hidden group">
                        <div class="relative z-10">
                            <h3 class="text-xl font-bold mb-2">Latihan Interaktif</h3>
                            <p class="text-sm opacity-90 mb-4 max-w-xs text-gray-600">Tingkatkan kemahiran ketukan kompang anda.</p>
                            <?php if ($role === 'member'): ?>
                                <a href="practice.php" class="inline-block bg-yellow-800 text-white px-6 py-2 rounded-xl font-bold text-sm hover:shadow-lg transition">MULA LATIHAN</a>
                            <?php else: ?>
                                <button onclick="alert('Sila daftar sebagai ahli untuk akses latihan interaktif.')" class="bg-gray-400 text-white px-6 py-2 rounded-xl font-bold text-sm cursor-not-allowed">DISEKAT (AHLI SAHAJA)</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h2 class="text-lg font-semibold text-gray-800">Modul Terbaru</h2>
                        </div>
                        <div class="p-6">
                            <?php if ($role === 'member'): ?>
                                <div class="grid grid-cols-1 gap-4">
                                    <?php while ($mod = $latest_modules->fetch_assoc()): ?>
                                        <div class="flex items-center gap-4 p-3 border border-gray-100 rounded-xl">
                                            <div class="flex-1">
                                                <p class="font-bold text-sm text-gray-800"><?php echo htmlspecialchars($mod['moduleName']); ?></p>
                                            </div>
                                            <a href="../uploads/modules/<?php echo $mod['moduleDocs']; ?>" target="_blank" class="text-[#D4A259]"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg></a>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-6">
                                    <p class="text-sm text-gray-500 italic">Sila daftar sebagai ahli untuk memuat turun modul pembelajaran.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>