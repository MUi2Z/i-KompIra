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
    
    <a href="javascript:history.back()" class="absolute top-6 left-6 z-[60] flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 transition-all text-sm font-bold">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        KEMBALI
    </a>

    <div id="overlay" class="fixed inset-0 z-50 flex items-center justify-center flex-col gap-8 text-center px-4 overlay-light">
        <div id="selection-container" class="w-full max-w-2xl">
            <h2 id="status-title" class="text-4xl font-black text-[#7f5539] mb-8 uppercase tracking-tighter">Pilih Irama Kompang</h2>
            
            <div id="final-score-display" class="hidden mb-6 p-4 bg-orange-100 rounded-lg">
                <p class="text-lg font-bold">Permainan Tamat!</p>
                <p id="final-score-val" class="text-3xl font-black text-orange-700">0</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-8">
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <button 
                        class="btn-song p-4 rounded-xl text-left"
                        data-source='<?= htmlspecialchars($row['source'], ENT_QUOTES, 'UTF-8') ?>'
                        data-speed="<?= $row['beatSpeed'] ?>"
                        onclick="handleSongSelection(this)">

                        <span class="block font-black text-lg"><?= htmlspecialchars($row['title']) ?></span>
                        <span class="text-xs opacity-70"><?= $row['difficulty'] ?> • Speed: <?= $row['beatSpeed'] ?></span>
                    </button>
                <?php endwhile; ?>
            </div>

            <div id="role-selection" class="hidden animate-fade-in">
                <p class="text-xs font-bold text-gray-400 mb-4 uppercase tracking-widest">Pilih Peranan Anda</p>
                <div class="flex flex-wrap justify-center gap-3">
                    <button onclick="startGame('melalu')" class="bg-[#b8860b] text-white px-6 py-3 rounded-lg font-bold">MELALU</button>
                    <button onclick="startGame('menyilang')" class="bg-[#006400] text-white px-6 py-3 rounded-lg font-bold">MENYILANG</button>
                    <button onclick="startGame('menganak')" class="bg-[#8b0000] text-white px-6 py-3 rounded-lg font-bold">MENGANAK</button>
                    <button onclick="startGame('auto')" class="bg-gray-800 text-white px-6 py-3 rounded-lg font-bold ring-4 ring-gray-200">AUTO PLAY</button>
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

    <audio id="sound-pak" src="../src/sfx/snare.mp3"></audio>
    <audio id="sound-tung" src="../src/sfx/bass-drum.mp3"></audio>

    <script src="../src/js/game.js"></script>
</div>

<?php include '../src/components/footer.php'; ?>