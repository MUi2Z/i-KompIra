<?php 
session_start();
include_once '../config/connection.php';
include '../src/components/header.php'; 
include '../src/components/navbar.php'; 

// --- DATA FETCHING ---
// 1. Carousel (5 Aktiviti terbaru)
$carouselSql = "SELECT activityTitle, activityThumbnail FROM activities WHERE activityThumbnail != 'default_thumbnail.png' ORDER BY createdAt DESC LIMIT 5";
$carouselResult = $conn->query($carouselSql);

// 2. Aktiviti (Semua status kecuali draft)
$activitiesSql = "SELECT * FROM activities WHERE status != 'draft' ORDER BY trainDate DESC";
$activitiesResult = $conn->query($activitiesSql);

// 3. Modul
$modulesSql = "SELECT * FROM modules ORDER BY createdAt DESC";
$modulesResult = $conn->query($modulesSql);
?>

<main class="space-y-20 pb-20">
    
    <section id="utama" class="container mx-auto pt-8 px-4">
        <div id="hero" class="relative border-4 md:border-8 rounded-3xl border-[#E7D8B8] overflow-hidden group shadow-xl" data-carousel="slide">
            <div class="relative h-48 md:h-[350px] overflow-hidden">
                <?php if ($carouselResult && $carouselResult->num_rows > 0): $count = 0; ?>
                    <?php while($row = $carouselResult->fetch_assoc()): ?>
                        <div class="<?= ($count == 0) ? 'block' : 'hidden'; ?> duration-700 ease-in-out carousel-item" data-carousel-item="<?= ($count == 0) ? 'active' : ''; ?>">
                            <img src="../uploads/activities/<?= $row['activityThumbnail']; ?>" class="absolute block w-full h-full object-cover" alt="Activity">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent flex items-end p-6">
                                <h2 class="text-lg md:text-2xl font-black text-white"><?= htmlspecialchars($row['activityTitle']); ?></h2>
                            </div>
                        </div>
                    <?php $count++; endwhile; ?>
                <?php else: ?>
                    <div class="block duration-700 ease-in-out carousel-item" data-carousel-item="active">
                        <img src="../src/img/hero-bg.jpg" class="absolute block w-full h-full object-cover" alt="Welcome">
                    </div>
                <?php endif; ?>
            </div>
            <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 group focus:outline-none" data-carousel-prev>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/20 group-hover:bg-amber-500/50 text-white transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                </span>
            </button>
            <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 group focus:outline-none" data-carousel-next>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/20 group-hover:bg-amber-500/50 text-white transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                </span>
            </button>
        </div>
    </section>

    <section id="info" class="container mx-auto px-4">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex flex-col md:flex-row">
                <div class="md:w-1/2 relative min-h-[350px]">
                    <img src="../src/img/OriginTeam.png" class="absolute inset-0 w-full h-full object-cover" alt="Team">
                </div>
                <div class="md:w-1/2 p-8 md:p-12 self-center">
                    <h2 class="text-[#D4A259] font-black uppercase tracking-widest text-sm mb-3">Mengenai Kami</h2>
                    <h1 class="text-3xl font-extrabold text-gray-900 leading-tight mb-6">"Meraikan Warisan, Menyatu Dalam Irama"</h1>
                    <p class="text-gray-600 leading-relaxed mb-8">Platform digital rasmi untuk aktiviti, rujukan, dan pemeliharaan seni kompang institusi kami. Gabungan warisan seni tradisional dengan sentuhan teknologi moden.</p>
                    <div class="flex gap-6">
                        <div class="flex items-center gap-3">
                            <div class="bg-amber-100 p-2 rounded-lg text-[#D4A259]"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>
                            <span class="font-bold text-gray-800">Budaya</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="bg-amber-100 p-2 rounded-lg text-[#D4A259]"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path></svg></div>
                            <span class="font-bold text-gray-800">Latihan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="tutorial" class="bg-[#F9F6F0] py-16 px-4">
        <div class="container mx-auto text-center max-w-4xl">
            <h2 class="text-3xl font-black text-gray-800 mb-8">Pembelajaran Interaktif</h2>
            <div class="aspect-video rounded-3xl overflow-hidden shadow-2xl border-8 border-white mb-8 bg-black">
                <video class="w-full h-full" controls preload="metadata">
                    <source src="../src/vid/tutorial_test.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <a href="../practice/index.php" class="inline-block px-10 py-4 bg-orange-700 text-white font-black rounded-full shadow-xl hover:scale-105 transition-transform uppercase tracking-wider">
                Ke Halaman Interaktif
            </a>
        </div>
    </section>

    <section id="aktiviti" class="container mx-auto px-4">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-black text-gray-800">Kalendar Aktiviti</h2>
                <p class="text-gray-500">Sertai latihan atau lihat rekod aktiviti kami.</p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php while($activity = $activitiesResult->fetch_assoc()): ?>
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300">
                    <div class="relative">
                        <img src="../uploads/activities/<?= $activity['activityThumbnail']; ?>" class="h-48 w-full object-cover">
                        <span class="absolute top-4 right-4 px-3 py-1 rounded-full text-[10px] font-black uppercase bg-white/90 <?= ($activity['status'] == 'ongoing') ? 'text-green-600' : 'text-gray-500'; ?>">
                            <?= $activity['status']; ?>
                        </span>
                    </div>
                    <div class="p-6">
                        <h3 class="font-black text-xl text-gray-800 mb-2 leading-tight"><?= htmlspecialchars($activity['activityTitle']); ?></h3>
                        <p class="text-gray-500 text-sm line-clamp-2 mb-6"><?= htmlspecialchars($activity['activityDesc']); ?></p>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                            <span class="text-xs font-bold text-[#D4A259] uppercase tracking-tighter italic"><?= date('d M Y', strtotime($activity['trainDate'])); ?></span>
                            <?php if($activity['status'] == 'ongoing'): ?>
                                <form action="../backend/process_join_activity.php" method="POST">
                                    <input type="hidden" name="activityID" value="<?= $activity['activityID']; ?>">
                                    <button type="submit" class="text-xs font-black px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition">SERTAI</button>
                                </form>
                            <?php else: ?>
                                <a href="activity_detail.php?id=<?= $activity['activityID']; ?>" class="text-xs font-bold text-blue-600">DETAIL →</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <section class="container mx-auto px-4">
        <div class="bg-white p-8 md:p-12 rounded-3xl border border-gray-100 shadow-sm">
            <h2 class="text-2xl font-black text-gray-800 mb-8">Pusat Rujukan & Modul</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php while($module = $modulesResult->fetch_assoc()): ?>
                    <div class="flex items-center p-4 bg-gray-50 rounded-2xl border border-gray-100 group hover:bg-[#D4A259]/5 transition">
                        <div class="w-16 h-16 bg-white rounded-xl overflow-hidden shadow-sm flex-shrink-0">
                            <img src="<?= !empty($module['moduleThumbnail']) ? '../uploads/modules/thumbs/' . $module['moduleThumbnail'] : '../src/img/default_module.png'; ?>" class="w-full h-full object-cover">
                        </div>
                        <div class="ml-4 flex-1">
                            <h4 class="font-bold text-gray-800 leading-tight"><?= htmlspecialchars($module['moduleName']); ?></h4>
                            <p class="text-xs text-gray-500">Dokumen Rujukan Ahli</p>
                        </div>
                        <a href="../uploads/modules/docs/<?= $module['moduleDocs']; ?>" target="_blank" class="px-4 py-2 bg-white text-[#D4A259] text-xs font-black rounded-xl border border-[#D4A259] hover:bg-[#D4A259] hover:text-white transition-all">DOWNLOAD</a>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

</main>

<?php include '../src/components/footer.php'; ?>