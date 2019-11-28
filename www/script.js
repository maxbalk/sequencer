const AudioContext = window.AudioContext || window.webkitAudioContext;
const audioCtx = new AudioContext();
let oscList = [];
let controls = [65,83,68,70,74,75,76,186];
let octave = [
    { 
        name: "C",
        frequency: 261.6256
    },
    {
        name: "D",
        frequency: 293.6648
    },
    {
        name: "E",
        frequency: 329.6276	
    },
    {
        name: "F",
        frequency: 349.2282
    },
    {
        name: "G",
        frequency: 391.9954
    },
    {
        name: "A",
        frequency: 440
    },
    {
        name: "B",
        frequency: 493.8833
    },
    {
        name: "C",
        frequency: 523.2511
    }
];

window.addEventListener("load", function(){
    generateKeys();
});
document.addEventListener("keydown", function(event){
    notePressed(octave[controls.indexOf(event.keyCode)]);
});
document.addEventListener("keyup", function(event){
    noteReleased(octave[controls.indexOf(event.keyCode)]);
});
function generateKeys(){
    let keyboard = document.getElementById("keyboard");
    for(let note of octave){
        keyEl = document.createElement("div");
        keyEl.innerHTML = note.name
        keyEl.className = "key";
        keyEl.dataset["note"] = note.name;
        keyEl.dataset["frequency"] = note.frequency;
        keyboard.appendChild(keyEl);
    }
}

function notePressed(note){
    if(!note['pressed']){
        note['pressed'] = true;
        oscList[note.name] = playTone(note.frequency);
    }
}

function noteReleased(note){
    if(note['pressed']){
        note['pressed'] = false;
        oscList[note.name].stop();
        oscList[note.name] = null;
    }
}

function playTone(frequency){
    let osc = audioCtx.createOscillator();
    osc.connect(audioCtx.destination);
    osc.frequency.setValueAtTime(frequency, audioCtx.currentTime);
    osc.start(); 
    return osc;
}
