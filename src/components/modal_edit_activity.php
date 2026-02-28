<div id="editActivityModal" class="fixed inset-0 z-50 flex justify-center items-start pt-10 px-4 pointer-events-none hidden transition-all duration-300">
    <div id="editActivityCard" class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl border border-gray-100 pointer-events-auto transform transition-all duration-300 scale-95 opacity-0 translate-y-4">
        
        <div class="flex justify-between items-center p-6 border-b bg-gray-50 rounded-t-2xl">
            <h3 class="text-xl font-bold text-gray-800">Kemaskini Aktiviti</h3>
            <button onclick="toggleModal('editActivityModal', 'editActivityCard')" class="text-gray-400 hover:text-red-500 text-2xl">&times;</button>
        </div>

        <div class="p-6 max-h-[80vh] overflow-y-auto">
            <form action="../backend/process_edit_activity.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="activityID" id="edit_activityID">
                
                <div class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Tajuk Aktiviti</label>
                        <input type="text" name="activityTitle" id="edit_activityTitle" required class="w-full px-4 py-2 bg-gray-50 border rounded-xl">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase">Tarikh Latihan</label>
                            <input type="date" name="trainDate" id="edit_trainDate" required class="w-full px-4 py-2 bg-gray-50 border rounded-xl">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase">Tarikh Persembahan</label>
                            <input type="date" name="showDate" id="edit_showDate" required class="w-full px-4 py-2 bg-gray-50 border rounded-xl">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase">Lokasi</label>
                            <input type="text" name="location" id="edit_location" required class="w-full px-4 py-2 bg-gray-50 border rounded-xl">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase">Status</label>
                            <select name="status" id="edit_status" class="w-full px-4 py-2 bg-gray-50 border rounded-xl">
                                <option value="open">Buka</option>
                                <option value="ended">Tamat</option>
                                <option value="full">Penuh</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Penerangan</label>
                        <textarea name="activityDesc" id="edit_activityDesc" rows="3" required class="w-full px-4 py-2 bg-gray-50 border rounded-xl"></textarea>
                    </div>

                    <div class="p-4 bg-blue-50 rounded-xl border border-blue-100">
                        <label class="block text-xs font-bold text-blue-700 mb-2 uppercase">Thumbnail (Opsyenal)</label>
                        <input type="file" name="activityThumbnail" accept="image/*" class="block w-full text-xs text-gray-500">
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-3 mt-8 pt-6 border-t">
                    <button type="submit" class="flex-1 py-3 bg-blue-600 text-white font-bold rounded-xl">KEMASKINI DATA</button>
                    <button type="button" onclick="toggleModal('editActivityModal', 'editActivityCard')" class="flex-1 py-3 bg-white text-gray-500 font-semibold border rounded-xl">BATAL</button>
                </div>
            </form>
        </div>
    </div>
</div>