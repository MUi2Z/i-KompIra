<?php 
    session_start();
    include '../config/connection.php';
    include '../src/components/header.php';
    include '../src/components/navbar.php';

    // Kawalan Akses: Pastikan role adalah 'user' atau 'member'
    if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'user' && $_SESSION['role'] !== 'member')) {
        header("Location: ../public/login.php"); 
        exit(); 
    }

    $userID = $_SESSION['userID'];

    // 1. Get Member Profile Data
    $profile_query = "SELECT m.*, u.email FROM members m JOIN users u ON m.userID = u.userID WHERE m.userID = ?";
    $stmt = $conn->prepare($profile_query);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $memberData = $stmt->get_result()->fetch_assoc();

    // 2. Get Statistics for Member
    $stats = [];

    // Aktiviti disertai (Status: joined)
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM participations WHERE userID = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $stats['my_activities'] = $stmt->get_result()->fetch_assoc()['count'];

    // Jumlah Modul Tersedia
    $modules_result = $conn->query("SELECT COUNT(*) as count FROM modules");
    $stats['total_modules'] = $modules_result->fetch_assoc()['count'];

    // Jumlah Irama Tersedia
    $rhythms_result = $conn->query("SELECT COUNT(*) as count FROM rhythms");
    $stats['total_rhythms'] = $rhythms_result->fetch_assoc()['count'];

    // Notifikasi Ahli (Unread)
    // Nota: Anda mungkin perlu table 'member_notifications' jika ada
    $stats['notifications'] = 0; 

    // 3. Get Upcoming Activities (Yang belum disertai)
    $upcoming_query = "SELECT a.* FROM activities a 
                       WHERE a.status = 'ongoing' 
                       AND a.activityID NOT IN (SELECT activityID FROM participations WHERE userID = ?)
                       ORDER BY a.trainDate ASC LIMIT 3";
    $stmt = $conn->prepare($upcoming_query);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $upcoming_activities = $stmt->get_result();

    // 4. Get Latest Modules
    $latest_modules = $conn->query("SELECT * FROM modules ORDER BY moduleID DESC LIMIT 3");
?>

