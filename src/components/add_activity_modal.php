
<div id="addActivityModal" class="<?php echo $modal_outer; ?>">
    <div class="<?php echo $modal_inner; ?>">
        
        <div class="flex justify-between items-center pb-3 border-b">
            <h3 class="text-2xl font-semibold text-gray-800">Tambah Aktiviti Baru</h3>
            <button id="closeAddActivityModal" class="text-gray-500 hover:text-gray-800 text-2xl leading-none font-semibold">&times;</button>
        </div>

        <div class="mt-4">
            <form action="../backend/process_add_activity.php" method="POST" enctype="multipart/form-data">
                
                <div class="mb-4">
                    <label for="activityTittle" class="block text-sm font-medium text-gray-700">Tajuk Aktiviti</label>
                    <input type="text" id="activityTittle" name="activityTittle" required 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>
                
                <div class="mb-4">
                    <label for="activityDesc" class="block text-sm font-medium text-gray-700">Penerangan Aktiviti</label>
                    <textarea id="activityDesc" name="activityDesc" rows="4" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"></textarea>
                </div>
                
                <div class="mb-4">
                    <label for="activityThumbnail" class="block text-sm font-medium text-gray-700">Muat Naik Imej Thumbnail</label>
                    <input type="file" id="activityThumbnail" name="activityThumbnail" accept="image/*" required 
                           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                </div>

                <input type="hidden" name="userID" value="1"> 
                
                <div class="flex justify-end pt-4 border-t">
                    <button type="submit" 
                            class="py-2 px-4 bg-green-600 text-white font-semibold rounded-md shadow-md hover:bg-green-700 transition duration-200 mr-2">
                        SIMPAN AKTIVITI
                    </button>
                    <button type="button" 
                            class="py-2 px-4 bg-gray-500 text-white font-semibold rounded-md shadow-md hover:bg-gray-600 transition duration-200"
                            onclick="document.getElementById('addActivityModal').classList.add('hidden')">
                        BATAL
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>