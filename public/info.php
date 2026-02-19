<?php 
session_start();
include_once '../config/connection.php';
include '../src/components/header.php'; 
include '../src/components/navbar.php'; 
?>

<main class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto space-y-12">
        
        <section class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden transition-all hover:shadow-md">
            <div class="flex flex-col md:flex-row">
                <div class="md:w-1/2 relative min-h-[300px]">
                    <img src="../src/img/OriginTeam.png" 
                         class="absolute inset-0 w-full h-full object-cover" 
                         alt="Pasukan Kompang Irama Kolej">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent md:hidden"></div>
                </div>

                <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
                    <h2 class="text-[#D4A259] font-black uppercase tracking-widest text-sm mb-3">Mengenai Kami</h2>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight mb-6">
                        "Meraikan Warisan, <br class="hidden md:block"> Menyatu Dalam Irama"
                    </h1>
                    <p class="text-gray-600 leading-relaxed mb-8">
                        Selamat datang ke <strong>Laman Kompang Irama Kolej</strong> — platform digital rasmi untuk aktiviti, rujukan, dan pemeliharaan seni kompang institusi kami. Kami menjadi pusat rujukan digital bagi ahli kelab dan pelajar untuk mendalami seni muzik tradisional ini dengan sentuhan teknologi moden.
                    </p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="flex items-start">
                            <div class="bg-amber-100 p-2 rounded-lg text-[#D4A259] mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">Budaya</h4>
                                <p class="text-xs text-gray-500 italic">Memartabatkan warisan seni bangsa.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-amber-100 p-2 rounded-lg text-[#D4A259] mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">Latihan</h4>
                                <p class="text-xs text-gray-500 italic">Tutorial interaktif & rujukan irama.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 bg-white p-8 md:p-10 rounded-3xl shadow-sm border border-gray-100">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <span class="w-8 h-1 bg-[#D4A259] mr-4 rounded-full"></span>
                    Apa Yang Disediakan?
                </h3>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <span class="text-[#D4A259] mr-3 font-bold">•</span>
                        <p class="text-gray-600"><span class="font-bold text-gray-800">Galeri Aktiviti:</span> Jadual terkini program dan latihan kelab untuk disertai.</p>
                    </li>
                    <li class="flex items-start">
                        <span class="text-[#D4A259] mr-3 font-bold">•</span>
                        <p class="text-gray-600"><span class="font-bold text-gray-800">Galeri Media:</span> Dokumentasi visual dan rakaman persembahan kelab yang eksklusif.</p>
                    </li>
                    <li class="flex items-start">
                        <span class="text-[#D4A259] mr-3 font-bold">•</span>
                        <p class="text-gray-600"><span class="font-bold text-gray-800">Laman Interaktif:</span> Modul belajar rentak irama kompang secara digital untuk ahli kelab.</p>
                    </li>
                </ul>
            </div>

            <div class="bg-[#D4A259] p-8 md:p-10 rounded-3xl shadow-lg shadow-amber-200 flex flex-col justify-center text-white">
                <svg class="w-12 h-12 mb-6 opacity-50" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 13.1216 16 12.017 16L9.01705 16C7.91248 16 7.01705 16.8954 7.01705 18L7.01705 21M4.26757 8.20164C4.35697 6.40332 5.83665 5 7.63824 5H16.3958C18.1974 5 19.6771 6.40332 19.7665 8.20164L20.6225 25.4523C20.6639 26.2858 19.9997 27 19.1652 27H4.86891C4.03437 27 3.37018 26.2858 3.41154 25.4523L4.26757 8.20164Z" stroke="white" stroke-width="2"/></svg>
                <p class="text-xl font-medium italic mb-4 leading-relaxed">
                    "Dari Kampus ke Komuniti, Kompang Menyambung Ummah!"
                </p>
                <p class="text-sm opacity-90 uppercase tracking-widest font-bold">
                    Kompang Irama Kolej
                </p>
            </div>
        </section>

    </div>
</main>

<?php include '../src/components/footer.php'; ?>