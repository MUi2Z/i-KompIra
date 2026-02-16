<div id="addRhythmModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm transition-opacity duration-300">
    <div id="rhythmCard" class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 transform transition-all duration-300">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800">Tambah Irama Baharu</h3>
            <button onclick="toggleModal('addRhythmModal')" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form action="../backend/process_add_rhythm.php" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-black text-gray-400 uppercase mb-1">Tajuk Irama</label>
                <input type="text" name="title" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4A259] outline-none transition-all" placeholder="Contoh: Irama Melalu Standard">
            </div>

            <div>
                <label class="block text-xs font-black text-gray-400 uppercase mb-1">Huraian</label>
                <textarea name="description" rows="2" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4A259] outline-none transition-all" placeholder="Terangkan tentang irama ini..."></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase mb-1">Speed (BPM)</label>
                    <input type="number" name="beatSpeed" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4A259] outline-none transition-all" placeholder="120">
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase mb-1">Tahap</label>
                    <select name="difficulty" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4A259] outline-none transition-all">
                        <option value="Easy">Easy</option>
                        <option value="Medium">Medium</option>
                        <option value="Hard">Hard</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-black text-gray-400 uppercase mb-1">Fail JSON (.json)</label>
                <input type="file" name="source" accept=".json" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4A259] outline-none transition-all text-sm">
            </div>

            <div>
                <label class="block text-xs font-black text-gray-400 uppercase mb-1">Fail Audio (.mp3)</label>
                <input type="file" name="audio_path" accept="audio/*" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4A259] outline-none transition-all text-sm">
            </div>

            <div class="pt-4 flex gap-3">
                <button type="button" onclick="toggleModal('addRhythmModal')" class="flex-1 px-4 py-2.5 border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition-all">Batal</button>
                <button type="submit" class="flex-1 px-4 py-2.5 bg-[#D4A259] text-white font-bold rounded-xl hover:bg-[#b88a4a] shadow-lg shadow-amber-100 transition-all">Simpan</button>
            </div>
        </form>
    </div>
</div>