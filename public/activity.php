<?php include '../src/components/header.php'; ?>
<?php include '../src/components/navbar.php'; ?>
<?php
// Ambil Aktiviti yang bukan 'draft' (ongoing, ended, cancelled)
$activitiesSql = "SELECT * FROM activities WHERE status != 'draft' ORDER BY trainDate DESC";
$activitiesResult = $conn->query($activitiesSql);

// Ambil Modul Pembelajaran dari table modules
$modulesSql = "SELECT * FROM modules ORDER BY createdAt DESC";
$modulesResult = $conn->query($modulesSql);
?>

<main class="container mx-auto py-10 px-4">
    
    <section class="mb-16">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-l-4 border-[#D4A259] pl-4">Video Tutorial Utama</h2>
        <div class="aspect-video w-full max-w-4xl mx-auto rounded-2xl overflow-hidden shadow-2xl border-4 border-[#E7D8B8]">
            <iframe class="w-full h-full" src="../src/vid/komp 1.mp4" title="Tutorial Kompira" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>           
        <div class="mt-auto pt-4 border-t border-gray-50 flex items-center text-center justify-center">
            <button onclick="window.location='../public/beatPlayer.php'" type="submit" class="bg-orange-700/80 hover:bg-orange-700 text-white font-extrabold py-3 px-10 rounded-full shadow-xl hover:shadow-2xl transition duration-300 transform hover:scale-105 uppercase tracking-wider">
                KE HALAMAN INTERAKTIF
            </button>
        </div>
    </section>

    <section class="mb-16">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Kalendar Aktiviti</h2>
                <p class="text-gray-500 text-sm">Sertai latihan atau lihat rekod aktiviti kami.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if ($activitiesResult && $activitiesResult->num_rows > 0): ?>
                <?php while($activity = $activitiesResult->fetch_assoc()): ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-md transition">
                        <img src="../uploads/activities/<?php echo $activity['activityThumbnail']; ?>" class="h-44 w-full object-cover" alt="Thumbnail">
                        <div class="p-5 flex-1 flex flex-col">
                            <div class="flex justify-between mb-2">
                                <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Aktiviti</span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold <?php echo ($activity['status'] == 'ongoing') ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600'; ?>">
                                    <?php echo strtoupper($activity['status']); ?>
                                </span>
                            </div>
                            <h3 class="font-bold text-gray-800 mb-2"><?php echo htmlspecialchars($activity['activityTitle']); ?></h3>
                            <p class="text-gray-600 text-xs line-clamp-2 mb-4"><?php echo htmlspecialchars($activity['activityDesc']); ?></p>
                            
                            <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between">
                                <span class="text-xs text-gray-500 font-medium"><?php echo date('d M Y', strtotime($activity['trainDate'])); ?></span>
                                <a href="activity_detail.php?id=<?php echo $activity['activityID']; ?>" class="text-xs font-bold text-blue-600 hover:text-blue-800">LIHAT DETAIL →</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="col-span-full text-center text-gray-400 py-10 italic">Tiada aktiviti ditemui.</p>
            <?php endif; ?>
        </div>
    </section>

    <hr class="border-gray-100 mb-16">

    <section>
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Modul & Dokumen</h2>
            <p class="text-gray-500 text-sm">Muat turun rujukan pembelajaran kompang di sini.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php if ($modulesResult && $modulesResult->num_rows > 0): ?>
                <?php while($module = $modulesResult->fetch_assoc()): ?>
                    <div class="flex bg-[#F9F6F0] rounded-xl p-4 border border-[#E7D8B8] items-center space-x-4 hover:bg-[#F3EDDF] transition">
                        <div class="flex-shrink-0 w-16 h-16 bg-white rounded-lg flex items-center justify-center shadow-sm">
                            <img src="../uploads/modules/<?php echo $module['moduleThumbnail']; ?>" class="w-12 h-12 object-contain" alt="PDF">
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-800 text-sm"><?php echo htmlspecialchars($module['moduleName']); ?></h4>
                            <p class="text-gray-500 text-[11px] line-clamp-1"><?php echo htmlspecialchars($module['moduleDesc']); ?></p>
                        </div>
                        <a href="../uploads/docs/<?php echo $module['moduleDocs']; ?>" target="_blank" class="px-4 py-2 bg-white text-[#D4A259] text-xs font-bold rounded-lg border border-[#D4A259] hover:bg-[#D4A259] hover:text-white transition-all">
                            DOWNLOAD
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="col-span-full text-gray-400 text-sm italic">Tiada modul tersedia buat masa ini.</p>
            <?php endif; ?>
        </div>
    </section>

</main>

<?php include '../src/components/footer.php'; ?>