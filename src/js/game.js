let BEATMAP = [];
let currentRawData = null;
let playerRole = '';
let gameActive = false;
let notes = [];
let gameTime = 0;
let lastTimestamp = 0;
let score = 0;
let lives = 5;

const CONFIG = {
    speed: 5,
    hitZone: 60,
    spawnOffset: 2000 
};

function handleSongSelection(el) {
    const rawJson = el.getAttribute('data-source');
    const speed = el.getAttribute('data-speed');
    try {
        const parsed = JSON.parse(rawJson);
        if (Array.isArray(parsed) && parsed[0].data) {
            currentRawData = parsed[0].data;
        } else if (parsed.data) {
            currentRawData = parsed.data;
        } else if (Array.isArray(parsed)) {
            currentRawData = parsed;
        }

        if (!currentRawData || !Array.isArray(currentRawData)) {
            throw new Error("Data nota tidak dijumpai.");
        }

        CONFIG.speed = parseInt(speed);
        document.querySelectorAll('.btn-song').forEach(b => b.classList.remove('btn-active'));
        el.classList.add('btn-active');
        document.getElementById('role-selection').classList.remove('hidden');
    } catch(e) { 
        alert("Ralat JSON: " + e.message); 
    }
}

function startGame(role) {
    playerRole = role;
    gameActive = true;
    score = 0;
    lives = 5;
    gameTime = 0;
    lastTimestamp = performance.now();
    notes = [];
    document.getElementById('notes-layer').innerHTML = '';
    
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
    el.className = `indicator-note role-${data.role} ${data.type === 'pak' ? 'tri-up' : 'tri-down'}`;
    
    if (playerRole !== 'auto') {
        if (isPlayerNote) el.classList.add('player-target');
        else el.classList.add('note-ghost');
    }
    document.getElementById('notes-layer').appendChild(el);
    notes.push({ ...data, el, processed: false });
}

