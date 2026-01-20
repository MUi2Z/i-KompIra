<?php include '../src/components/header.php'; ?>
<?php include '../src/components/navbar.php'; ?>

<?php
// Kandungan untuk kad di halaman utama
// Ambil 5 aktiviti terbaru untuk Carousel (kecuali gambar default)
$carouselSql = "SELECT activityTitle, activityThumbnail 
                FROM activities 
                WHERE activityThumbnail != 'default_thumbnail.png' 
                ORDER BY createdAt DESC LIMIT 5";
$carouselResult = $conn->query($carouselSql);

// Ambil semua aktiviti aktif untuk Activity Cards
$activitiesSql = "SELECT * FROM activities 
                  WHERE status = 'ongoing' 
                  ORDER BY trainDate ASC";
$activitiesResult = $conn->query($activitiesSql);
?>

    <main class="container mx-auto py-12 px-4 md:px-8 lg:px-12">

        <!-- Slideshow Carousel Section -->
        <div id="hero" class="relative border-8 rounded-2xl border-[#E7D8B8]" data-carousel="slide">
            <!-- Carousel wrapper: Changed w-4/6 to w-full for better layout -->
            <div id="activityCarousel" class="relative w-full overflow-hidden rounded-2xl shadow-lg h-[400px]">
                <?php if ($carouselResult && $carouselResult->num_rows > 0): ?>
                    <?php $first = true; foreach ($carouselResult as $row): ?>
                        <div class="carousel-item <?php echo $first ? 'active' : 'hidden'; ?> duration-700 ease-in-out">
                            <img src="../uploads/activities/<?php echo $row['activityThumbnail']; ?>" 
                                 class="absolute block w-full h-full object-cover" 
                                 alt="<?php echo htmlspecialchars($row['activityTitle']); ?>">
                            <div class="absolute bottom-0 bg-black/50 w-full p-5 text-white">
                                <h2 class="text-xl font-bold"><?php echo htmlspecialchars($row['activityTitle']); ?></h2>
                            </div>
                        </div>
                    <?php $first = false; endforeach; ?>
                <?php else: ?>
                    <img src="../assets/img/hero-bg.jpg" class="w-full h-full object-cover" alt="Welcome">
                <?php endif; ?>
            </div>
        <section class="relative bg-white/50 p-6 rounded-xl shadow-xl">
                <!-- Slider controls -->
                <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full group-hover:bg-amber-200/80 group-focus:ring-white group-focus:outline-none">
                        <svg class="w-4 h-4 text-orange-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                        </svg>
                        <span class="sr-only">Previous</span>
                    </span>
                </button>
                <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full group-hover:bg-yellow-200/80 group-focus:ring-white group-focus:outline-none">
                        <svg class="w-4 h-4 text-orange-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="sr-only">Next</span>
                    </span>
                </button>
            </div>
        </section>

        <!-- Activity Cards Section -->
        <section class="mt-10">            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">
                <?php while($activity = $activitiesResult->fetch_assoc()): ?>
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-xl transition">
                    <img class="h-48 w-full object-cover" 
                         src="../uploads/activities/<?php echo $activity['activityThumbnail']; ?>" 
                         alt="Activity Image">

                    <div class="p-5">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-bold text-gray-800"><?php echo htmlspecialchars($activity['activityTitle']); ?></h3>
                            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full uppercase">
                                <?php echo $activity['status']; ?>
                            </span>
                        </div>

                        <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?php echo htmlspecialchars($activity['activityDesc']); ?></p>

                        <div class="space-y-2 mb-5">
                            <div class="flex items-center text-xs text-gray-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Latihan: <?php echo date('d M Y', strtotime($activity['trainDate'])); ?>
                            </div>
                            <div class="flex items-center text-xs text-gray-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Lokasi: <?php echo htmlspecialchars($activity['location'] ?? 'Akan Dimaklumkan'); ?>
                            </div>
                        </div>
                
                        <form action="../backend/process_join_activity.php" method="POST">
                            <input type="hidden" name="activityID" value="<?php echo $activity['activityID']; ?>">
                            <button type="submit" class="w-full py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition">
                                SERTAI SEKARANG
                            </button>
                        </form>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </section>

    </main>

<?php include '../src/components/footer.php'; ?>