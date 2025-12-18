<?php include '../src/components/header.php'; ?>
<?php include '../src/components/navbar.php'; ?>

<div class="min-h-screen bg-[#EFE6D5] flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
        
        <div class="text-center mb-8">
            <div class="mx-auto h-16 w-16 bg-[#D4A259] rounded-full flex items-center justify-center mb-4">
                <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-800">Daftar Akaun</h2>
            <p class="text-gray-500 mt-2">Sertai komuniti i-KompIra hari ini</p>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div class="mb-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 text-sm">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <form action="../backend/process_register.php" method="POST" class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700">Alamat Email</label>
                <input type="email" name="email" required 
                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-[#D4A259] focus:border-[#D4A259] outline-none transition"
                       placeholder="contoh@email.com">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Kata Laluan</label>
                <input type="password" name="password" required minlength="6"
                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-[#D4A259] focus:border-[#D4A259] outline-none transition"
                       placeholder="Minimum 6 aksara">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Sahkan Kata Laluan</label>
                <input type="password" name="confirm_password" required 
                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-[#D4A259] focus:border-[#D4A259] outline-none transition"
                       placeholder="Ulang kata laluan">
            </div>

            <button type="submit" 
                    class="w-full py-3 bg-[#D4A259] text-white font-bold rounded-lg shadow-md hover:bg-[#b88a4a] transition duration-200">
                DAFTAR SEKARANG
            </button>
        </form>

        <div class="mt-8 text-center border-t pt-6">
            <p class="text-sm text-gray-600">
                Sudah mempunyai akaun? 
                <a href="login.php" class="text-[#D4A259] font-bold hover:underline">Log Masuk</a>
            </p>
        </div>
    </div>
</div>

<?php include '../src/components/footer.php'; ?>