<?php
session_start();
include_once '../config/connection.php';
include '../src/components/header.php';
include '../src/components/navbar.php';

// Pastikan hanya member/user boleh akses
if (!isset($_SESSION['userID'])) { 
    header("Location: ../public/login.php"); 
    exit(); 
}

$currentUserID = $_SESSION['userID'];

// Query untuk senarai aktiviti dan semak jika user dah join atau belum
$sql = "SELECT a.*, 
        (SELECT COUNT(*) FROM participations WHERE activityID = a.activityID AND userID = $currentUserID) as is_joined
        FROM activities a 
        ORDER BY a.trainDate DESC";
$result = $conn->query($sql);
?>

<div class="flex min-h-screen">
    <?php include '../src/components/sidebar_member.php'; ?>
    
    <div class="flex-1 min-h-screen">
        <main class="py-2 px-4 lg:p-8">
            
            <div class="mb-8 mt-10 lg:mt-0 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Sertai Aktiviti Kelab</h1>
                    <p class="text-gray-500 mt-1">Sertai aktiviti latihan dan persembahan i-KompIra.</p>
                </div>
                <?php if(isset($_GET['status'])): ?>
                    <div class="px-4 py-2 rounded-lg <?php echo $_GET['status'] == 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?> text-sm font-bold border border-current shadow-sm">
                        <?php echo $_GET['status'] == 'success' ? '✅ Berjaya dikemaskini' : '❌ Ralat berlaku'; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while($activity = $result->fetch_assoc()): ?>
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden group">
                    
                    <div class="relative">
                        <img src="../uploads/activities/<?php echo $activity['activityThumbnail']; ?>" 
                             class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-500"
                             alt="Thumbnail">
                        
                        <?php if($activity['is_joined'] > 0): ?>
                            <div class="absolute top-4 right-4 bg-green-500 text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-lg">
                                TELAH DISERTAI
                            </div>
                        <?php endif; ?>

                        <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur-sm text-[#D4A259] text-[10px] font-bold px-3 py-1 rounded-lg shadow-sm border border-amber-100">
                             <?php echo strtoupper($activity['status']); ?>
                        </div>
                    </div>

                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-1"><?php echo htmlspecialchars($activity['activityTitle']); ?></h3>
                        
                        <div class="space-y-2 mb-6">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2 text-[#D4A259]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <?php echo date('d F Y', strtotime($activity['trainDate'])); ?>
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2 text-[#D4A259]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <?php echo $activity['showDate']; ?>
                            </div>
                        </div>

                        <p class="text-gray-500 text-sm leading-relaxed mb-6 line-clamp-2 italic">
                            "<?php echo htmlspecialchars($activity['activityDesc']); ?>"
                        </p>
                        
                        <?php if($activity['is_joined'] > 0): ?>
                            <form action="../backend/process_cancel_participate.php" method="POST" onsubmit="return confirm('Adakah anda pasti ingin membatalkan penyertaan ini?');">
                                <input type="hidden" name="activityID" value="<?php echo $activity['activityID']; ?>">
                                <button type="submit" class="w-full py-3 bg-red-50 text-red-500 rounded-xl font-bold hover:bg-red-600 hover:text-white transition-all duration-200 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    BATAL SERTAI
                                </button>
                            </form>
                        <?php else: ?>
                            <form action="../backend/process_join_activity.php" method="POST">
                                <input type="hidden" name="activityID" value="<?php echo $activity['activityID']; ?>">
                                <button type="submit" class="w-full py-3 bg-[#D4A259] text-white rounded-xl font-bold hover:bg-[#b88a4a] hover:shadow-lg hover:shadow-amber-200 transition-all duration-200 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    SERTAI SEKARANG
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </main>
    </div>
</div>

<?php include '../src/components/footer.php'; ?>
