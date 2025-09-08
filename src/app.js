// app.js
const sampler = new Tone.Players({
  kick: "samples/kompang1.wav",
  slap: "samples/kompang_slap.wav"
}).toDestination();

const steps = 16;
const tracks = ["kick","slap"];
// state: tracks × steps booleans
let grid = Array.from({length: tracks.length}, ()=>Array(steps).fill(false));

// build UI grid
const gridDiv = document.getElementById("grid");
tracks.forEach((t, ti)=>{
  const row = document.createElement("div");
  row.className = "row";
  for (let s=0;s<steps;s++){
    const btn = document.createElement("button");
    btn.textContent = s+1;
    btn.className="step";
    btn.onclick = ()=> {
      grid[ti][s] = !grid[ti][s];
      btn.style.opacity = grid[ti][s]?1:0.4;
    };
    row.appendChild(btn);
  }
  gridDiv.appendChild(row);
});

// schedule repeat
Tone.Transport.scheduleRepeat((time)=> {
  const step = (Math.floor(Tone.Transport.ticks / (Tone.Transport.PPQ / 4)) % steps);
  tracks.forEach((t,ti)=>{
    if (grid[ti][step]) {
      sampler.player(t).start(time);
    }
  });
}, "16n");

document.getElementById("play").onclick = async ()=> {
  await Tone.start();
  Tone.Transport.start();
};
document.getElementById("stop").onclick = ()=> Tone.Transport.stop();
document.getElementById("bpm").oninput = (e)=> Tone.Transport.bpm.value = +e.target.value;
