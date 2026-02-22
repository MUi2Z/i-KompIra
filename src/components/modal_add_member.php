<div id="addMemberModal" class="fixed inset-0 z-50 flex justify-center items-start pt-10 px-4 pointer-events-none hidden transition-all duration-300">
    
    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl border border-gray-100 pointer-events-auto transform transition-all duration-300 scale-95 opacity-0 translate-y-4" id="memberCard">
        
        <div class="flex justify-between items-center p-6 border-b bg-gray-50 rounded-t-2xl">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Tambah Ahli Baru</h3>
                <p class="text-xs text-gray-500 mt-1">Sila isi maklumat akaun dan profil ahli i-KompIra.</p>
            </div>
            <button onclick="toggleModal('addMemberModal', 'memberCard')" class="h-10 w-10 flex items-center justify-center rounded-full bg-white border shadow-sm text-gray-400 hover:text-red-500 hover:border-red-100 transition-all text-2xl">&times;</button>
        </div>

        <div class="p-6 max-h-[80vh] overflow-y-auto">
            <form action="../backend/process_add_member.php" method="POST">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2 flex items-center gap-2 mb-2">
                        <span class="h-1 w-8 bg-blue-600 rounded-full"></span>
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Maklumat Log Masuk</span>
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Email Rasmi</label>
                        <input type="email" name="email" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all" placeholder="contoh@email.com">
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Kata Laluan Sementara</label>
                        <input type="password" name="password" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all" placeholder="Min 6 aksara">
                    </div>

                    <div class="md:col-span-2 flex items-center gap-2 mb-2 mt-4">
                        <span class="h-1 w-8 bg-green-600 rounded-full"></span>
                        <span class="text-xs font-bold text-green-600 uppercase tracking-wider">Profil Ahli</span>
                    </div>

                    <div class="md:col-span-2 space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Nama Penuh</label>
                        <input type="text" name="fullName" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:bg-white outline-none transition-all">
                    </div>
                    
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">No. Kad Pengenalan</label>
                        <input type="text" name="NRIC" required pattern="\d{12}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:bg-white outline-none transition-all" placeholder="12 Digit tanpa -">
                    </div>
                    
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Kohort (Tahun)</label>
                        <input type="number" name="kohort" required value="<?php echo date('Y'); ?>" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:bg-white outline-none transition-all">
                    </div>

                    <div class="md:col-span-2 space-y-1">
                        <label class="text-xs font-bold text-gray-400 uppercase">Program Pengajian</label>
                        <input list="programmeOptions" name="programme" id="programmeInput" required 
                               placeholder="Taip untuk cari program..."
                               class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4A259] outline-none transition-all">
                        
                        <datalist id="programmeOptions">
                            <option value="1 SVM KPD">
                            <option value="1 SVM KMK">
                            <option value="1 SVM BAK">
                            <option value="1 SVM BPM">
                            <option value="1 SVM HSK">
                            <option value="1 SVM HBP">
                            <option value="2 SVM KPD">
                            <option value="2 SVM KMK">
                            <option value="2 SVM BAK">
                            <option value="2 SVM BPM">
                            <option value="2 SVM HSK">
                            <option value="2 SVM HBP">
                            <option value="1 DVM KPD">
                            <option value="1 DVM KMK">
                            <option value="1 DVM BAK">
                            <option value="1 DVM BPM">
                            <option value="1 DVM HSK">
                            <option value="1 DVM HBP">
                            <option value="2 DVM KPD">
                            <option value="2 DVM KMK">
                            <option value="2 DVM BAK">
                            <option value="2 DVM BPM">
                            <option value="2 DVM HSK">
                            <option value="2 DVM HBP">
                        </datalist>
                    </div>
                    
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Jenis Irama</label>
                        <select name="beatRoleType" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:bg-white outline-none transition-all appearance-none">
                            <option value="">-- Pilih Jenis Irama --</option>
                            <option value="Melalu">Melalu</option>
                            <option value="Menyilang">Menyilang</option>
                        </select>
                    </div>
                </div>

                <input type="hidden" name="status" value="active"> 
                
                <div class="flex flex-col md:flex-row gap-3 mt-8 pt-6 border-t">
                    <button type="submit" class="flex-1 py-3 bg-green-600 text-white font-bold rounded-xl shadow-lg shadow-green-200 hover:bg-green-700 hover:-translate-y-1 transition-all">
                        DAFTAR AHLI SEKARANG
                    </button>
                    <button type="button" onclick="toggleModal('addMemberModal', 'memberCard')" class="flex-1 py-3 bg-white text-gray-500 font-semibold rounded-xl border border-gray-200 hover:bg-gray-50 transition-all">
                        BATAL
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>