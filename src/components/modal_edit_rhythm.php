<div id="editRhythmModal" class="fixed inset-0 z-50 flex justify-center items-start pt-10 px-4 pointer-events-none hidden transition-all duration-300 bg-black/40 backdrop-blur-sm">
    
    <div id="editRhythmCard" class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl border border-gray-100 pointer-events-auto transform transition-all duration-300 scale-95 opacity-0 translate-y-4 overflow-hidden">
        
        <div class="flex justify-between items-center p-6 border-b bg-blue-50 rounded-t-2xl">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Kemaskini Irama</h3>
                <p class="text-xs text-gray-500 mt-1">Ubah maklumat irama digital yang sedia ada.</p>
            </div>
            <button type="button" onclick="toggleModal('editRhythmModal', 'editRhythmCard')" 
                    class="h-10 w-10 flex items-center justify-center rounded-full bg-white border shadow-sm text-gray-400 hover:text-red-500 transition-all text-2xl">
                &times;
            </button>
        </div>

        <div class="p-6 max-h-[80vh] overflow-y-auto">
            <form action="../backend/process_edit_rhythm.php" method="POST">
                <input type="hidden" name="rhythmID" id="edit_rhythmID">

                <div class="space-y-5">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Nama Irama</label>
                        <input type="text" name="title" id="edit_title" required 
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-sm font-semibold text-gray-700">Tempo (BPM)</label>
                            <input type="number" name="beatSpeed" id="edit_beatSpeed" required 
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                        </div>

                        <div class="space-y-1">
                            <label class="text-sm font-semibold text-gray-700">Tahap Kesukaran</label>
                            <select name="difficulty" id="edit_difficulty"
                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                                <option value="Mudah">Mudah</option>
                                <option value="Sederhana">Sederhana</option>
                                <option value="Sukar">Sukar</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Huraian</label>
                        <textarea name="description" id="edit_description" rows="2" 
                                  class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all"></textarea>
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Data JSON (Beatmap)</label>
                        <textarea name="source" id="edit_source" rows="6" required 
                                  class="w-full px-4 py-2.5 bg-gray-50 text-orange-900 border border-gray-800 rounded-xl font-mono text-xs focus:ring-2 focus:ring-blue-500 outline-none shadow-inner"></textarea>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-3 mt-8 pt-6 border-t">
                    <button type="submit" 
                            class="flex-1 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700 hover:-translate-y-1 transition-all uppercase">
                        Simpan Perubahan
                    </button>
                    <button type="button" onclick="toggleModal('editRhythmModal', 'editRhythmCard')" 
                            class="flex-1 py-3 bg-white text-gray-500 font-semibold rounded-xl border border-gray-200 hover:bg-gray-50 transition-all">
                        BATAL
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>