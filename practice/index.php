<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once '../config/connection.php';
include '../src/components/header.php';
include '../src/components/navbar.php';

// Ambil data irama dari database
$query = "SELECT * FROM rhythms ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<style>
    /* Indikator Nota */
    .indicator-note {
        position: absolute;
        width: 50px; 
        height: 50px;
        z-index: 40;
        border-radius: 4px;
    }

    /* Warna Berdasarkan Peranan */
    .role-melalu { background-color: #b8860b !important; }    /* Kuning Gelap */
    .role-menyilang { background-color: #006400 !important; } /* Hijau Tua */
    .role-menganak { background-color: #8b0000 !important; }  /* Merah */

    /* Highlight Nota Pemain */
    .player-target {
        outline: 4px solid #ffffff;
        box-shadow: 0 0 15px rgba(255,255,255,0.8);
        z-index: 50;
    }

    .note-ghost { opacity: 0.3; }

    /* Bentuk Ikut Pukulan */
    .tri-up { clip-path: polygon(50% 0%, 0% 100%, 100% 100%); }
    .tri-down { clip-path: polygon(50% 100%, 0% 0%, 100% 0%); }

    /* Overlay Cerah */
    .overlay-light {
        background-color: rgba(255, 255, 255, 0.98);
        color: #432818;
    }

    .btn-song {
        background: #ffffff;
        border: 2px solid #e6ccb2;
        color: #7f5539;
        transition: all 0.2s;
    }
    .btn-song:hover {
        border-color: #7f5539;
        background: #fdfaf1;
    }
    .btn-active {
        border-color: #7f5539;
        background: #ede0d4;
        font-weight: bold;
    }
</style>

<div class="relative flex flex-col items-center justify-center min-h-screen bg-[#fdfaf1] text-[#432818] overflow-hidden select-none">
    
    <a href="javascript:history.back()" 
       class="fixed top-6 left-6 z-[70] flex items-center gap-2 px-4 py-2 bg-white/90 backdrop-blur-sm border border-gray-200 rounded-xl shadow-md hover:bg-white hover:scale-105 active:scale-95 transition-all text-sm font-bold text-[#7f5539]">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m15 18-6-6 6-6"/>
        </svg>
        <span>KEMBALI</span>
    </a>

    <div id="overlay" class="fixed inset-0 z-50 flex flex-col items-center justify-start overflow-y-auto py-12 px-4 overlay-light transition-all duration-500">
        <div id="selection-container" class="w-full max-w-2xl my-auto"> 
            <div class="flex mb-4 justify-end">
                <button onclick="showTutorial()" class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-full text-xs font-bold text-gray-600 shadow-sm hover:text-[#D4A259] hover:border-[#D4A259] transition-all">
                    <i><svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                      <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.008-3.018a1.502 1.502 0 0 1 2.522 1.159v.024a1.44 1.44 0 0 1-1.493 1.418 1 1 0 0 0-1.037.999V14a1 1 0 1 0 2 0v-.539a3.44 3.44 0 0 0 2.529-3.256 3.502 3.502 0 0 0-7-.255 1 1 0 0 0 2 .076c.014-.398.187-.774.48-1.044Zm.982 7.026a1 1 0 1 0 0 2H12a1 1 0 1 0 0-2h-.01Z" clip-rule="evenodd"/>
                    </svg></i>
                     Tutorial Bermain
                </button>
            </div>
    
            <h2 id="status-title" class="text-3xl md:text-4xl text-center font-black text-[#7f5539] mb-8 uppercase tracking-tighter">Pilih Irama Kompang</h2>
            
            <div id="final-score-display" class="hidden text-center mb-6 p-4 bg-orange-100 rounded-lg">
                <p class="text-lg text-center font-bold">Permainan Tamat!</p>
                <p id="final-score-val" class="text-3xl font-black text-orange-700">0</p>
            </div>
    
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-8">
                <?php 
                mysqli_data_seek($result, 0); // Reset pointer jika perlu
                while($row = mysqli_fetch_assoc($result)): 
                ?>
                    <button 
                        class="btn-song p-4 rounded-xl text-left active:scale-95 transition-transform"
                        data-source='<?= htmlspecialchars($row['source'], ENT_QUOTES, 'UTF-8') ?>'
                        data-speed="<?= $row['beatSpeed'] ?>"
                        onclick="handleSongSelection(this)">
                        <span class="block font-black text-lg leading-tight"><?= htmlspecialchars($row['title']) ?></span>
                        <span class="text-xs opacity-70"><?= $row['difficulty'] ?> • BPM: <?= $row['beatSpeed'] ?></span>
                    </button>
                <?php endwhile; ?>
            </div>
    
            <div id="role-selection" class="hidden animate-fade-in pb-10">
                <p class="text-xs font-bold text-gray-400 mb-4 uppercase tracking-widest text-center">Pilih Peranan Anda</p>
                <div class="flex flex-wrap justify-center gap-3">
                    <button onclick="startGame('melalu')" class="flex-1 min-w-[120px] bg-[#b8860b] text-white px-6 py-3 rounded-lg font-bold shadow-md">MELALU</button>
                    <button onclick="startGame('menyilang')" class="flex-1 min-w-[120px] bg-[#006400] text-white px-6 py-3 rounded-lg font-bold shadow-md">MENYILANG</button>
                    <button onclick="startGame('menganak')" class="flex-1 min-w-[120px] bg-[#8b0000] text-white px-6 py-3 rounded-lg font-bold shadow-md">MENGANAK</button>
                    <button onclick="startGame('auto')" class="w-full mt-2 bg-gray-800 text-white px-6 py-3 rounded-lg font-bold ring-4 ring-gray-100">AUTO PLAY</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-center mb-6">
        <h1 id="display-mode" class="text-2xl font-black text-[#7f5539] uppercase tracking-widest">--</h1>
        <div id="game-stats" class="flex gap-4 justify-center mt-2 font-bold opacity-0">
            <span class="text-red-600 uppercase text-xs">Nyawa: <span id="lives-val" class="text-xl">5</span></span>
            <span class="text-orange-600 uppercase text-xs">Skor: <span id="score-val" class="text-xl">0</span></span>
        </div>
    </div>

    <div id="game-container" class="relative w-full max-w-2xl h-80 flex items-center justify-center">
        <div id="game-circle" class="relative w-64 h-64 rounded-full border-[12px] border-[#432818] bg-[#ede0d4] shadow-xl z-10 transition-colors overflow-hidden">
                    
            <div onclick="handleHit('pak')" class="absolute top-0 w-full h-1/2 border-b border-black/5 flex items-center justify-center font-black text-black/10 text-2xl cursor-pointer hover:bg-black/5 transition-colors">
                PAK
            </div>
                    
            <div onclick="handleHit('tung')" class="absolute bottom-0 w-full h-1/2 flex items-center justify-center font-black text-black/10 text-2xl cursor-pointer hover:bg-black/5 transition-colors">
                TUNG
            </div>
                    
        </div>
                    
        <div id="notes-layer" class="absolute inset-0 pointer-events-none z-40"></div>
        <div class="absolute left-1/2 h-full w-[2px] bg-black/5 -translate-x-1/2"></div>
    </div>

    <!-- <audio id="sound-pak" src="../src/sfx/snare.mp3"></audio>
    <audio id="sound-tung" src="../src/sfx/bass-drum.mp3"></audio> -->
    <audio id="sound-pak" src="../src/sfx/pak.MP3"></audio>
    <audio id="sound-tung" src="../src/sfx/tung.MP3"></audio>

    <script src="../src/js/game.js"></script>
</div>

<div id="tutorialOverlay" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 backdrop-blur-md hidden transition-opacity duration-500">
    <div class="bg-white w-full max-w-2xl rounded-3xl overflow-hidden shadow-2xl transform transition-all scale-95 opacity-0" id="tutorialCard">
        
        <div class="h-1.5 w-full bg-gray-100 flex">
            <div id="tutorialProgress" class="h-full bg-[#D4A259] transition-all duration-300" style="width: 20%"></div>
        </div>

        <div class="p-8 text-center">
            <div id="tutorialVisualContainer" class="w-full h-48 mx-auto mb-6 bg-gray-50 rounded-2xl flex items-center justify-center overflow-hidden border border-gray-100 shadow-inner">
                <img id="tutorialImage" src="" class="w-full h-full object-contain p-4 transition-all duration-500" alt="Tutorial Visual">
            </div>

            <h2 id="tutorialTitle" class="text-2xl font-black text-gray-800 mb-2 uppercase tracking-tight">Selamat Datang!</h2>
            <p id="tutorialDesc" class="text-gray-600 leading-relaxed mb-8">Mari belajar cara bermain Kompang Digital dalam masa 1 minit.</p>

            <div class="flex items-center justify-between gap-4">
                <button onclick="skipTutorial()" class="text-sm font-bold text-gray-400 hover:text-red-500 transition-colors uppercase tracking-widest">Skip</button>
                
                <div class="flex gap-2" id="tutorialDots">
                    </div>

                <button id="nextTutorialBtn" onclick="nextStep()" class="px-8 py-3 bg-[#D4A259] text-white font-black rounded-xl shadow-lg hover:bg-[#b88a4a] transition-all uppercase tracking-widest">
                    Seterusnya
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .tutorial-active { opacity: 1 !important; transform: scale(1) !important; }
</style>

<?php include '../src/components/footer.php'; ?>