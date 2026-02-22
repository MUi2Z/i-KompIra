<div id="modalEditProfile" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
    
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-md rounded-2xl shadow-2xl transform transition-all">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Kemaskini Profil</h3>
                <button onclick="toggleModal('modalEditProfile')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <form action="../backend/process_edit_profile.php" method="POST" class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase">Nama Pengguna (Username)</label>
                    <input type="text" name="userName" value="<?php echo htmlspecialchars($currentUserName); ?>" 
                           class="w-full mt-1 p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6A8D73] outline-none" required>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase">Emel (Tetap)</label>
                    <input type="email" value="<?php echo htmlspecialchars($currentEmail); ?>" disabled 
                           class="w-full mt-1 p-2.5 bg-gray-50 border border-gray-200 rounded-lg text-gray-400 cursor-not-allowed">
                </div>

                <div class="pt-2 border-t border-gray-100">
                    <p class="text-[10px] text-amber-600 mb-2 font-semibold">* Isi jika ingin tukar kata laluan sahaja</p>
                    <div class="space-y-3">
                        <input type="password" name="new_password" placeholder="Kata Laluan Baru" 
                               class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6A8D73] outline-none text-sm">
                        <input type="password" name="confirm_password" placeholder="Sahkan Kata Laluan" 
                               class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6A8D73] outline-none text-sm">
                    </div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="toggleModal('modalEditProfile')" 
                            class="flex-1 px-4 py-2.5 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 font-semibold transition">
                        Batal
                    </button>
                    <button type="submit" name="save_account" 
                            class="flex-1 px-4 py-2.5 bg-[#6A8D73] text-white rounded-lg hover:bg-[#5a7d63] font-semibold shadow-md transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.toggle('hidden');
}
</script>