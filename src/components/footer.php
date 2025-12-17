    <!-- Footer -->
    <footer class="bg-[#EFE6D5] rounded-lg shadow-sm m-4 border border-gray-200 mt-auto">
        <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
            <span class="text-sm text-gray-500 sm:text-center"><a href="#" class="hover:underline">i-KompIra</a> ©2025.</span>
        </div>
    </footer>
    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleButton = document.getElementById('sidebarToggle');
        const mainContent = document.getElementById('mainContent'); // Asumsi main content anda mempunyai ID ini

        // Fungsi untuk menukar kelas 'hidden' dan 'lg:block'
        toggleButton.addEventListener('click', function() {
            // Hanya berfungsi pada skrin kecil (kecuali lg)
            if (window.innerWidth < 1024) { 
                sidebar.classList.toggle('hidden');
            }
        });

        // PENTING: Untuk mengendalikan klik di luar sidebar pada skrin kecil (mobile overlay)
        document.addEventListener('click', function(event) {
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnToggle = toggleButton.contains(event.target);

            // Jika skrin kecil (mobile) DAN sidebar sedang dipaparkan DAN klik di luar sidebar & butang toggle
            if (window.innerWidth < 1024 && 
                !sidebar.classList.contains('hidden') && 
                !isClickInsideSidebar && 
                !isClickOnToggle) {
                
                sidebar.classList.add('hidden');
            }
        });
    </script>

</body>
</html>