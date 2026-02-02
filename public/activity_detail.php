<?php 
include '../src/components/header.php'; 
include '../src/components/navbar.php'; 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Ambil ID aktiviti dari URL
$activityID = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($activityID <= 0) {
    header("Location: index.php");
    exit();
}

// 2. Dapatkan data aktiviti dari database
$stmt = $conn->prepare("SELECT * FROM activities WHERE activityID = ?");
$stmt->bind_param("i", $activityID);
$stmt->execute();
$result = $stmt->get_result();
$activity = $result->fetch_assoc();

// Jika aktiviti tidak dijumpai
if (!$activity) {
    die("Ralat: Aktiviti tidak ditemui.");
}
?>

<main class="container mx-auto py-8 px-4 sm:px-6">

    <section class="text-center mb-10">
        <h1 class="text-3xl font-bold tracking-tight text-gray-800 uppercase">MAKLUMAT AKTIVITI</h1>
        <p class="text-gray-500 mt-2">Perincian bagi <?php echo htmlspecialchars($activity['activityTitle']); ?></p>
    </section>

    <div class="max-w-5xl mx-auto rounded-xl shadow-2xl overflow-hidden bg-amber-50/90 border border-amber-100">

        <section class="bg-white/50 p-8 pt-10 border-b border-amber-100">
            <div class="w-48 h-48 bg-gray-200 rounded-full mx-auto flex items-center justify-center border-6 border-white shadow-lg ring-4 ring-white/80 overflow-hidden">
                <?php if (!empty($activity['activityThumbnail']) && $activity['activityThumbnail'] != 'default_thumbnail.png'): ?>
                    <img src="../uploads/activities/<?php echo $activity['activityThumbnail']; ?>" alt="Thumbnail" class="w-full h-full object-cover">
                <?php else: ?>
                    <svg class="w-24 h-24 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9 5a1 1 0 112 0v2.586l1.707-1.707a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 111.414-1.414L9 7.586V5z" clip-rule="evenodd" />
                    </svg>
                <?php endif; ?>
            </div>
            <p class="text-center mt-4 text-xl font-semibold text-gray-700"><?php echo htmlspecialchars($activity['activityTitle']); ?></p>
        </section>

        <section class="p-8 md:p-12 space-y-8">
            
            <div class="flex flex-col lg:flex-row lg:space-x-12">
                
                <div class="text-lg font-medium space-y-3 mb-6 lg:mb-0 lg:w-1/3 p-4 border-l-4 border-amber-400 bg-amber-100/50 rounded-lg">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 border-b border-amber-200 pb-2">Butiran Utama</h2>
                    <p><span class="font-bold text-gray-700">Nama Aktiviti:</span> <?php echo htmlspecialchars($activity['activityTitle']); ?></p>
                    <p><span class="font-bold text-gray-700">Tarikh Latihan:</span> <?php echo date('d M Y', strtotime($activity['trainDate'])); ?></p>
                    <p><span class="font-bold text-gray-700">Status:</span> 
                        <span class="px-2 py-1 rounded-md text-sm <?php echo ($activity['status'] == 'ongoing') ? 'bg-green-200 text-green-800' : 'bg-gray-200 text-gray-800'; ?>">
                            <?php echo strtoupper($activity['status']); ?>
                        </span>
                    </p>
                    <p><span class="font-bold text-gray-700">Tempat:</span> <?php echo htmlspecialchars($activity['location'] ?? 'Akan Dimaklumkan'); ?></p>
                    <p><span class="font-bold text-gray-700">Peserta Maksimum:</span> <?php echo $activity['maxParticipants'] > 0 ? $activity['maxParticipants'] . " Orang" : "Tiada Had"; ?></p>
                </div>
                
                <div class="text-lg lg:w-2/3 p-4">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 border-b border-amber-200 pb-2">Keterangan Aktiviti</h2>
                    <p class="leading-relaxed text-gray-600">
                        <?php echo nl2br(htmlspecialchars($activity['activityDesc'])); ?>
                    </p>
                </div>
            </div>
            
            <div class="flex justify-center pt-6">
                <form action="../backend/process_join_activity.php" method="POST">
                    <input type="hidden" name="activityID" value="<?php echo $activity['activityID']; ?>">
                    <button type="submit" class="bg-green-700/80 hover:bg-green-700 text-white font-extrabold py-3 px-10 rounded-full shadow-xl hover:shadow-2xl transition duration-300 transform hover:scale-105 uppercase tracking-wider">
                        SERTAI AKTIVITI SEKARANG
                    </button>
                </form>
            </div>
        </section>

    </div>

</main>

<?php include '../src/components/footer.php'; ?>