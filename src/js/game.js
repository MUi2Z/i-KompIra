const notesLayer = document.getElementById('notes-layer');
const scoreDisplay = document.getElementById('score');
const livesDisplay = document.getElementById('lives');
const soundPak = document.getElementById('sound-pak');
const soundTung = document.getElementById('sound-tung');
const gameCircle = document.getElementById('game-circle');

let currentSongData = null;
let score = 0;
let lives = 5;
let playerRole = '';
let gameActive = false;
let notes = [];
let gameTime = 0;

const CONFIG = {
    speed: 4,
    hitZone: 60,
    spawnOffset: 1500, // Milisaat sebelum nota sampai ke tengah
};

let BEATMAP = []; // Kosong pada permulaan

async function selectSong(filename, element) {
    try {
        // 1. Ambil data dari folder uploads
        const response = await fetch(`../uploads/rhythms/${filename}`);
        if (!response.ok) throw new Error('Fail irama tidak dijumpai');
        
        const json = await response.json();
        currentSongData = json.data;

        // 2. Visual feedback (highlight butang yang dipilih)
        document.querySelectorAll('.song-btn').forEach(btn => {
            btn.classList.remove('border-yellow-500', 'bg-[#432818]');
            btn.classList.add('border-[#7f5539]');
        });
        element.classList.add('border-yellow-500', 'bg-[#432818]');

        // 3. Tunjukkan pemilihan peranan
        document.getElementById('role-selection').classList.remove('hidden');
        
        console.log("Lagu dimuat naik:", json.songTitle);
    } catch (error) {
        console.error("Ralat:", error);
        alert("Gagal memuat naik fail irama tersebut.");
    }
}

// Fungsi untuk ambil fail JSON
async function loadRhythm(filename) {
    try {
        const response = await fetch(`/uploads/rhythms/${filename}`);
        if (!response.ok) throw new Error('Fail irama tidak dijumpai');
        
        const json = await response.json();
        
        // Reset status spawned untuk setiap nota
        BEATMAP = json.data.map(item => ({
            ...item,
            spawned: false
        }));

        console.log("Irama berjaya dimuat naik:", json.songTitle);
    } catch (error) {
        console.error("Ralat memuat naik JSON:", error);
        alert("Gagal memuat naik fail irama.");
    }
}

// Ubah fungsi startGame untuk pastikan data sudah ada
async function startGame(role) {
    // Jika BEATMAP masih kosong, muat naik lagu default dahulu
    if (BEATMAP.length === 0) {
        await loadRhythm('lagu1.json'); 
    }

    playerRole = role;
    gameActive = true;
    score = 0;
    lives = 5;
    gameTime = 0;
    notes = [];
    notesLayer.innerHTML = '';
    
    // ... (kod selebihnya sama seperti sebelum ini)
    requestAnimationFrame(gameLoop);
}

function startGame(role) {
    if (!currentSongData) {
        alert("Sila pilih lagu terlebih dahulu!");
        return;
    }

    // Setkan BEATMAP daripada data lagu yang dipilih
    // Kita buat salinan supaya data asal tak berubah (penting untuk replay)
    BEATMAP = currentSongData.map(item => ({
        ...item,
        spawned: false
    }));

    playerRole = role;
    gameActive = true;
    score = 0;
    lives = 5;
    gameTime = 0;
    notes = [];
    notesLayer.innerHTML = '';
    
    scoreDisplay.innerText = score;
    livesDisplay.innerText = lives;
    document.getElementById('overlay').style.display = 'none';
    document.getElementById('mode-title').innerText = `PERANAN: ${role}`;
    
    requestAnimationFrame(gameLoop);
}

function createNote(type, role) {
    const el = document.createElement('div');
    const isPlayer = (role === playerRole);
    
    el.className = `indicator-note ${type === 'pak' ? 'tri-up' : 'tri-down'} ${!isPlayer ? 'note-ghost' : ''}`;
    el.style.left = '100%';
    notesLayer.appendChild(el);
    
    notes.push({ 
        el, 
        type, 
        role, 
        isPlayer,
        dist: 400, // Jarak mula
        autoPlayed: false 
    });
}

