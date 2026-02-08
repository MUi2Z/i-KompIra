<div id="addActivityModal" class="fixed inset-0 z-50 flex justify-center items-start pt-10 px-4 pointer-events-none hidden transition-all duration-300">
    <div id="activityCard" class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl border border-gray-100 pointer-events-auto transform transition-all duration-300 scale-95 opacity-0 translate-y-4">
        
        <div class="flex justify-between items-center p-6 border-b bg-gray-50 rounded-t-2xl">
            <h3 class="text-xl font-bold text-gray-800">Tambah Aktiviti Baru</h3>
            <button onclick="toggleModal('addActivityModal', 'activityCard')" class="text-gray-400 hover:text-red-500 text-2xl">&times;</button>
        </div>

        <div class="p-6 max-h-[80vh] overflow-y-auto">
            <form action="../backend/process_add_activity.php" method="POST" enctype="multipart/form-data">
                <div class="space-y-5">
                    <input type="hidden" name="userID" value="<?php echo $_SESSION['userID']; ?>">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Tajuk Aktiviti</label>
                        <input type="text" name="activityTitle" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 outline-none transition-all">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Penerangan</label>
                        <textarea name="activityDesc" rows="3" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 outline-none transition-all"></textarea>
                    </div>
                    <div class="p-4 bg-green-50 rounded-xl border border-green-100">
                        <label class="block text-xs font-bold text-green-700 mb-2 uppercase">Thumbnail</label>
                        <input type="file" name="activityThumbnail" accept="image/*" required class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-green-600 file:text-white">
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-3 mt-8 pt-6 border-t">
                    <button type="submit" class="flex-1 py-3 bg-green-600 text-white font-bold rounded-xl shadow-lg">SIMPAN AKTIVITI</button>
                    <button type="button" onclick="toggleModal('addActivityModal', 'activityCard')" class="flex-1 py-3 bg-white text-gray-500 font-semibold border rounded-xl">BATAL</button>
                </div>
            </form>
        </div>
    </div>
</div>