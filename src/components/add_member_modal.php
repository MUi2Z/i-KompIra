<div id="addMemberModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-3/5 lg:w-2/5 shadow-lg rounded-md bg-white">
        
        <div class="flex justify-between items-center pb-3 border-b">
            <h3 class="text-2xl font-semibold text-gray-800">Tambah Ahli Baru</h3>
            <button id="closeAddMemberModal" class="text-gray-500 hover:text-gray-800 text-2xl leading-none font-semibold">&times;</button>
        </div>

        <div class="mt-4">
            <form action="../backend/process_add_member.php" method="POST">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2 border-b pb-2 mb-2">
                        <span class="text-sm font-bold text-blue-600 uppercase">Maklumat Log Masuk</span>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Rasmi</label>
                        <input type="email" id="email" name="email" required 
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="contoh@email.com">
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Kata Laluan Sementara</label>
                        <input type="password" id="password" name="password" required 
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="Min 6 aksara">
                    </div>

                    <div class="md:col-span-2 border-b pb-2 mb-2 mt-2">
                        <span class="text-sm font-bold text-blue-600 uppercase">Profil Ahli</span>
                    </div>

                    <div class="mb-4 md:col-span-2">
                        <label for="fullName" class="block text-sm font-medium text-gray-700">Nama Penuh</label>
                        <input type="text" id="fullName" name="fullName" required 
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>
                    
                    <div class="mb-4">
                        <label for="nric" class="block text-sm font-medium text-gray-700">No. Kad Pengenalan</label>
                        <input type="text" id="nric" name="NRIC" required pattern="\d{12}" title="Sila masukkan 12 digit tanpa sempang"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="Contoh: 010203040506">
                    </div>
                    
                    <div class="mb-4">
                        <label for="kohort" class="block text-sm font-medium text-gray-700">Kohort (Tahun)</label>
                        <input type="number" id="kohort" name="kohort" required min="2000" max="<?php echo date('Y'); ?>" value="<?php echo date('Y'); ?>"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>

                    <div class="mb-4">
                        <label for="programme" class="block text-sm font-medium text-gray-700">Program Pengajian</label>
                        <select id="programme" name="programme" required 
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            <option value="">-- Pilih Program --</option>
                            <option value="Diploma">Diploma</option>
                            <option value="Sarjana Muda">Sarjana Muda</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="beatRoleType" class="block text-sm font-medium text-gray-700">Jenis Irama</label>
                        <select id="beatRoleType" name="beatRoleType" required 
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            <option value="">-- Pilih Jenis Irama --</option>
                            <option value="Melalu">Melalu</option>
                            <option value="Menyilang">Menyilang</option>
                        </select>
                    </div>
                </div>

                <input type="hidden" name="status" value="active"> 
                
                <div class="flex justify-end pt-4 border-t mt-4">
                    <button type="submit" 
                            class="py-2 px-6 bg-green-600 text-white font-semibold rounded-md shadow-md hover:bg-green-700 transition duration-200 mr-2">
                        DAFTAR AHLI
                    </button>
                    <button type="button" 
                            class="py-2 px-6 bg-gray-500 text-white font-semibold rounded-md shadow-md hover:bg-gray-600 transition duration-200"
                            onclick="document.getElementById('addMemberModal').classList.add('hidden')">
                        BATAL
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>