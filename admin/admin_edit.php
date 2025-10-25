<?php include '../admin/admin_edit_data.php'; ?>
<?php include '../src/components/header.php'; ?>
<?php include '../src/components/navbar.php'; ?>

<div class="font-sans text-gray-800 flex items-center justify-center min-h-screen p-4">

        <main class="w-full max-w-2xl bg-white/30 p-8 rounded-lg shadow-md">
        
        <h1 class="text-3xl font-bold text-center mb-8">AKAUN PENYELIA</h1>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-10">
            <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center border-4 border-white shadow-md">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <button class="btn-beige text-gray-800 font-semibold py-2 px-5 rounded-md shadow-md transition">TAMBAH GAMBAR</button>
        </div>

        <?php if (!empty($message)): ?>
            <div class="mb-6 p-4 rounded-md text-center <?php echo $message_type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2 items-center">
                <label for="email" class="font-semibold text-gray-700 md:text-right">EMAIL :</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email"
                    value="<?php echo htmlspecialchars($email); ?>" 
                    class="md:col-span-2 input-field-bg border border-gray-400 rounded-md p-2 shadow-inner w-full bg-gray-200"
                    required>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2 items-center">
                <label for="new_password" class="font-semibold text-gray-700 md:text-right">KATA LALUAN BARU :</label>
                <input 
                    type="password" 
                    id="new_password" 
                    name="new_password"
                    class="md:col-span-2 input-field-bg border border-gray-400 rounded-md p-2 shadow-inner w-full focus:outline-none focus:ring-2 focus:ring-[#D4A373]">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-2 items-center">
                <label for="confirm_password" class="font-semibold text-gray-700 md:text-right">SAHKAN KATA LALUAN :</label>
                <input 
                    type="password" 
                    id="confirm_password" 
                    name="confirm_password"
                    class="md:col-span-2 input-field-bg border border-gray-400 rounded-md p-2 shadow-inner w-full focus:outline-none focus:ring-2 focus:ring-[#D4A373]">
            </div>

            <div class="text-center pt-4">
                 <button type="submit" name="save_account" class="bg-[#6A8D73] hover:bg-[#6A8D9F] text-white font-bold py-2 px-12 rounded-md shadow-md transition">SIMPAN</button>
            </div>

        </form>
        </main>
</div>

<?php include '../src/components/footer.php'; ?>