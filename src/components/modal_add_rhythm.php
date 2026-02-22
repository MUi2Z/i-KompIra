<div id="addRhythmModal" class="fixed inset-0 z-50 flex justify-center items-start pt-10 px-4 pointer-events-none hidden transition-all duration-300 bg-black/40 backdrop-blur-sm">
    
    <div id="rhythmCard" class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl border border-gray-100 pointer-events-auto transform transition-all duration-300 scale-95 opacity-0 translate-y-4 overflow-hidden">
        
        <div class="flex justify-between items-center p-6 border-b bg-gray-50 rounded-t-2xl">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Tambah Irama Baru</h3>
                <p class="text-xs text-gray-500 mt-1">Sediakan data irama digital untuk latihan ahli.</p>
            </div>
            <button type="button" onclick="toggleModal('addRhythmModal', 'rhythmCard')" 
                    class="h-10 w-10 flex items-center justify-center rounded-full bg-white border shadow-sm text-gray-400 hover:text-red-500 transition-all text-2xl">
                &times;
            </button>
        </div>

        <div class="p-6 max-h-[80vh] overflow-y-auto">
            <form action="../backend/process_add_rhythm.php" method="POST">
                <input type="hidden" name="userID" value="<?php echo $_SESSION['userID']; ?>">

                <div class="space-y-5">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Nama Irama</label>
                        <input type="text" name="title" required 
                               placeholder="Contoh: Rentak Inang (Melalu)"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4A259] focus:bg-white outline-none transition-all">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-sm font-semibold text-gray-700">Tempo (BPM)</label>
                            <input type="number" name="beatSpeed" required 
                                   placeholder="100"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4A259] focus:bg-white outline-none transition-all">
                        </div>

                        <div class="space-y-1">
                            <label class="text-sm font-semibold text-gray-700">Tahap Kesukaran</label>
                            <select name="difficulty" 
                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4A259] focus:bg-white outline-none transition-all">
                                <option value="Easy">Mudah</option>
                                <option value="Medium">Sederhana</option>
                                <option value="Hard">Sukar</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Huraian Irama</label>
                        <textarea name="description" rows="2" 
                                  placeholder="Terangkan kegunaan irama ini..."
                                  class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4A259] focus:bg-white outline-none transition-all"></textarea>
                    </div>

                    <div class="space-y-1">
                        <div class="flex justify-between items-center">
                            <label class="text-sm font-semibold text-gray-700">Data JSON (Beatmap)</label>
                            <a href="../practice/recorder.php" target="_blank" class="text-xs font-bold text-[#D4A259] hover:underline flex items-center gap-1">
                                <i class="fas fa-external-link-alt text-[10px]"></i> Buka Recorder
                            </a>
                        </div>
                        <textarea id="add_source" name="source" rows="5" required 
                                  placeholder='Paste kod dari Recorder di sini...'
                                  class="w-full px-4 py-2.5 bg-gray-50 text-orange-900 border border-gray-800 rounded-xl font-mono text-xs focus:ring-2 focus:ring-[#D4A259] outline-none transition-all shadow-inner"></textarea>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-3 mt-8 pt-6 border-t">
                    <button type="submit" 
                            class="flex-1 py-3 bg-[#D4A259] text-white font-bold rounded-xl shadow-lg shadow-orange-100 hover:bg-[#b88a4a] hover:-translate-y-1 transition-all uppercase tracking-wider">
                        Simpan Irama
                    </button>
                    <button type="button" onclick="toggleModal('addRhythmModal', 'rhythmCard')" 
                            class="flex-1 py-3 bg-white text-gray-500 font-semibold rounded-xl border border-gray-200 hover:bg-gray-50 transition-all">
                        BATAL
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>