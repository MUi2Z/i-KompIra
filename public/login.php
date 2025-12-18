<?php include '../src/components/header.php'; ?>
<?php include '../src/components/navbar.php'; ?>
<?php if (isset($_GET['success'])): ?>
    <div class="mb-4 p-3 bg-green-100 border-l-4 border-green-500 text-green-700 text-sm">
        <?php echo htmlspecialchars($_GET['success']); ?>
    </div>
<?php endif; ?>

<div class="min-h-screen bg-[#EFE6D5] flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
        
        <div class="text-center mb-8">
            <div class="mx-auto h-16 w-16 bg-[#D4A259] rounded-full flex items-center justify-center mb-4">
                <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-800">Log Masuk</h2>
            <p class="text-gray-500 mt-2">Selamat Datang ke i-KompIra</p>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div class="mb-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 text-sm">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <form action="../backend/process_login.php" method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Alamat Email</label>
                <input type="email" name="email" required 
                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-[#D4A259] focus:border-[#D4A259] outline-none transition"
                       placeholder="nama@email.com">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Kata Laluan</label>
                <input type="password" name="password" required 
                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-[#D4A259] focus:border-[#D4A259] outline-none transition"
                       placeholder="••••••••">
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input type="checkbox" id="remember" class="h-4 w-4 text-[#D4A259] border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-600">Ingat Saya</label>
                </div>
                <a href="#" class="text-sm text-[#D4A259] hover:underline">Lupa Kata Laluan?</a>
            </div>

            <button type="submit" 
                    class="w-full py-3 bg-[#D4A259] text-white font-bold rounded-lg shadow-md hover:bg-[#b88a4a] transition duration-200 transform hover:-translate-y-1">
                MASUK
            </button>
        </form>

        <div class="mt-8 text-center border-t pt-6">
            <p class="text-sm text-gray-600">
                Belum mempunyai akaun? 
                <a href="register.php" class="text-[#D4A259] font-bold hover:underline">Daftar Sekarang</a>
            </p>
        </div>
    </div>
</div>

<?php include '../src/components/footer.php'; ?>