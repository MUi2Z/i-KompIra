<?php include '../src/components/header.php'; ?>
<?php include '../src/components/navbar.php'; ?>

    <main class="container mx-auto px-4 py-8">

        <section class="relative bg-white/50 p-4 rounded-lg shadow-md">
            <div id="hero" class="relative m-2 border-12 rounded-2xl border-[#E7D8B8]" data-carousel="slide">
                <!-- Carousel wrapper -->
                <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                     <!-- Item 1 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="https://alkhudhri.com/wp-content/uploads/2020/12/kompang-2-768x576-2-768x480.jpg" class="absolute block max-w-full h-auto -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="">
                    </div>
                    <!-- Item 2 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                        <img src="https://i.ytimg.com/vi/5Tu9mEd96rE/maxresdefault.jpg" class="absolute block max-w-full h-auto -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="">
                    </div>
                    <!-- Item 3 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="https://scontent.fkul18-2.fna.fbcdn.net/v/t39.30808-6/524817593_1537204990903758_6812683560525746743_n.jpg?_nc_cat=100&ccb=1-7&_nc_sid=cc71e4&_nc_ohc=1izM-cs8TfIQ7kNvwHfcOgW&_nc_oc=AdkzAkmxqYMgfwg2-8XQ2Yr09f9NqN_LA33ovJA2BEHmm7ajc3iwxs1tV9yY33Zh5JA&_nc_zt=23&_nc_ht=scontent.fkul18-2.fna&_nc_gid=AJfsbo2KwjmLyb3kMPV8lQ&oh=00_AfbBiaM9ncCFnfAHRvaEvr--qn6KXUF_7TnEcrSjZjiTOA&oe=68C623C2" class="absolute block max-w-full h-auto -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="">
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

        <section class="mt-10 space-y-8">
            <?php
            // Sample data for cards
            $cards = [
                [
                    'title' => 'SEJARAH',
                    'content' => 'Kompang dipercayai berasal dari Timur Tengah berdasarkan beberapa pendapat iaitu: Pendapat pertama; Bentuknya sama dengan hadrah yang menyerupai kompang yang terdapat di negara Arab. Pendapat kedua; Lirik lagu yang dimainkan selalunya dalam bahasa Arab, contohnya Selawat Memuji Rasulullah SAW. Permainan kompang dibawa oleh pedagang Arab yang datang berdagang di Nusantara. Ia digunakan untuk menarik perhatian pembeli tentang barangan mereka. Dipercayai persembahan ini telah berkembang sehinggalah ia sinonim pada hari ini. Manakala permainan kompang hari ini hampir...',
                    'buttons' => [
                        ['text' => 'Lihat Modul', 'color' => 'bg-yellow-600 hover:bg-yellow-700', 'arrow' => true]
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

            foreach ($cards as $card) {
            ?>
            <div class="bg-white/60 p-6 rounded-lg shadow-md flex flex-col md:flex-row items-center gap-6">
                <div class="flex-shrink-0">
                    <div class="w-36 h-36 bg-gray-200 rounded-full flex items-center justify-center border-4 border-white shadow-inner">
                        <svg class="w-20 h-20 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9 5a1 1 0 112 0v2.586l1.707-1.707a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 111.414-1.414L9 7.586V5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <div class="flex-grow w-full text-center md:text-left">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest"><?php echo $card['title']; ?></h3>
                    <p class="mt-2 text-sm text-gray-700 leading-relaxed">
                        <?php echo $card['content']; ?>
                    </p>
                    
                    <div class="mt-4 flex flex-col sm:flex-row justify-center md:justify-end items-center gap-3">
                        <?php foreach($card['buttons'] as $button) { ?>
                        <button class="<?php echo $button['color']; ?> text-white font-semibold py-2 px-5 rounded-md shadow-md transition duration-300 flex items-center justify-center w-full sm:w-auto">
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
            </div>
            <?php } ?>
        </section>

    </main>

<?php include '../src/components/footer.php'; ?>