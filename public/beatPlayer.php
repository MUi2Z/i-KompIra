<?php
    include '../src/components/header.php';
?>
<div class="flex flex-col items-center justify-center min-h-screen text-[#e2d1c3] font-serif overflow-hidden select-none">

    <div id="overlay" class="fixed inset-0 bg-black/90 z-50 flex items-center justify-center flex-col gap-6">
        <h2 class="text-4xl font-bold text-[#d4a373] tracking-tighter">THE CRAFTSMAN'S DRUM</h2>
        <div class="flex gap-4">
            <button onclick="startGame('basic')" class="bg-[#7f5539] hover:bg-[#a98467] px-8 py-4 rounded border-b-4 border-[#432818] font-bold uppercase transition-all">Basic Mode (Constant)</button>
            <button onclick="startGame('free')" class="bg-[#d4a373] hover:bg-[#e6ccb2] text-[#2c1b0e] px-8 py-4 rounded border-b-4 border-[#7f5539] font-bold uppercase transition-all">Free Mode (Smooth)</button>
        </div>
    </div>

    <div class="text-center mb-8">
        <h1 id="mode-title" class="text-5xl font-black text-[#d4a373] drop-shadow-lg">Timber Beat</h1>
        <p class="uppercase tracking-widest text-sm text-[#a98467] mt-2">Score: <span id="score" class="text-3xl text-[#ffb703]">0</span></p>
    </div>

    <div id="game-circle" class="relative w-80 h-80 rounded-full border-8 border-[#432818] bg-[#582f0e] shadow-[0_0_60px_rgba(0,0,0,0.8)] overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-white/5 to-black/20 pointer-events-none"></div>
        
        <div class="absolute top-0 w-full h-1/2 border-b border-[#432818]/30 flex items-start justify-center pt-4 opacity-20 text-[10px] font-bold">SNARE HALF</div>
        <div class="absolute bottom-0 w-full h-1/2 flex items-end justify-center pb-4 opacity-20 text-[10px] font-bold">KICK HALF</div>

        <div id="indicator" class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-9 h-9 bg-gradient-to-br from-[#ffdc73] via-[#ffb703] to-[#8c6a00] rounded-full shadow-[0_0_20px_#ffb703] border border-white/30 z-20"></div>
    </div>

    <div class="mt-12 flex flex-col items-center gap-2">
        <div id="controls-hint" class="text-orange-800 text-xs font-bold uppercase tracking-[0.2em]">Spacebar to Play</div>
        <div class="flex gap-4 opacity-40">
            <div class="w-8 h-8 border border-[#7f5539] flex items-center justify-center rounded">W</div>
            <div class="w-8 h-8 border border-[#7f5539] flex items-center justify-center rounded">S</div>
        </div>
    </div>

    <audio id="sound-snare" src="https://www.myinstants.com/media/sounds/snare.mp3"></audio>
    <audio id="sound-kick" src="https://www.myinstants.com/media/sounds/bass-drum.mp3"></audio>

    <script>
        const indicator = document.getElementById('indicator');
        const scoreDisplay = document.getElementById('score');
        const snare = document.getElementById('sound-snare');
        const kick = document.getElementById('sound-kick');
        
        let score = 0;
        let gameMode = '';
        let posY = 0; 
        let velocity = 0;
        let direction = 1; // 1 for down, -1 for up
        
        const speed = 3.5; // Constant speed for Basic Mode
        const acceleration = 1; // How fast it picks up speed in Free Mode
        const friction = 0.7; // How fast it slows down in Free Mode
        const maxLimit = 135; // Don't hit the wood!

        const keys = { w: false, s: false, ArrowUp: false, ArrowDown: false };

        function startGame(mode) {
            gameMode = mode;
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('mode-title').innerText = mode === 'free' ? 'Free Session' : 'Steady Beat';
            requestAnimationFrame(update);
        }

        window.addEventListener('keydown', (e) => { 
            if(keys.hasOwnProperty(e.key)) keys[e.key] = true; 
            if(e.code === 'Space') { e.preventDefault(); checkHit(); }
        });
        window.addEventListener('keyup', (e) => { 
            if(keys.hasOwnProperty(e.key)) keys[e.key] = false; 
        });

        function update() {
            if (gameMode === 'basic') {
                // Constant vertical bounce
                posY += speed * direction;
                if (Math.abs(posY) >= maxLimit) direction *= -1;
            } 
            else if (gameMode === 'free') {
                // Physics-based smooth movement
                if (keys.w || keys.ArrowUp) velocity -= acceleration;
                if (keys.s || keys.ArrowDown) velocity += acceleration;
                
                velocity *= friction; // Apply friction
                posY += velocity;

                // Wall bounce for Free Mode
                if (posY > maxLimit) { posY = maxLimit; velocity *= -0.5; }
                if (posY < -maxLimit) { posY = -maxLimit; velocity *= -0.5; }
            }

            indicator.style.transform = `translate(-50%, -50%) translateY(${posY}px)`;
            requestAnimationFrame(update);
        }

        function checkHit() {
            // Hit logic based on center-line
            if (posY < 0) {
                triggerHit(snare);
            } else {
                triggerHit(kick);
            }
        }

        function triggerHit(sound) {
            score += 10;
            scoreDisplay.innerText = score;
            sound.currentTime = 0;
            sound.play();

            // Polish the flash
            indicator.style.filter = "brightness(2) scale(1.1)";
            setTimeout(() => {
                indicator.style.filter = "brightness(1) scale(1)";
            }, 100);
        }

        document.getElementById('game-circle').addEventListener('mousedown', (e) => {
            e.preventDefault();
            checkHit();
        });
    </script>
</div>
<?php
    include '../src/components/footer.php';
?>