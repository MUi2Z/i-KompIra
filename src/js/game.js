let BEATMAP = [];
let currentRawData = null;
let playerRole = ''; // 'melalu', 'menyilang', 'menganak', 'auto'
let gameActive = false;
let notes = [];
let gameTime = 0;
let score = 0;
let lives = 5;

const CONFIG = {
    speed: 5,
    hitZone: 60,
    spawnOffset: 2000 
};

function handleSongSelection(el) {
    // Ambil string JSON dari atribut data-source
    const rawJson = el.getAttribute('data-source');
    const speed = el.getAttribute('data-speed');

    console.log("Mencuba parse JSON...");

    try {
        currentRawData = JSON.parse(rawJson);
        CONFIG.speed = parseInt(speed);

        // Visual feedback
        document.querySelectorAll('.btn-song').forEach(b => b.classList.remove('btn-active'));
        el.classList.add('btn-active');
        
        document.getElementById('role-selection').classList.remove('hidden');
        console.log("Berjaya!");
    } catch(e) { 
        console.error("Ralat Parse JSON:", e);
        alert("Data JSON dalam database tidak sah. Sila semak format JSON anda."); 
    }
}

function startGame(role) {
    playerRole = role;
    gameActive = true;
    score = 0;
    lives = 5;
    gameTime = 0;
    notes = [];
    document.getElementById('notes-layer').innerHTML = '';
    
    // Reset data spawn
    BEATMAP = currentRawData.map(n => ({ ...n, spawned: false }));

    document.getElementById('overlay').style.display = 'none';
    document.getElementById('display-mode').innerText = `MOD: ${role}`;
    
    if(role !== 'auto') {
        document.getElementById('game-stats').style.opacity = '1';
        document.getElementById('score-val').innerText = '0';
        document.getElementById('lives-val').innerText = '5';
    } else {
        document.getElementById('game-stats').style.opacity = '0';
    }

    requestAnimationFrame(gameLoop);
}

function createNote(data) {
    const el = document.createElement('div');
    const isPlayerNote = (data.role === playerRole);
    
    // Set style mengikut peranan dan jenis pukulan
    el.className = `indicator-note role-${data.role} ${data.type === 'pak' ? 'tri-up' : 'tri-down'}`;
    
    if (playerRole !== 'auto') {
        if (isPlayerNote) el.classList.add('player-target');
        else el.classList.add('note-ghost');
    }

    document.getElementById('notes-layer').appendChild(el);
    
    notes.push({
        ...data,
        el,
        dist: 500,
        processed: false
    });
}

function gameLoop() {
    if (!gameActive) return;
    gameTime += 16.67;

    // Logik Spawn (Menyokong nota serentak)
    BEATMAP.forEach(item => {
        if (!item.spawned && gameTime >= (item.time - CONFIG.spawnOffset)) {
            createNote(item);
            item.spawned = true;
        }
    });

    for (let i = notes.length - 1; i >= 0; i--) {
        let n = notes[i];
        n.dist -= CONFIG.speed;

        n.el.style.left = `calc(50% + ${n.dist}px)`;
        n.el.style.top = (n.type === 'pak') ? '38%' : '62%';
        n.el.style.transform = `translate(-50%, -50%)`;

        // Logik Auto Play (Untuk peranan lain ATAU Mod Auto)
        const isAutoNeeded = (playerRole === 'auto' || n.role !== playerRole);
        
        if (isAutoNeeded && n.dist <= 0 && !n.processed) {
            triggerSound(n.type);
            n.processed = true;
            n.el.style.filter = 'brightness(2)';
            setTimeout(() => { if(n.el) n.el.remove(); }, 100);
            notes.splice(i, 1);
            continue;
        }

        // Lepas zon hit
        if (n.dist < -100) {
            if (n.role === playerRole && !n.processed) {
                updateLife(-1);
            }
            n.el.remove();
            notes.splice(i, 1);
        }
    }
    requestAnimationFrame(gameLoop);
}

function triggerSound(type) {
    const audio = document.getElementById(type === 'pak' ? 'sound-pak' : 'sound-tung');
    const clone = audio.cloneNode();
    clone.play();
}

function handleHit(type) {
    // 1. Jangan buat apa-apa jika game belum mula atau dalam mod Auto
    if (!gameActive || playerRole === 'auto') return;
    
    // 2. Mainkan bunyi
    triggerSound(type);
    
    let hitFound = false;

    // 3. Logik semakan hit
    for (let i = 0; i < notes.length; i++) {
        let n = notes[i];
        
        // Hanya semak nota yang sepadan dengan peranan pemain
        if (n.role === playerRole && n.type === type && Math.abs(n.dist) < CONFIG.hitZone) {
            score += 20;
            document.getElementById('score-val').innerText = score;
            n.el.remove();
            notes.splice(i, 1);
            hitFound = true;
            flashCircle('#fbbf24'); // Kuning (Tanda Hit)
            break;
        }
    }

    // 4. Jika klik tapi tiada nota dalam zon
    if (!hitFound) {
        updateLife(-1);
        flashCircle('#ef4444'); // Merah (Tanda Miss)
    }
}

function updateLife(val) {
    lives += val;
    document.getElementById('lives-val').innerText = lives;
    if (lives <= 0) stopGame();
}

function flashCircle(color) {
    const c = document.getElementById('game-circle');
    c.style.borderColor = color;
    setTimeout(() => c.style.borderColor = '#432818', 100);
}

function stopGame() {
    gameActive = false;
    document.getElementById('overlay').style.display = 'flex';
    document.getElementById('status-title').innerText = "TAMAT PERMAINAN";
    document.getElementById('final-score-display').classList.remove('hidden');
    document.getElementById('final-score-val').innerText = score;
}

// Input
window.addEventListener('keydown', e => {
    const key = e.key.toLowerCase();
    if (key === 'w' || key === 'arrowup') handleHit('pak');
    if (key === 's' || key === 'arrowdown') handleHit('tung');
});