function gameLoop(timestamp) {
    if (!gameActive) return;
    const deltaTime = timestamp - lastTimestamp;
    lastTimestamp = timestamp;
    gameTime += deltaTime;

    BEATMAP.forEach(item => {
        if (!item.spawned && gameTime >= (item.time - CONFIG.spawnOffset)) {
            if (item.type === 'finish') {
                item.spawned = true;
                setTimeout(() => { if(gameActive) stopGame(); }, 1500);
            } else {
                createNote(item);
                item.spawned = true;
            }
        }
    });

    for (let i = notes.length - 1; i >= 0; i--) {
        let n = notes[i];
        const timeRemaining = n.time - gameTime;
        n.dist = (timeRemaining / 1000) * (CONFIG.speed * 100); 

        n.el.style.left = `calc(50% + ${n.dist}px)`;
        n.el.style.top = (n.type === 'pak') ? '38%' : '62%';

        const isAuto = (playerRole === 'auto' || n.role !== playerRole);
        if (isAuto && n.dist <= 0 && !n.processed) {
            triggerSound(n.type);
            n.processed = true;
            n.el.style.filter = 'brightness(2) scale(1.2)';
            setTimeout(() => { if(n.el) n.el.remove(); }, 100);
            notes.splice(i, 1);
            continue;
        }

        if (n.dist < -150) {
            // Jika nota milik pemain meluncur keluar tanpa di-hit
            if (n.role === playerRole && !n.processed) {
                updateLife(-1); // Missed!
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
    if (!gameActive || playerRole === 'auto') return;
    
    triggerSound(type);
    let hitFound = false;

    for (let i = 0; i < notes.length; i++) {
        let n = notes[i];
        
        // Kita hanya proses nota yang belum di-hit/diproses
        if (n.role === playerRole && n.type === type && !n.processed) {
            const distance = Math.abs(n.dist);
            
            if (distance < CONFIG.hitZone) {
                score += 20;
                document.getElementById('score-val').innerText = score;
                
                n.processed = true; // Tandakan dah kena
                n.el.remove();
                notes.splice(i, 1);
                
                hitFound = true;
                flashCircle('#fbbf24'); // Kuning/Emas (Hit!)
                break; 
            }
        }
    }

    // Hanya tolak nyawa kalau pemain "salah tekan" (tiada nota langsung dekat situ)
    if (!hitFound) {
        updateLife(-1);
        flashCircle('#ef4444'); // Merah (Salah!)
    }
}

function updateLife(val) {
    lives += val;
    document.getElementById('lives-val').innerText = lives;
    if (lives <= 0) stopGame();
}

function flashCircle(color) {
    const c = document.getElementById('game-circle');
    if(c) {
        c.style.borderColor = color;
        setTimeout(() => c.style.borderColor = '#432818', 100);
    }
}

function stopGame() {
    gameActive = false;
    document.getElementById('overlay').style.display = 'flex';
    document.getElementById('status-title').innerText = "PERMAINAN TAMAT!";
    document.getElementById('final-score-display').classList.remove('hidden');
    document.getElementById('final-score-val').innerText = score;
}

// Input Keyboard
window.addEventListener('keydown', e => {
    const key = e.key.toLowerCase();
    if (key === 'w' || key === 'arrowup') handleHit('pak');
    if (key === 's' || key === 'arrowdown') handleHit('tung');
});



// ----- Tutorial Onboarding ------
const tutorialSteps = [
    {
        title: "Konsep Permainan",
        desc: "Tekan butang mengikut irama yang bergerak! Anda mempunyai 5 nyawa ❤️. Setiap kali terlepas (Miss), nyawa akan berkurang.",
        image: "../src/img/tutor_lifeScore.png", // Ganti dengan path gambar anda
    },
    {
        title: "Bezakan Warna Peranan Yang Dipilih",
        desc: "Warna <span class='text-[#b8860b] font-bold'>EMAS untuk Melalu</span>. Warna <span class='text-[#006400] font-bold'>HIJAU untuk Menyilang</span> dan Warna <span class='text-[#8b0000] font-bold'>MERAH untuk Menganak</span>. Jika salah, nyawa akan berkurang!",
        image: "../src/img/tutor_colorMark.png",
    },
    {
        title: "Mode Auto-Play",
        desc: "Ingin dengar irama sahaja? Hidupkan Mode Auto untuk melihat cara komputer bermain secara sempurna.",
        image: "../src/img/tutor_autoPlay.png",
    },
    {
        title: "Mula Bermain!",
        desc: "Sekarang anda sudah bersedia untuk mencuba lagu-lagu yang tersedia. Tekan butang 'MULA MAIN!' untuk memulakan permainan.",
        image: "../src/img/tutor_start.png",
    }
];


let currentStep = 0;

function initTutorial() {
    // Semak jika sudah melihat tutorial dalam sesi ini
    if (!sessionStorage.getItem('tutorialDone')) {
        showTutorial();
    }
}

function showTutorial() {
    currentStep = 0;
    const overlay = document.getElementById('tutorialOverlay');
    const card = document.getElementById('tutorialCard');
    
    overlay.classList.remove('hidden');
    setTimeout(() => {
        card.classList.add('tutorial-active');
        updateTutorialUI();
    }, 10);
}

function updateTutorialUI() {
    const step = tutorialSteps[currentStep];
    const progress = ((currentStep + 1) / tutorialSteps.length) * 100;
    
    // Tukar gambar
    const imgElement = document.getElementById('tutorialImage');
    imgElement.style.opacity = '0'; // Animasi pudar keluar
    
    setTimeout(() => {
        imgElement.src = step.image;
        imgElement.style.opacity = '1'; // Animasi pudar masuk
    }, 200);

    document.getElementById('tutorialTitle').innerText = step.title;
    document.getElementById('tutorialDesc').innerHTML = step.desc;
    document.getElementById('tutorialProgress').style.width = `${progress}%`;
    document.getElementById('nextTutorialBtn').innerText = currentStep === tutorialSteps.length - 1 ? "MULA MAIN!" : "Seterusnya";
}

function nextStep() {
    if (currentStep < tutorialSteps.length - 1) {
        currentStep++;
        updateTutorialUI();
    } else {
        skipTutorial();
    }
}

function skipTutorial() {
    const overlay = document.getElementById('tutorialOverlay');
    const card = document.getElementById('tutorialCard');
    
    card.classList.remove('tutorial-active');
    setTimeout(() => {
        overlay.classList.add('hidden');
        sessionStorage.setItem('tutorialDone', 'true');
    }, 300);
}

// Jalankan auto-init bila page load
window.addEventListener('DOMContentLoaded', initTutorial);