function handleHit(type) {
    // Mainkan bunyi setiap kali tekan (untuk feedback user)
    const sound = type === 'pak' ? soundPak : soundTung;
    sound.currentTime = 0;
    sound.play();

    let hitDetected = false;
    for (let i = 0; i < notes.length; i++) {
        let note = notes[i];
        // Hanya boleh hit nota milik peranan sendiri
        if (note.isPlayer && note.type === type && Math.abs(note.dist) < CONFIG.hitZone) {
            score += 20;
            scoreDisplay.innerText = score;
            note.el.remove();
            notes.splice(i, 1);
            hitDetected = true;
            flashCircle('#ffb703');
            break;
        }
    }
    
    if (!hitDetected) {
        flashCircle('#ff4d4d');
        // Penalti nyawa hanya jika gagal hit nota sendiri
        lives--;
        livesDisplay.innerText = lives;
        if (lives <= 0) gameOver();
    }
}

function gameLoop() {
    if (!gameActive) return;
    gameTime += 16.67; // Tambah ~16ms setiap frame (60fps)

    // Check beatmap untuk spawn nota baru
    BEATMAP.forEach((item, index) => {
        if (!item.spawned && gameTime >= (item.time - CONFIG.spawnOffset)) {
            createNote(item.type, item.role);
            item.spawned = true;
        }
    });

    for (let i = notes.length - 1; i >= 0; i--) {
        let note = notes[i];
        note.dist -= CONFIG.speed;

        // Posisi visual
        const verticalPos = (note.type === 'pak') ? '38%' : '62%';
        note.el.style.left = `calc(50% + ${note.dist}px)`;
        note.el.style.top = verticalPos;
        note.el.style.transform = `translate(-50%, -50%)`;

        // LOGIK AUTO-PLAY untuk peranan lain
        if (!note.isPlayer && note.dist <= 0 && !note.autoPlayed) {
            const sound = note.type === 'pak' ? soundPak : soundTung;
            const clone = sound.cloneNode(); // Guna clone supaya bunyi tak bertindih
            clone.play();
            note.autoPlayed = true;
            note.el.style.filter = 'brightness(2) drop-shadow(0 0 10px white)';
        }

        // Buang nota yang dah lepas
        if (note.dist < -100) {
            if (note.isPlayer && !note.autoPlayed) { 
                lives--; // Miss penalty
                livesDisplay.innerText = lives;
            }
            note.el.remove();
            notes.splice(i, 1);
            if (lives <= 0) gameOver();
        }
    }
    requestAnimationFrame(gameLoop);
}

// Event Listeners
window.addEventListener('keydown', (e) => { 
    if(!gameActive) return;
    const key = e.key.toLowerCase();
    if(key === 'w' || e.key === 'ArrowUp') handleHit('pak');
    if(key === 's' || e.key === 'ArrowDown') handleHit('tung');
});

document.getElementById('hit-area-top').onmousedown = (e) => { e.preventDefault(); handleHit('pak'); };
document.getElementById('hit-area-bottom').onmousedown = (e) => { e.preventDefault(); handleHit('tung'); };

function flashCircle(color) {
    gameCircle.style.borderColor = color;
    gameCircle.classList.add('hit-pulse');
    setTimeout(() => {
        gameCircle.style.borderColor = '#432818';
        gameCircle.classList.remove('hit-pulse');
    }, 100);
}

function gameOver() {
    gameActive = false;
    document.getElementById('overlay').style.display = 'flex';
    document.getElementById('status-title').innerText = "PERMAINAN TAMAT";
    document.getElementById('final-score').innerText = "Skor Akhir: " + score;
    document.getElementById('final-score').classList.remove('hidden');
    
    // Sembunyikan semula pemilihan peranan supaya pemain kena pilih lagu balik (atau kekalkan pun boleh)
    // document.getElementById('role-selection').classList.add('hidden');
}
