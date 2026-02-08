<button onclick="toggleSidebar()" class="lg:hidden fixed top-4 left-4 z-[60] bg-[#D4A259] text-white p-2 rounded-md shadow-lg">
    <svg id="toggleIconMobile" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
</button>

<div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black bg-opacity-50 z-[40] hidden lg:hidden"></div>

<aside id="sidebar" class="fixed lg:sticky top-0 left-0 z-[50] h-screen bg-[#EFE6D5] shadow-md transition-all duration-300 ease-in-out 
    w-64 -translate-x-full lg:translate-x-0 lg:w-64 flex flex-col rounded-e-2xl overflow-hidden my-4">
    
    <div class="p-6 flex items-center justify-between border-b border-[#D4A259]/20">
        <div class="flex items-center space-x-3 overflow-hidden">
            <div class="h-10 w-10 bg-[#E7D8B8] rounded-xl shadow-inner flex-shrink-0 flex items-center justify-center p-2">
                <img src="../src/img/favicon.png" alt="Logo" class="w-full">
            </div>
            <span class="sidebar-text text-xl font-bold text-gray-800 whitespace-nowrap">i-KompIra</span>
        </div>
        <button onclick="collapseDesktop()" class="hidden lg:block text-[#D4A259] hover:bg-[#D4A259]/10 p-1 rounded-md">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
        </button>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto custom-scrollbar">
        <?php
        $menus = [
            ['Dashboard', '../admin/dashboard.php', 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
            ['Urus Ahli', '../admin/members.php', 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
            ['Urus Aktiviti', '../admin/activities.php', 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
            ['Urus Modul', '../admin/modules.php', 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168 0.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332 0.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332 0.477-4.5 1.253'],
            ['Urus Irama', '../admin/rhythms.php', 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z'],
        ];

        foreach ($menus as $menu) : ?>
            <a href="<?= $menu[1] ?>" class="flex items-center space-x-3 py-3 px-4 text-gray-700 font-semibold rounded-xl hover:bg-[#D4A259] hover:text-white transition-all duration-200 group">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $menu[2] ?>"></path></svg>
                <span class="sidebar-text whitespace-nowrap"><?= $menu[0] ?></span>
            </a>
        <?php endforeach; ?>
    </nav>

    <div class="p-4 border-t border-[#D4A259]/20 space-y-2">
        <a href="../backend/logout.php" class="flex items-center space-x-3 py-3 px-4 bg-red-50 text-red-600 font-bold rounded-xl hover:bg-red-600 hover:text-white transition-all duration-200 group">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            <span class="sidebar-text whitespace-nowrap">Log Keluar</span>
        </a>
    </div>
</aside>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }

    function collapseDesktop() {
        const sidebar = document.getElementById('sidebar');
        const texts = document.querySelectorAll('.sidebar-text');
        
        if (sidebar.classList.contains('lg:w-64')) {
            // Kecilkan
            sidebar.classList.replace('lg:w-64', 'lg:w-20');
            texts.forEach(t => t.classList.add('lg:hidden'));
        } else {
            // Besarkan
            sidebar.classList.replace('lg:w-20', 'lg:w-64');
            texts.forEach(t => t.classList.remove('lg:hidden'));
        }
    }
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #D4A259; border-radius: 10px; }
</style>