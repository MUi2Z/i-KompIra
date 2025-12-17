    <!-- Side Bar -->
        <aside id="sidebar" class="mt-2 mb-4 w-full lg:w-64 bg-[#EFE6D5] shadow-lg p-6 flex flex-col items-center text-center rounded-e-lg space-y-4">
            <div class="flex items-center space-x-2 mb-6">
                <div class="rounded-full bg-gray-200 h-16 w-16 flex items-center justify-center">
                    <svg class="h-10 w-10 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <span class="text-xl font-semibold text-gray-800 hidden lg:block"><?php echo 'i-KompIra' ?></span>
            </div>

            <a href="../admin/dashbord.php" class="w-full py-3 px-4 bg-[#D4A259] text-white font-semibold rounded-lg shadow hover:bg-[#D4A299] transition duration-200">DASHBOARD</a>
            <a href="../admin/member_list.php" class="w-full py-3 px-4 bg-[#D4A259] text-white font-semibold rounded-lg shadow hover:bg-[#D4A299] transition duration-200">URUS AHLI</a>
            <a href="../admin/activity_list.php" class="w-full py-3 px-4 bg-[#D4A259] text-white font-semibold rounded-lg shadow hover:bg-[#D4A299] transition duration-200">URUS AKTIVITI</a>
            <a href="../admin/module_list.php" class="w-full py-3 px-4 bg-[#D4A259] text-white font-semibold rounded-lg shadow hover:bg-[#D4A299] transition duration-200">URUS MODUL</a>
            <a href="../admin/rythm_list.php" class="w-full py-3 px-4 bg-[#D4A259] text-white font-semibold rounded-lg shadow hover:bg-[#D4A299] transition duration-200">URUS IRAMA</a>
            <a href="../public/index.php" class="w-full py-3 px-4 bg-red-500 text-white font-semibold rounded-lg shadow hover:bg-red-600 transition duration-200">KEMBALI KE UTAMA</a>
        </aside>

<?php 
// sidebar_admin.php - Diletakkan dalam '../src/components/'

// Kita menggunakan kelas 'fixed' dan 'z-40' untuk memastikan sidebar terapung di atas kandungan
// Kita tambahkan kelas 'hidden' secara lalai dan 'lg:block' untuk skrin besar
?>
<!-- <aside id="sidebar" class="hidden fixed top-0 left-0 h-full mt-16 w-64 bg-[#EFE6D5] shadow-lg p-6 flex-col items-center text-center rounded-e-lg space-y-4 z-40 lg:block lg:static lg:mt-2 lg:mb-4">
    <div class="flex items-center space-x-2 mb-6">
        <div class="rounded-full bg-gray-200 h-16 w-16 flex items-center justify-center">
            <svg class="h-10 w-10 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
            </svg>
        </div>
        <span class="text-xl font-semibold text-gray-800 hidden lg:block"><?php echo 'i-KompIra' ?></span> 
    </div>

    <a href="../admin/dashbord.php" class="w-full py-3 px-4 bg-[#D4A259] text-white font-semibold rounded-lg shadow hover:bg-[#D4A299] transition duration-200">DASHBOARD</a>
    <a href="../admin/member_list.php" class="w-full py-3 px-4 bg-[#D4A259] text-white font-semibold rounded-lg shadow hover:bg-[#D4A299] transition duration-200">URUS AHLI</a>
    <a href="../admin/activity_list.php" class="w-full py-3 px-4 bg-[#D4A259] text-white font-semibold rounded-lg shadow hover:bg-[#D4A299] transition duration-200">URUS AKTIVITI</a>
    <a href="../admin/module_list.php" class="w-full py-3 px-4 bg-[#D4A259] text-white font-semibold rounded-lg shadow hover:bg-[#D4A299] transition duration-200">URUS MODUL</a>
    <a href="../admin/rythm_list.php" class="w-full py-3 px-4 bg-[#D4A259] text-white font-semibold rounded-lg shadow hover:bg-[#D4A299] transition duration-200">URUS IRAMA</a>
    <a href="../public/index.php" class="w-full py-3 px-4 bg-red-500 text-white font-semibold rounded-lg shadow hover:bg-red-600 transition duration-200">KEMBALI KE UTAMA</a>
</aside> -->