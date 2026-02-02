<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Tentukan status default sebagai Guest
$displayRole = "Guest";
$isLoggedIn = false;

// 2. Semak jika pengguna sudah login
if (isset($_SESSION['userID'])) {
    $isLoggedIn = true;
    $uID = $_SESSION['userID'];
    
    // Ambil role terkini dari database menggunakan Prepared Statement
    $stmt = $conn->prepare("SELECT role FROM users WHERE userID = ?");
    $stmt->bind_param("i", $uID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($user = $result->fetch_assoc()) {
        $displayRole = ucfirst($user['role']); // Papar Admin, Member, atau User
    }
}
?>

<nav class="bg-[#E7D8B8] shadow-sm">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">

        <a href="../public/index.php" class="flex items-center space-x-3 rtl:space-x-reverse">
            <div class="h-10 w-10 bg-[#E7D8B8] rounded-full shadow-inner overflow-hidden">
                <img src="../src/img/favicon.png" alt="Logo" class="w-full h-full object-cover">
            </div>
            <span class="self-center text-xl font-bold whitespace-nowrap text-gray-800">i-KompIra</span>
        </a>

        <div class="flex items-center md:order-2 space-x-3 rtl:space-x-reverse">
            <a href="<?php echo $isLoggedIn ? '../public/profile.php' : '../public/login.php'; ?>" class="hidden md:block text-gray-600 hover:text-gray-800">
                <svg class="w-10 h-10 p-1 border-2 border-gray-400 rounded-full" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </a>
            
            <div class="hidden md:flex flex-col text-gray-600">
                <span class="text-xs leading-none">Selamat Datang,</span>
                <span class="text-sm font-bold leading-tight">
                    <span class="<?php echo ($displayRole == 'Admin') ? 'text-red-600' : (($displayRole == 'Member') ? 'text-[#D4A259]' : 'text-blue-700'); ?>">
                        <?php echo htmlspecialchars($displayRole); ?>
                    </span>
                </span>
            </div>

            <?php if ($isLoggedIn): ?>
                <a href="../backend/logout.php" class="hidden md:block ml-4 text-xs font-bold text-red-600 hover:underline">
                    LOG KELUAR
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
                    <a href="../public/index.php" class="block py-2 px-3 text-gray-800 rounded hover:bg-gray-200 md:hover:bg-transparent md:hover:text-orange-600 md:p-0">Utama</a>
                </li>
                <li>
                    <a href="../public/info.php" class="block py-2 px-3 text-gray-800 rounded hover:bg-gray-200 md:hover:bg-transparent md:hover:text-orange-600 md:p-0">Info</a>
                </li>
                <li>
                    <a href="../public/activity.php" class="block py-2 px-3 text-gray-800 rounded hover:bg-gray-200 md:hover:bg-transparent md:hover:text-orange-600 md:p-0">Tutorial</a>
                </li>
                <?php if ($displayRole == 'Admin'): ?>
                <li>
                    <a href="../admin/dashboard.php" class="block py-2 px-3 text-red-600 font-bold rounded hover:bg-gray-200 md:hover:bg-transparent md:p-0">Admin Panel</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>