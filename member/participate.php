<?php include '../src/components/header.php'; ?>
<?php include '../src/components/navbar.php'; ?>
<?php
include '../config/connection.php';
session_start();

// Pastikan hanya member/user boleh akses
if (!isset($_SESSION['userID'])) { header("Location: ../public/login.php"); exit(); }

$currentUserID = $_SESSION['userID'];

// Query untuk senarai aktiviti dan semak jika user dah join atau belum
$sql = "SELECT a.*, 
        (SELECT COUNT(*) FROM activity_participations WHERE activityID = a.activityID AND userID = $currentUserID) as is_joined
        FROM activities a";
$result = $conn->query($sql);
?>

<?php include '../src/components/header.php'; ?>
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-8">Sertai Aktiviti Kelab</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php while($activity = $result->fetch_assoc()): ?>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <img src="<?php echo $activity['activityThumbnail']; ?>" class="w-full h-48 object-cover">
            <div class="p-5">
                <h3 class="text-xl font-bold mb-2"><?php echo $activity['activityTittle']; ?></h3>
                <p class="text-gray-600 text-sm mb-4"><?php echo substr($activity['activityDesc'], 0, 100); ?>...</p>
                
                <?php if($activity['is_joined'] > 0): ?>
                    <button disabled class="w-full py-2 bg-gray-400 text-white rounded-lg cursor-not-allowed italic">
                        Anda Telah Menyertai
                    </button>
                <?php else: ?>
                    <form action="../backend/process_join_activity.php" method="POST">
                        <input type="hidden" name="activityID" value="<?php echo $activity['activityID']; ?>">
                        <button type="submit" class="w-full py-2 bg-[#D4A259] text-white rounded-lg hover:bg-[#b88a4a] transition font-bold">
                            SERTAI SEKARANG
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>