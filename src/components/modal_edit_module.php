<div id="editModuleModal" class="fixed inset-0 z-50 flex justify-center items-start pt-10 px-4 pointer-events-none hidden transition-all duration-300">
    <div id="editModuleCard" class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl border border-gray-100 pointer-events-auto transform transition-all duration-300 scale-95 opacity-0 translate-y-4">
        
        <div class="flex justify-between items-center p-6 border-b bg-gray-50 rounded-t-2xl">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Kemaskini Modul</h3>
                <p class="text-xs text-gray-500 mt-1">Ubah bahan rujukan atau penerangan modul.</p>
            </div>
            <button onclick="toggleModal('editModuleModal', 'editModuleCard')" class="h-10 w-10 flex items-center justify-center rounded-full bg-white border shadow-sm text-gray-400 hover:text-red-500 transition-all text-2xl">&times;</button>
        </div>

        <div class="p-6 max-h-[80vh] overflow-y-auto">
            <form action="../backend/process_edit_module.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="moduleID" id="edit_moduleID">
                
                <div class="space-y-5">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Nama Modul</label>
                        <input type="text" name="moduleName" id="edit_moduleName" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Penerangan Modul</label>
                        <textarea name="moduleDesc" id="edit_moduleDesc" rows="4" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all"></textarea>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-blue-50 rounded-xl border border-blue-100">
                            <label class="block text-xs font-bold text-blue-700 mb-1 uppercase">Imej (Baru)</label>
                            <input type="file" name="moduleThumbnail" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-3 file:py-1 file:px-3 file:rounded-full file:bg-blue-600 file:text-white border-none">
                            <p class="text-[10px] text-blue-400 mt-1 italic">Kosongkan jika tidak tukar imej</p>
                        </div>

                        <div class="p-4 bg-indigo-50 rounded-xl border border-indigo-100">
                            <label class="block text-xs font-bold text-indigo-700 mb-1 uppercase">Dokumen PDF (Baru)</label>
                            <input type="file" name="moduleDocs" accept=".pdf" class="block w-full text-xs text-gray-500 file:mr-3 file:py-1 file:px-3 file:rounded-full file:bg-indigo-600 file:text-white border-none">
                            <p class="text-[10px] text-indigo-400 mt-1 italic">Kosongkan jika tidak tukar PDF</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-3 mt-8 pt-6 border-t">
                    <button type="submit" class="flex-1 py-3 bg-indigo-600 text-white font-bold rounded-xl shadow-lg hover:bg-indigo-700 transition-all">KEMASKINI MODUL</button>
                    <button type="button" onclick="toggleModal('editModuleModal', 'editModuleCard')" class="flex-1 py-3 bg-white text-gray-500 font-semibold rounded-xl border border-gray-200">BATAL</button>
                </div>
            </form>
        </div>
    </div>
</div>