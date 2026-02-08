<div id="editActivityModal" class="fixed inset-0 z-50 flex justify-center items-start pt-10 px-4 pointer-events-none hidden transition-all duration-300">
    <div id="editActivityCard" class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl border border-gray-100 pointer-events-auto transform transition-all duration-300 scale-95 opacity-0 translate-y-4">
        
        <div class="flex justify-between items-center p-6 border-b bg-gray-50 rounded-t-2xl">
            <h3 class="text-xl font-bold text-gray-800">Kemaskini Aktiviti</h3>
            <button onclick="toggleModal('editActivityModal', 'editActivityCard')" class="text-gray-400 hover:text-red-500 text-2xl">&times;</button>
        </div>

        <div class="p-6 max-h-[80vh] overflow-y-auto">
            <form action="../backend/process_edit_activity.php" method="POST" enctype="multipart/form-data">
                <div class="space-y-5">
                    <input type="hidden" name="activityID" id="edit_activityID">
                    
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Tajuk Aktiviti</label>
                        <input type="text" name="activityTitle" id="edit_activityTitle" required 
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 outline-none transition-all">
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Penerangan</label>
                        <textarea name="activityDesc" id="edit_activityDesc" rows="3" required 
                                  class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 outline-none transition-all"></textarea>
                    </div>

                    <div class="p-4 bg-blue-50 rounded-xl border border-blue-100">
                        <label class="block text-xs font-bold text-blue-700 mb-2 uppercase">Thumbnail (Biarkan kosong jika tiada perubahan)</label>
                        
                        <div id="current_image_preview" class="mb-3 hidden">
                            <p class="text-[10px] text-gray-500 mb-1">Gambar semasa:</p>
                            <img src="" id="existing_thumb" class="h-20 w-32 object-cover rounded border">
                        </div>

                        <input type="file" name="activityThumbnail" accept="image/*" 
                               class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-600 file:text-white cursor-pointer">
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-3 mt-8 pt-6 border-t">
                    <button type="submit" class="flex-1 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700">KEMASKINI DATA</button>
                    <button type="button" onclick="toggleModal('editActivityModal', 'editActivityCard')" class="flex-1 py-3 bg-white text-gray-500 font-semibold border rounded-xl">BATAL</button>
                </div>
            </form>
        </div>
    </div>
</div>