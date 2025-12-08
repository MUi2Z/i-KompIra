<?php include '../src/components/header.php'; ?>
<?php include '../src/components/navbar.php'; ?>

<main class="container mx-auto py-8 px-4 sm:px-6">

    <section class="text-center mb-10">
        <h1 class="text-3xl font-bold tracking-tight text-gray-800">MAKLUMAT AKTIVITI</h1>
        <p class="text-gray-500 mt-2">Perincian Latihan Persembahan Melaka</p>
    </section>

    <!-- Main Activity Card: Centered and using the original colors -->
    <div class="max-w-5xl mx-auto rounded-xl shadow-2xl overflow-hidden bg-amber-50/90 border border-amber-100">

        <!-- Image Placeholder Section (Integrated) -->
        <section class="bg-white/50 p-8 pt-10 border-b border-amber-100">
            <div class="w-40 h-40 bg-gray-200 rounded-full mx-auto flex items-center justify-center border-6 border-white shadow-lg ring-4 ring-white/80">
                <!-- SVG Icon for placeholder -->
                <svg class="w-24 h-24 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9 5a1 1 0 112 0v2.586l1.707-1.707a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 111.414-1.414L9 7.586V5z" clip-rule="evenodd" />
                </svg>
            </div>
            <p class="text-center mt-4 text-xl font-semibold text-gray-700">Latihan Persembahan Melaka</p>
        </section>

        <!-- Details and Description Section -->
        <section class="p-8 md:p-12 space-y-8">
            
            <div class="flex flex-col lg:flex-row lg:space-x-12">
                
                <!-- Activity Metadata (1/3 width on large screens) -->
                <div class="text-lg font-medium space-y-3 mb-6 lg:mb-0 lg:w-1/3 p-4 border-l-4 border-amber-400 bg-amber-100/50 rounded-lg">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 border-b border-amber-200 pb-2">Butiran Utama</h2>
                    <p><span class="font-bold text-gray-700">Nama Aktiviti:</span> Latihan Persembahan Melaka</p>
                    <p><span class="font-bold text-gray-700">Tarikh:</span> 25 Ogos 2025 (Isnin)</p>
                    <p><span class="font-bold text-gray-700">Masa:</span> 8.30 pagi - 12.30 tengah hari</p>
                    <p><span class="font-bold text-gray-700">Tempat:</span> Dewan Serbaguna Kolej</p>
                </div>
                
                <!-- Description (2/3 width on large screens) -->
                <div class="text-lg lg:w-2/3 p-4">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 border-b border-amber-200 pb-2">Keterangan Aktiviti</h2>
                    <p class="leading-relaxed text-gray-600">
                        Dengan sukacitanya dimaklumkan bahawa Kelab Kompang akan menganjurkan beberapa aktiviti menarik bagi semua ahli kelab. Aktiviti ini bertujuan untuk memantapkan kemahiran bermain kompang, mengeratkan ukhuwah sesama ahli, serta melestarikan seni warisan budaya kita.
                        Penyertaan adalah digalakkan bagi semua ahli untuk memastikan persembahan yang mantap dan bersemangat. Sila hadir 15 minit lebih awal untuk pendaftaran.
                    </p>
                </div>
            </div>
            
            <!-- Action Button -->
            <div class="flex justify-center pt-6">
                <button class="bg-green-700/80 hover:bg-green-700 text-white font-extrabold py-3 px-10 rounded-full shadow-xl hover:shadow-2xl transition duration-300 transform hover:scale-105 uppercase tracking-wider">
                    SERTAI AKTIVITI
                </button>
            </div>
        </section>

    </div>

</main>

<?php include '../src/components/footer.php'; ?>