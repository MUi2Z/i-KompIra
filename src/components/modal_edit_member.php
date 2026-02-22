<div id="editMemberModal" class="fixed inset-0 z-50 flex justify-center items-start pt-10 px-4 pointer-events-none hidden transition-all duration-300 bg-black/20 backdrop-blur-sm">
    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl border border-gray-100 pointer-events-auto transform transition-all duration-300 scale-95 opacity-0 translate-y-4" id="editMemberCard">
        
        <div class="flex justify-between items-center p-6 border-b bg-gray-50 rounded-t-2xl">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Kemaskini Profil</h3>
                <p class="text-xs text-gray-500 mt-1">Pastikan maklumat anda tepat sebelum menghantar.</p>
            </div>
            <button onclick="toggleModal('editMemberModal', 'editMemberCard')" class="h-10 w-10 flex items-center justify-center rounded-full bg-white border shadow-sm text-gray-400 hover:text-red-500 transition-all text-2xl">&times;</button>
        </div>

        <div class="p-6 max-h-[80vh] overflow-y-auto">
            <form action="../backend/process_edit_member.php" method="POST">
                <input type="hidden" name="profileID" id="edit_profileID">
                <input type="hidden" name="userID" id="edit_userID">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2 flex items-center gap-2 mb-2">
                        <span class="h-1 w-8 bg-[#D4A259] rounded-full"></span>
                        <span class="text-xs font-bold text-[#D4A259] uppercase tracking-wider">Akaun & Akses</span>
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Email</label>
                        <input type="email" name="email" id="edit_email" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4A259] outline-none">
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Kata Laluan Baru</label>
                        <input type="password" name="password" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4A259] outline-none" placeholder="Kosongkan jika tiada tukar">
                    </div>

                    <div class="md:col-span-2 flex items-center gap-2 mb-2 mt-4">
                        <span class="h-1 w-8 bg-[#D4A259] rounded-full"></span>
                        <span class="text-xs font-bold text-[#D4A259] uppercase tracking-wider">Profil Peribadi</span>
                    </div>

                    <div class="md:col-span-2 space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Nama Penuh</label>
                        <input type="text" name="fullName" id="edit_fullName" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4A259] outline-none">
                    </div>
                    
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">No. Kad Pengenalan</label>
                        <input type="text" name="NRIC" id="edit_NRIC" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4A259] outline-none">
                    </div>
                    
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Kohort</label>
                        <input type="number" name="kohort" id="edit_kohort" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4A259] outline-none">
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Program Pengajian</label>
                        <input list="programmeOptionsEdit" name="programme" id="edit_programme" required 
                               placeholder="Cari program..."
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4A259] outline-none">
                        
                        <datalist id="programmeOptionsEdit">
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
                        <select name="beatRoleType" id="edit_beatRoleType" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl outline-none">
                            <option value="Melalu">Melalu</option>
                            <option value="Menyilang">Menyilang</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex flex-col md:flex-row gap-3 mt-8 pt-6 border-t">
                    <button type="submit" class="flex-1 py-3 bg-[#D4A259] text-white font-bold rounded-xl hover:bg-[#b88a4a] transition-all">SIMPAN PERUBAHAN</button>
                    <button type="button" onclick="toggleModal('editMemberModal', 'editMemberCard')" class="flex-1 py-3 bg-white text-gray-500 font-semibold rounded-xl border border-gray-200">BATAL</button>
                </div>
            </form>
        </div>
    </div>
</div>