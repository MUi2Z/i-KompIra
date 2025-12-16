<?php
// add_module_modal.php
// Fail ini harus diletakkan di '../src/components/'
?>

<div id="addModuleModal" class="<?php echo $modal_outer; ?>">
    <div class="<?php echo $modal_inner; ?>">
        
        <div class="flex justify-between items-center pb-3 border-b">
            <h3 class="text-2xl font-semibold text-gray-800">Tambah Modul Pembelajaran Baru</h3>
            <button id="closeAddModuleModal" class="text-gray-500 hover:text-gray-800 text-2xl leading-none font-semibold">&times;</button>
        </div>

        <div class="mt-4">
            <form action="../backend/process_add_module.php" method="POST" enctype="multipart/form-data">
                
                <div class="mb-4">
                    <label for="moduleName" class="block text-sm font-medium text-gray-700">Nama Modul</label>
                    <input type="text" id="moduleName" name="moduleName" required 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>
                
                <div class="mb-4">
                    <label for="moduleDesc" class="block text-sm font-medium text-gray-700">Penerangan Modul</label>
                    <textarea id="moduleDesc" name="moduleDesc" rows="3" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"></textarea>
                </div>
                
                <div class="mb-4">
                    <label for="moduleThumbnail" class="block text-sm font-medium text-gray-700">Muat Naik Imej Thumbnail (Max 5MB)</label>
                    <input type="file" id="moduleThumbnail" name="moduleThumbnail" accept="image/*" required 
                           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                </div>

                <div class="mb-4">
                    <label for="moduleDocs" class="block text-sm font-medium text-gray-700">Muat Naik Dokumen Modul (PDF/DOCX)</label>
                    <input type="file" id="moduleDocs" name="moduleDocs" accept=".pdf,.doc,.docx" required 
                           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>


                <input type="hidden" name="userID" value="1"> 
                
                <div class="flex justify-end pt-4 border-t">
                    <button type="submit" 
                            class="py-2 px-4 bg-green-600 text-white font-semibold rounded-md shadow-md hover:bg-green-700 transition duration-200 mr-2">
                        SIMPAN MODUL
                    </button>
                    <button type="button" 
                            class="py-2 px-4 bg-gray-500 text-white font-semibold rounded-md shadow-md hover:bg-gray-600 transition duration-200"
                            onclick="document.getElementById('addModuleModal').classList.add('hidden')">
                        BATAL
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>