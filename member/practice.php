<?php
    include '../src/components/header.php';
    include '../src/components/navbar.php';
?>

<style>
    .indicator-note {
        position: absolute;
        width: 48px; 
        height: 48px;
        z-index: 40;
        filter: drop-shadow(0 0 8px rgba(0,0,0,0.6));
        transition: opacity 0.3s;
    }

    /* Nota yang bukan peranan pemain akan jadi pudar */
    .note-ghost { opacity: 0.35; }

    .tri-up {
        clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
        background: linear-gradient(to bottom, #00ffcc, #0099cc);
    }

    .tri-down {
        clip-path: polygon(50% 100%, 0% 0%, 100% 0%);
        background: linear-gradient(to top, #ff0066, #ff3300);
    }

    .hit-pulse { animation: pulse 0.1s ease-out; }
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }
</style>

<div class="flex flex-col items-center justify-center min-h-screen text-[#e2d1c3] overflow-hidden select-none">
    <div id="overlay" class="fixed inset-0 bg-black/95 z-50 flex items-center justify-center flex-col gap-6 text-center px-4">
        <h2 id="status-title" class="text-4xl font-bold text-[#d4a373] tracking-tighter uppercase">Kompang Interaktif</h2>
        <div id="final-score" class="hidden text-2xl text-white mb-4"></div>

        <div id="song-selection" class="w-full max-w-3xl">
            <p class="text-[#a98467] mb-4 tracking-widest uppercase text-sm">Langkah 1: Pilih Irama</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <button onclick="selectSong('simpleTest.json', this)" class="song-btn bg-[#2c1b0e] border-2 border-[#7f5539] p-4 rounded hover:bg-[#432818] transition-all">
                    <span class="block font-bold">Rentak Cubaan</span>
                    <span class="text-xs opacity-60">Tempo: Sederhana</span>
                </button>
                <button onclick="selectSong('sampleLagu.json', this)" class="song-btn bg-[#2c1b0e] border-2 border-[#7f5539] p-4 rounded hover:bg-[#432818] transition-all">
                    <span class="block font-bold">Rentak Ayubi</span>
                    <span class="text-xs opacity-60">Tempo: Rancak</span>
                </button>
            </div>
        </div>

        <div id="role-selection" class="w-full max-w-3xl hidden mt-6 border-t border-white/10 pt-6">
            <p class="text-[#a98467] mb-4 tracking-widest uppercase text-sm">Langkah 2: Pilih Peranan</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button onclick="startGame('melalu')" class="bg-[#7f5539] hover:bg-[#a98467] p-4 rounded border-b-4 border-black/50 transition-all font-bold">MELALU</button>
                <button onclick="startGame('menyilang')" class="bg-[#d4a373] hover:bg-[#e6ccb2] text-[#2c1b0e] p-4 rounded border-b-4 border-black/50 transition-all font-bold">MENYILANG</button>
                <button onclick="startGame('menganak')" class="bg-[#bc6c25] hover:bg-[#dda15e] p-4 rounded border-b-4 border-black/50 transition-all font-bold">MENGANAK</button>
            </div>
        </div>
    </div>

    <div class="text-center mb-8">
        <h1 id="mode-title" class="text-5xl font-black text-[#d4a373] drop-shadow-lg tracking-widest uppercase">--</h1>
        <div id="stats-ui" class="mt-2 h-16">
            <p class="uppercase tracking-widest text-sm text-[#a98467]">Nyawa: <span id="lives" class="text-3xl text-red-500">5</span> | Score: <span id="score" class="text-3xl text-[#ffb703]">0</span></p>
        </div>
    </div>

    <div id="game-container" class="relative w-full max-w-2xl h-80 flex items-center justify-center">
        <div id="game-circle" class="relative w-64 h-64 rounded-full border-8 border-[#432818] bg-[#ddcabb] shadow-[0_0_60px_rgba(0,0,0,0.8)] overflow-hidden z-10 transition-colors">
            <div id="hit-area-top" class="absolute top-0 w-full h-1/2 border-b border-[#432818]/30 flex flex-col items-center justify-center cursor-pointer hover:bg-white/5">
                <span class="text-orange-700 font-black text-xl z-50">PAK</span>
            </div>
            <div id="hit-area-bottom" class="absolute bottom-0 w-full h-1/2 flex flex-col items-center justify-center cursor-pointer hover:bg-white/5">
                <span class="text-orange-700 font-black text-xl z-50">TUNG</span>
            </div>
        </div>
        <div id="notes-layer" class="absolute inset-0 pointer-events-none z-40"></div>
        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-1 h-64 bg-yellow-500/20 z-20 pointer-events-none"></div>
    </div>

    <!-- Sounds -->
    <audio id="sound-pak" src="https://www.myinstants.com/media/sounds/snare.mp3"></audio>
    <audio id="sound-tung" src="https://www.myinstants.com/media/sounds/bass-drum.mp3"></audio>

    <script src="../src/js/game.js"></script>
</div>

<?php
    include '../src/components/footer.php';
?>