<div class="flex min-h-screen">
    <?php include '../src/components/sidebar_member.php'; ?>
    
    <div class="flex-1 lg:flex-row min-h-screen">
        <main class="flex-1 py-2 px-4 lg:p-8">
            
            <div class="my-4 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex flex-col lg:flex-row items-center gap-6">
                    <div class="w-24 h-24 bg-[#E7D8B8] rounded-full flex items-center justify-center border-4 border-white shadow-md">
                        <svg class="w-16 h-16 text-[#D4A259]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    
                    <div class="flex-1 text-center lg:text-left">
                        <h2 class="text-xl font-bold text-gray-800"><?php echo htmlspecialchars($memberData['fullName'] ?? 'Ahli i-KompIra'); ?></h2>
                        <p class="text-gray-600 mt-1">ID Ahli: #<?php echo str_pad($userID, 4, '0', STR_PAD_LEFT); ?></p>
                        
                        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-2">
                                <p class="font-semibold text-gray-700 sm:text-right sm:col-span-1 text-sm">EMAIL :</p>
                                <p class="bg-gray-50 border border-gray-200 rounded-md p-2 text-sm truncate sm:col-span-2">
                                    <?php echo $memberData['email']; ?>
                                </p>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-2">
                                <p class="font-semibold text-gray-700 sm:text-right sm:col-span-1 text-sm">PERANAN :</p>
                                <p class="bg-gray-50 border border-gray-200 rounded-md p-2 text-sm sm:col-span-2">
                                    <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded text-xs font-bold uppercase">
                                        <?php echo $memberData['beatRoleType'] ?? 'Peserta'; ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <button onclick="location.href='profile.php'" 
                                class="bg-[#D4A259] hover:bg-[#B88A4A] text-white font-bold py-2 px-6 rounded-xl shadow-md transition">
                            PROFIL SAYA
                        </button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Penyertaan Saya</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1"><?php echo $stats['my_activities']; ?></p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Modul Teori</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1"><?php echo $stats['total_modules']; ?></p>
                        </div>
                        <div class="bg-indigo-100 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168 0.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332 0.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332 0.477-4.5 1.253"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Latihan Irama</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1"><?php echo $stats['total_rhythms']; ?></p>
                        </div>
                        <div class="bg-amber-100 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Mesej Baru</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1"><?php echo $stats['notifications']; ?></p>
                        </div>
                        <div class="bg-red-100 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="space-y-8">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h2 class="text-lg font-semibold text-gray-800">Sertai Aktiviti</h2>
                            <a href="participate.php" class="text-sm text-[#D4A259] font-bold hover:underline">Lihat Semua</a>
                        </div>
                        <div class="p-6">
                            <?php if ($upcoming_activities->num_rows > 0): ?>
                                <div class="space-y-4">
                                    <?php while ($act = $upcoming_activities->fetch_assoc()): ?>
                                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-[#EFE6D5]/30 transition border border-transparent hover:border-[#D4A259]/20">
                                            <div>
                                                <p class="font-bold text-gray-800"><?php echo htmlspecialchars($act['activityTitle']); ?></p>
                                                <p class="text-xs text-gray-500 flex items-center mt-1">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                    <?php echo date('d M Y', strtotime($act['trainDate'])); ?> • <?php echo $act['showDate']; ?>
                                                </p>
                                            </div>
                                            <?php if($act['status'] > 0): ?>
                                                <form action="../backend/process_join_activity.php" method="POST">
                                                    <input type="hidden" name="activityID" value="<?php echo $act['activityID']; ?>">
                                                    <button type="submit" class="px-4 py-2 bg-white border border-[#D4A259] text-[#D4A259] text-xs font-bold rounded-lg hover:bg-[#D4A259] hover:text-white transition">
                                                        SERTAI SEKARANG
                                                    </button>
                                                </form>
                                                <?php else: ?>
                                                    <form action="../backend/process_cancel_participate.php" method="POST" onsubmit="return confirm('Adakah anda pasti ingin membatalkan penyertaan ini?');">
                                                        <input type="hidden" name="activityID" value="<?php echo $act['activityID']; ?>">
                                                        <button type="submit" class="px-4 py-2 bg-white border border-[#D4A259] text-[#D4A259] text-xs font-bold rounded-lg hover:bg-[#D4A259] hover:text-white transition">BATAL SERTAI</button>
                                                    </form>
                                            <?php endif; ?>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            <?php else: ?>
                                <p class="text-gray-500 text-center py-8">Tiada aktiviti baru buat masa ini.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 text-orange-900 shadow-lg relative overflow-hidden group">
                        <div class="relative z-10">
                            <h3 class="text-xl font-bold mb-2">Latihan Interaktif</h3>
                            <p class="text-sm opacity-90 mb-4 max-w-xs">Tingkatkan kemahiran ketukan kompang anda dengan simulasi interaktif.</p>
                            <a href="practice.php" class="inline-block bg-yellow-800 text-[#ffffff] px-6 py-2 rounded-xl font-bold text-sm hover:shadow-lg transition">MULA LATIHAN</a>
                        </div>
                        <svg class="absolute -right-4 -bottom-4 w-32 h-32 opacity-10 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z"/>
                        </svg>
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h2 class="text-lg font-semibold text-gray-800">Modul Terbaru</h2>
                            <a href="modules.php" class="text-sm text-[#D4A259] font-bold hover:underline">Lihat Semua</a>
                        </div>
                        <div class="p-6">
                            <?php if ($latest_modules->num_rows > 0): ?>
                                <div class="grid grid-cols-1 gap-4">
                                    <?php while ($mod = $latest_modules->fetch_assoc()): ?>
                                        <div class="flex items-center gap-4 p-3 border border-gray-100 rounded-xl hover:shadow-sm transition">
                                            <div class="w-12 h-12 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-500">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-bold text-sm text-gray-800"><?php echo htmlspecialchars($mod['moduleName']); ?></p>
                                                <p class="text-xs text-gray-500">Teori & Praktikal</p>
                                            </div>
                                            <a href="../uploads/modules/<?php echo $mod['moduleDocs']; ?>" target="_blank" class="text-gray-400 hover:text-indigo-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            </a>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            <?php else: ?>
                                <p class="text-gray-500 text-center py-8">Modul belum dimuat naik.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4 text-center">Galeri Kelab</h2>
                        <div class="grid grid-cols-3 gap-2">
                            <div class="aspect-square bg-gray-100 rounded-lg animate-pulse"></div>
                            <div class="aspect-square bg-gray-100 rounded-lg animate-pulse"></div>
                            <div class="aspect-square bg-gray-100 rounded-lg animate-pulse"></div>
                        </div>
                        <a href="gallery.php" class="block text-center mt-4 text-sm font-bold text-[#D4A259] hover:underline">BUKA GALERI PENUH</a>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

<?php include '../src/components/footer.php'; ?>