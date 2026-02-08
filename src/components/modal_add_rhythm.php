<div id="addRhythmModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm transition-opacity duration-300 pointer-events-none">
    <div id="rhythmCard" class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 transform scale-95 opacity-0 translate-y-4 transition-all duration-300">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800">Tambah Irama Baharu</h3>
            <button onclick="toggleModal('addRhythmModal', 'rhythmCard')" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form action="../backend/process_add_rhythm.php" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            <input type="hidden" name="userID" value="<?php echo $_SESSION['userID']; ?>">

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tajuk Irama</label>
                <input type="text" name="title" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 outline-none transition-all" placeholder="Contoh: Irama Melalu Standard">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Huraian</label>
                <textarea name="description" rows="3" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 outline-none transition-all" placeholder="Terangkan tentang irama ini..."></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Beat Speed (BPM)</label>
                <input type="number" name="beatSpeed" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 outline-none transition-all" placeholder="120">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Fail MIDI (.mid)</label>
                <input type="file" name="midiSrc" accept=".mid,.midi" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 outline-none transition-all">
            </div>

            <div class="pt-4 flex gap-3">
                <button type="button" onclick="toggleModal('addRhythmModal', 'rhythmCard')" class="flex-1 px-4 py-2.5 border border-gray-200 text-gray-600 font-semibold rounded-xl hover:bg-gray-50 transition-all">Batal</button>
                <button type="submit" class="flex-1 px-4 py-2.5 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 shadow-md shadow-green-200 transition-all">Simpan Irama</button>
            </div>
        </form>
    </div>
</div>