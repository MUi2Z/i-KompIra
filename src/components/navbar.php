<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

$displayRole = "Guest";
$isLoggedIn = false;
$profileRedirect = "../public/login.php";

if (isset($_SESSION['userID'])) {
    $isLoggedIn = true;
    $uID = $_SESSION['userID'];
    $stmt = $conn->prepare("SELECT role, userName FROM users WHERE userID = ?");
    $stmt->bind_param("i", $uID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($user = $result->fetch_assoc()) {
        $displayRole = ucfirst($user['role']); 
        $displayName = $user['userName'] ?? $user['role'];
        $profileRedirect = ($displayRole == 'Admin') ? '../admin/dashboard.php' : "../member/dashboard.php";
    }
} else {
    $displayName = "Tetamu";
}

$isAdminFolder = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false);
$isMemberFolder = (strpos($_SERVER['PHP_SELF'], '/member/') !== false);
$isPractiseFolder = (strpos($_SERVER['PHP_SELF'], '/practice/') !== false);
?>

<?php if (!$isAdminFolder && !$isMemberFolder && !$isPractiseFolder) : ?>
<nav class="bg-[#E7D8B8] shadow-sm sticky top-0 z-50">
    <div class="max-w-screen-xl flex items-center justify-between mx-auto p-4">

        <a href="../public/index.php" class="flex items-center space-x-2">
            <img src="../src/img/favicon.png" alt="Logo" class="w-8 h-8 md:w-10 md:h-10">
            <span class="self-center text-lg md:text-xl font-black text-gray-800">i-KompIra</span>
        </a>
        
        <div class="hidden md:flex flex-1 justify-center">
            <ul class="flex space-x-8 font-bold uppercase text-xs tracking-widest text-gray-700">
                <li><a href="index.php#utama" class="hover:text-amber-800 transition">Utama</a></li>
                <li><a href="index.php#info" class="hover:text-amber-800 transition">Info</a></li>
                <li><a href="index.php#tutorial" class="hover:text-amber-800 transition">Tutorial</a></li>
                <li><a href="index.php#aktiviti" class="hover:text-amber-800 transition">Aktiviti</a></li>
                
                <?php if ($isLoggedIn && ($displayRole == 'Admin' || $displayRole == 'Member')): ?>
                    <li><a href="<?= $profileRedirect; ?>" class="text-amber-700 border-l pl-8 border-gray-300"><?= $displayRole; ?> Panel</a></li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="flex items-center gap-3">
            <?php if ($isLoggedIn): ?>
                <div class="flex items-center gap-2 bg-white/50 px-3 py-1 rounded-full border border-white/50">
                    <div class="hidden sm:block text-right">
                        <p class="text-[10px] leading-none text-gray-500 uppercase font-bold">Profil</p>
                        <p class="text-xs font-black text-gray-800"><?= htmlspecialchars($displayName); ?></p>
                    </div>
                    <a href="<?= $profileRedirect; ?>" class="transition hover:opacity-75">
                        <svg class="w-8 h-8 p-1 bg-white rounded-full text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </a>
                    <a href="../backend/logout.php" class="ml-1 text-red-600" title="Logout">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </a>
                </div>
            <?php else: ?>
                <a href="login.php" class="px-5 py-2 bg-blue-400 text-white text-xs font-black rounded-full hover:bg-blue-500 transition-all shadow-md uppercase tracking-wider">
                    Log Masuk
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<?php endif; ?>