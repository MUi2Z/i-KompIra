<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Tentukan status default
$displayRole = "Guest";
$isLoggedIn = false;
$profileRedirect = "../public/login.php";

// 2. Semak jika pengguna sudah login
if (isset($_SESSION['userID'])) {
    $isLoggedIn = true;
    $uID = $_SESSION['userID'];
    
    $stmt = $conn->prepare("SELECT role, userName, email FROM users WHERE userID = ?");
    $stmt->bind_param("i", $uID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($user = $result->fetch_assoc()) {
        $displayRole = ucfirst($user['role']); 
        $displayName = $user['userName'];
        if ($user['userName'] == NULL) {
            $displayName = $user['role'];
        }
        $email = $user['email'];

        // Typo Fix: dashbord.php -> dashboard.php
        if ($displayRole == 'Admin') {
            $profileRedirect = '../admin/dashboard.php';
        }
        elseif ($displayRole == 'Member' || $displayRole == 'Ahli') {
            $profileRedirect = "../member/dashboard.php";
        }
        elseif ($displayRole == 'User' || $displayRole == 'Pengguna') {
            $profileRedirect = "../member/dashboard.php";
        }
    }
} else {
    $displayName = "Tetamu";
}

// --- LOGIK SEMBUNYI NAVBAR ---
// Semak jika URL mengandungi folder '/admin/'
$isAdminFolder = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false);
$isMemberFolder = (strpos($_SERVER['PHP_SELF'], '/member/') !== false);
?>

<?php if (!$isAdminFolder && !$isMemberFolder): // Hanya papar jika BUKAN dalam folder admin atau member ?>
<nav class="bg-[#E7D8B8] shadow-sm">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">

        <a href="../public/index.php" class="flex items-center space-x-3 rtl:space-x-reverse">
            <div class="h-10 w-10 bg-[#E7D8B8] rounded-full shadow-inner overflow-hidden">
                <img src="../src/img/favicon.png" alt="Logo" class="w-full h-full object-cover">
            </div>
            <span class="self-center text-xl font-bold whitespace-nowrap text-gray-800">i-KompIra</span>
        </a>

        <div class="flex items-center md:order-2 space-x-3 rtl:space-x-reverse">
            <a href="<?php echo $profileRedirect; ?>" class="hidden md:block text-gray-600 hover:text-gray-800">
                <svg class="w-10 h-10 p-1 border-2 border-gray-400 rounded-full" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </a>
            
            <div class="hidden md:flex flex-col text-gray-600">
                <?php if ($isLoggedIn): ?>
                    <span class="text-xs leading-none">Selamat Datang,</span>
                    <span class="text-sm font-bold text-gray-800 leading-none mb-1">
                        <?php echo htmlspecialchars($displayName); ?>
                    </span>
                <?php else: ?>
                    <a href="<?php echo $profileRedirect; ?>" class="px-4 py-2 bg-green-600 text-white text-sm font-bold rounded hover:bg-green-500 transition-colors">
                        Log Masuk
                    </a>
                <?php endif; ?>
            </div>

            <?php if ($isLoggedIn): ?>
                <a href="../backend/logout.php" class="hidden md:block ml-4 text-xs font-bold text-red-600 hover:underline">
                    <svg class="w-6 h-6 text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2"/>
                    </svg>
                </a>
            <?php endif; ?>

            <button data-collapse-toggle="navbar-centered-links" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-centered-links" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
        </div>

        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-centered-links">
            <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium uppercase text-sm border border-gray-200 rounded-lg bg-[#f0ebe5] md:space-x-10 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent">
                <li>
                    <a href="../public/index.php" class="block py-2 px-3 text-gray-800 rounded hover:bg-gray-200 md:hover:bg-transparent md:hover:text-gray-700 md:p-0">Utama</a>
                </li>
                <li>
                    <a href="../public/info.php" class="block py-2 px-3 text-gray-800 rounded hover:bg-gray-200 md:hover:bg-transparent md:hover:text-gray-700 md:p-0">Info</a>
                </li>
                <li>
                    <a href="../public/activity.php" class="block py-2 px-3 text-gray-800 rounded hover:bg-gray-200 md:hover:bg-transparent md:hover:text-gray-700 md:p-0">Tutorial</a>
                </li>
                <?php if (($displayRole == 'Admin') || ($displayRole == 'Member')): ?>
                <li>
                    <a href="<?php echo htmlspecialchars($profileRedirect); ?>" class="block py-2 px-3 text-yellow-600 font-bold rounded hover:bg-gray-200 md:hover:bg-transparent md:p-0"><?php echo htmlspecialchars($displayRole); ?> Panel</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<?php endif; ?>