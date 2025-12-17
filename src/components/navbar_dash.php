<!-- Navbar admin/member -->
<nav class="bg-[#E7D8B8] shadow-sm sticky top-0 z-50">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        
        <div class="flex items-center">
            <button id="sidebar-toggle" type="button" class="inline-flex items-center p-2 mr-3 text-gray-600 rounded-lg lg:hidden hover:bg-gray-200 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <a href="../public/index.php" class="flex items-center space-x-3 rtl:space-x-reverse">
                <div class="h-10 w-10 bg-[#E7D8B8] rounded-full shadow-inner">
                    <img src="../src/img/favicon.png" alt="">
                </div>
                <span class="self-center text-xl font-bold whitespace-nowrap text-gray-800">i-KompIra</span>
            </a>
        </div>

        <div class="flex items-center md:order-2 space-x-3 rtl:space-x-reverse">
            <a href="../public/login.php" class="hidden md:block text-gray-600 hover:text-gray-800">
                <svg class="w-10 h-10 p-1 border-2 border-gray-400 rounded-full" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </a>
            <button data-collapse-toggle="navbar-centered-links" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-200">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
        </div>
        </div>
</nav>