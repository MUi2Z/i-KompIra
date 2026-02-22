<?php
session_start();
include '../src/components/header.php'; 
?>

<audio id="sound-pak" src="../src/sfx/snare.mp3"></audio>
<audio id="sound-tung" src="../src/sfx/bass-drum.mp3"></audio>

<div class="min-h-screen bg-gray-50 flex flex-col">
    <nav class="bg-white border-b border-gray-200 px-8 py-4 flex justify-between items-center shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-[#D4A259] rounded-xl flex items-center justify-center text-white shadow-lg">
                <i class="fas fa-microphone-alt"></i>
            </div>
            <h1 class="text-xl font-bold text-gray-800 tracking-tight">Perakam Irama Kompang</h1>
        </div>
        <a href="../admin/rhythms.php" class="text-sm font-bold text-gray-500 hover:text-[#D4A259] transition-colors">&larr; Kembali</a>
    </nav>

    <div class="flex-1 p-6 max-w-6xl mx-auto w-full grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <h2 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-4">Konfigurasi</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">PERANAN (ROLE)</label>
                        <select id="rec-role" class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-[#D4A259]">
                            <option value="melalu">MELALU</option>
                            <option value="menganak">MENGANAK</option>
                            <option value="menyilang">MENYILANG</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">TEMPO (BPM)</label>
                        <input type="number" id="rec-bpm" value="100" class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-[#D4A259]">
                    </div>
                    <div class="pt-2">
                        <button id="btn-start" onclick="startRecording()" class="w-full py-4 bg-[#D4A259] text-white font-black rounded-2xl shadow-lg hover:bg-[#b88a4a] transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-play"></i> MULA RAKAM
                        </button>
                        <button id="btn-stop" onclick="stopRecording()" class="hidden w-full py-4 bg-red-500 text-white font-black rounded-2xl shadow-lg hover:bg-red-600 transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-stop"></i> BERHENTI
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <h2 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-4">Input Rakaman (Klik/Key)</h2>
                <div class="flex gap-4">
                    <button onclick="recordHit('pak')" id="btn-input-pak" class="flex-1 bg-amber-50 p-4 rounded-2xl border-2 border-amber-100 text-center active:scale-95 active:bg-amber-100 transition-all group">
                        <span class="block text-3xl font-black text-amber-700 group-hover:scale-110 transition-transform">W</span>
                        <span class="text-[11px] font-black text-amber-600 uppercase">PAK</span>
                    </button>
                    <button onclick="recordHit('tung')" id="btn-input-tung" class="flex-1 bg-orange-50 p-4 rounded-2xl border-2 border-orange-100 text-center active:scale-95 active:bg-orange-100 transition-all group">
                        <span class="block text-3xl font-black text-orange-700 group-hover:scale-110 transition-transform">S</span>
                        <span class="text-[11px] font-black text-orange-600 uppercase">TUNG</span>
                    </button>
                </div>
                <p class="text-[10px] text-gray-400 mt-4 text-center">Tekan butang di atas atau guna papan kekunci (W / S) untuk merakam.</p>
            </div>
        </div>

        <div class="lg:col-span-2 flex flex-col items-center justify-center bg-white rounded-3xl shadow-sm border border-gray-100 p-8 relative overflow-hidden">
            <div id="recording-status" class="absolute top-6 left-6 flex items-center gap-2 opacity-0 transition-opacity">
                <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                <span class="text-sm font-bold text-red-500 uppercase tracking-tighter">Recording...</span>
            </div>

            <div id="visual-kompang" class="w-64 h-64 rounded-full border-[12px] border-[#432818] bg-[#fdfaf3] shadow-2xl flex items-center justify-center relative transition-transform duration-75">
                <div id="hit-effect" class="absolute inset-0 rounded-full opacity-0 transition-opacity"></div>
                <img src="../public/assets/images/kompang_top.png" class="w-40 opacity-10 select-none" alt="">
                <div id="last-hit-text" class="absolute -bottom-12 text-3xl font-black text-[#432818] uppercase"></div>
            </div>

            <div class="w-full mt-16">
                <div class="flex justify-between items-center mb-2">
                    <label class="text-xs font-black text-gray-400 uppercase">Data JSON Terjana</label>
                    <button onclick="copyJSON()" class="text-[10px] bg-gray-800 text-white px-4 py-1.5 rounded-full hover:bg-black transition-all">
                        <i class="fas fa-copy mr-1"></i> SALIN DATA
                    </button>
                </div>
                <textarea id="json-output" readonly class="w-full h-40 bg-gray-50 border border-gray-200 rounded-2xl p-4 font-mono text-[11px] text-gray-600 outline-none resize-none shadow-inner"></textarea>
            </div>
        </div>

    </div>
</div>

<style>
    .hit-shake { transform: scale(0.92); }
    .hit-glow-pak { background-color: rgba(212, 162, 89, 0.4) !important; }
    .hit-glow-tung { background-color: rgba(67, 40, 24, 0.2) !important; }
</style>

<script>
let isRecording = false;
let startTime = 0;
let recordedData = [];

// Fungsi Audio (Sama seperti game.js)
function triggerSound(type) {
    const audio = document.getElementById(type === 'pak' ? 'sound-pak' : 'sound-tung');
    const clone = audio.cloneNode();
    clone.volume = 0.7;
    clone.play();
}

function startRecording() {
    isRecording = true;
    recordedData = [];
    startTime = performance.now();
    document.getElementById('btn-start').classList.add('hidden');
    document.getElementById('btn-stop').classList.remove('hidden');
    document.getElementById('recording-status').style.opacity = '1';
    document.getElementById('json-output').value = "";
    document.getElementById('last-hit-text').innerText = "READY!";
}

function stopRecording() {
    isRecording = false;
    document.getElementById('btn-start').classList.remove('hidden');
    document.getElementById('btn-stop').classList.add('hidden');
    document.getElementById('recording-status').style.opacity = '0';
    
    recordedData.push({ 
        time: Math.floor(performance.now() - startTime + 500), 
        type: 'finish' 
    });
    
    document.getElementById('json-output').value = JSON.stringify(recordedData, null, 2);
    document.getElementById('last-hit-text').innerText = "DONE";
}

// Fungsi Utama Rakaman (Dikongsi oleh Klik & Keydown)
function recordHit(type) {
    if (!isRecording) {
        // Jika tidak merakam, masih benarkan bunyi untuk test
        triggerSound(type);
        return;
    }

    triggerSound(type);
    const timestamp = Math.floor(performance.now() - startTime);
    const role = document.getElementById('rec-role').value;
    recordedData.push({ time: timestamp, type: type, role: role });

    // Visual Feedback
    const kompang = document.getElementById('visual-kompang');
    const effect = document.getElementById('hit-effect');
    const text = document.getElementById('last-hit-text');

    text.innerText = type;
    kompang.classList.add('hit-shake');
    effect.classList.add(type === 'pak' ? 'hit-glow-pak' : 'hit-glow-tung');
    effect.style.opacity = '1';

    setTimeout(() => {
        kompang.classList.remove('hit-shake');
        effect.style.opacity = '0';
        setTimeout(() => {
            effect.classList.remove('hit-glow-pak', 'hit-glow-tung');
        }, 100);
    }, 50);
}

// Keyboard Listener
window.addEventListener('keydown', (e) => {
    const key = e.key.toLowerCase();
    if (key === 'w' || key === 'arrowup') recordHit('pak');
    if (key === 's' || key === 'arrowdown') recordHit('tung');
});

function copyJSON() {
    const textarea = document.getElementById('json-output');
    if(!textarea.value) return;
    textarea.select();
    document.execCommand('copy');
    alert("Berjaya disalin ke clipboard!");
}
</script>

<?php include '../src/components/footer.php'; ?>