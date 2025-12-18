<?php include '../src/components/header.php'; ?>
<?php include '../src/components/navbar.php'; ?>

    <main class="container mx-auto py-12 px-4 md:px-8 lg:px-12">

        <!-- Carousel Section - Kept as is, positioned correctly within the main container -->
        <section class="relative bg-white/50 p-6 rounded-xl shadow-xl">
            <div id="hero" class="relative border-8 rounded-2xl border-[#E7D8B8]" data-carousel="slide">
                <!-- Carousel wrapper: Changed w-4/6 to w-full for better layout -->
                <div class="relative h-56 overflow-hidden rounded-xl md:h-96 w-full">
                    <!-- Item 1 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="../src/img/komp_win2.jpeg" class="absolute block w-full h-full object-cover -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="Kompang traditional music performance">
                    </div>
                    <!-- Item 2 -->
                    <div class="duration-700 ease-in-out" data-carousel-item="active">
                        <img src="../src/img/komp_team1.jpeg" class="absolute block w-full h-full object-cover -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="Kompang drummers performing">
                    </div>
                    <!-- Item 3 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="../src/img/komp_johan1.jpeg" class="absolute block w-full h-full object-cover -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="Kompang traditional music performance">
                    </div>
                    <!-- Item 4 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                        <img src="https://i.ytimg.com/vi/5Tu9mEd96rE/maxresdefault.jpg" class="absolute block w-full h-full object-cover -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="Kompang drummers performing">
                    </div>
                </div>
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

        <!-- Cards Section: Modified to use <table> for 2x2 arrangement -->
        <section class="mt-10">
            <?php
            // Sample data for cards
            $cards = [
                [
                    'title' => 'Mari Sertai',
                    'content' => 'Pertandingan dan Modul Pembelajaran Kompang Digital i-KompIra kini dibuka untuk pendaftaran!',
                    'buttons' => [
                        ['text' => 'Lihat Aktiviti', 'color' => 'bg-yellow-600 hover:bg-yellow-700', 'arrow' => true]
                    ]
                ],
                [
                    'title' => 'PERTANDINGAN KOMPANG PERINGKAT KEBANGSAAN 2025',
                    'content' => 'Ini peluang keemasan anda untuk menyerlahkan bakat kompang dan mengangkat irama warisan kita ke persada dunia!

🌸 Pendaftaran percuma
🌸 Pentas nasional 
🌸 Hadiah menarik menanti

JOM SERTAI KAMI DAN KEMERIAHAN FESTIVAL BUDAYA MALAYSIA 2025!',
                    'buttons' => [
                        ['text' => 'Lihat Lagi Aktiviti', 'color' => 'bg-yellow-600 hover:bg-yellow-700', 'arrow' => true],
                        ['text' => 'Sertai', 'color' => 'bg-green-600 hover:bg-green-700', 'arrow' => true]
                    ]
                ]
            ];
            ?>
            
            <!-- Table structure for the 2x2 layout -->
            <table class="w-full border-collapse">
                <tbody>
                    <!-- The <tr> acts as a responsive container: vertical stack (flex-col) on small screens, horizontal (flex-row) on large screens, with spacing (gap-8) -->
                    <tr class="flex flex-col lg:flex-row w-full gap-8">
                        <?php foreach ($cards as $card) { ?>
                        <!-- Each card is a <td>, taking full width on mobile (w-full) and half width on large screens (lg:w-1/2) -->
                        <td class="w-full lg:w-1/2 p-0">
                            <div class="bg-white/60 p-8 rounded-xl shadow-xl flex flex-col items-center gap-6 h-full">
                                <!-- Icon/Image Placeholder -->
                                <div class="flex-shrink-0">
                                    <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center border-4 border-white shadow-inner">
                                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9 5a1 1 0 112 0v2.586l1.707-1.707a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 111.414-1.414L9 7.586V5z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="flex-grow w-full text-center">
                                    <h3 class="text-lg font-extrabold text-orange-800 uppercase tracking-widest leading-snug mb-3"><?php echo $card['title']; ?></h3>
                                    <p class="mt-2 text-base text-gray-700 leading-relaxed whitespace-pre-line">
                                        <?php echo $card['content']; ?>
                                    </p>
                                </div>
                                
                                <!-- Button container -->
                                <div class="mt-6 w-full flex flex-col sm:flex-row justify-center items-center gap-3">
                                    <?php foreach($card['buttons'] as $button) { ?>
                                    <button class="<?php echo $button['color']; ?> text-white font-bold py-2 px-6 rounded-lg shadow-lg transition duration-300 transform hover:scale-105 active:scale-95 flex items-center justify-center w-full sm:w-auto">
                                        <span><?php echo $button['text']; ?></span>
                                        <?php if ($button['arrow']) { ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                        <?php } ?>
                                    </button>
                                    <?php } ?>
                                </div>
                            </div>
                        </td>
                        <?php } ?>
                    </tr>
                </tbody>
            </table>
        </section>

    </main>

<?php include '../src/components/footer.php'; ?>