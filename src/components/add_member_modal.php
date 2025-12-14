<!-- modal shown after 'tambah' clicked -->
<div id="addMemberModal" class="<?php echo $modal_outer; ?>">
    <div class="<?php echo $modal_inner; ?>">
        
        <div class="flex justify-between items-center pb-3 border-b">
            <h3 class="text-2xl font-semibold text-gray-800">Tambah Ahli Baru</h3>
            <button id="closeAddMemberModal" class="text-gray-500 hover:text-gray-800 text-2xl leading-none font-semibold">&times;</button>
        </div>

        <div class="mt-4">
            <form action="../backend/process_add_member.php" method="POST">
                
                <div class="mb-4">
                    <label for="fullName" class="block text-sm font-medium text-gray-700">Nama Penuh</label>
                    <input type="text" id="fullName" name="fullName" required 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>
                
                <div class="mb-4">
                    <label for="nric" class="block text-sm font-medium text-gray-700">No. Kad Pengenalan</label>
                    <input type="text" id="nric" name="NRIC" required pattern="\d{12}" title="Sila masukkan 12 digit tanpa sempang"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>
                
                <div class="mb-4">
                    <label for="programme" class="block text-sm font-medium text-gray-700">Program Pengajian</label>
                    <select id="programme" name="programme" required 
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        <option value="">-- Sila Pilih Program --</option>
                        <option value="Diploma">Diploma</option>
                        <option value="Sarjana Muda">Sarjana Muda</option>
                        </select>
                </div>
                
                <div class="mb-4">
                    <label for="beatRoleType" class="block text-sm font-medium text-gray-700">Jenis Irama</label>
                    <select id="beatRoleType" name="beatRoleType" required 
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        <option value="">-- Sila Pilih Jenis Irama --</option>
                        <option value="Melalu">Melalu</option>
                        <option value="Menyilang">Menyilang</option>
                        </select>
                </div>

                <div class="mb-4">
                    <label for="kohort" class="block text-sm font-medium text-gray-700">Kohort</label>
                    <input type="number" id="kohort" name="kohort" required min="2000" max="<?php echo date('Y'); ?>"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>

                <input type="hidden" name="status" value="active"> 
                <input type="hidden" name="userID" value="1"> 
                
                <div class="flex justify-end pt-4 border-t">
                    <button type="submit" 
                            class="py-2 px-4 bg-green-600 text-white font-semibold rounded-md shadow-md hover:bg-green-700 transition duration-200 mr-2">
                        SIMPAN
                    </button>
                    <button type="button" id="cancelAddMemberModal"
                            class="py-2 px-4 bg-gray-500 text-white font-semibold rounded-md shadow-md hover:bg-gray-600 transition duration-200"
                            onclick="document.getElementById('addMemberModal').classList.add('hidden')">
                        BATAL
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>