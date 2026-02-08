<?php include '../admin/admin_edit_data.php'; ?>
<?php include '../src/components/header.php'; ?>
<?php include '../src/components/navbar.php'; ?>

<div class="font-sans text-gray-800 flex items-center justify-center min-h-screen p-4">

    <main class="w-full max-w-2xl bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-4">Kemaskini Akaun</h2>

        <?php if ($message): ?>
            <div class="p-3 mb-4 rounded <?php echo ($message_type == 'success') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600">Emel (Tidak boleh diubah)</label>
                <input type="text" value="<?php echo htmlspecialchars($email); ?>" disabled class="w-full p-2 bg-gray-100 border rounded mt-1">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600">Kata Laluan Baru</label>
                <input type="password" name="new_password" class="w-full p-2 border rounded mt-1" required>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-600">Sahkan Kata Laluan</label>
                <input type="password" name="confirm_password" class="w-full p-2 border rounded mt-1" required>
            </div>
            <button type="submit" name="save_account" class="w-full bg-green-600 text-white p-2 rounded font-bold hover:bg-green-700">
                SIMPAN PERUBAHAN
            </button>
        </form>
    </main>
</div>

<?php include '../src/components/footer.php'; ?>