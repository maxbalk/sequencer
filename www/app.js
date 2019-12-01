const AudioContext = window.AudioContext || window.webkitAudioContext;
const audioCtx = new AudioContext();
let oscList = [];
let oscList1 = [];
let rhythms = [];
let tempo = 120;
const lookahead = 25.0;
const scheduleAhead = 0.1;
let currentNote = 0;
let nextNoteTime = 0.0;
let timerID;
let musicLength = 32;
let recording = false;
let playing = false;
let firstNote = false;
let controls = {
    'a':[],
    'w':[],
    's':[],
    'e':[],
    'd':[],
    'f':[],
    't':[],
    'j':[],
    'i':[],
    'k':[],
    'o':[],
    'l':[],
    ';':[]
}
let octave = [
    {
        name: "C",
        frequency: 261.6256
    },
    {
        name: "C#",
        frequency: 277.1826
    },
    {
        name: "D",
        frequency: 293.6648
    },
    {
        name: "D#",
        frequency: 311.1270
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
        name: "F#",
        frequency: 369.9944
    },
    {
        name: "G",
        frequency: 391.9954
    },
    {
        name: "G#",
        frequency: 415.3047
    },
    {
        name: "A",
        frequency: 440
    },
    {
        name: "A#",
        frequency: 466.1638
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
function initRhythms(){
    for(let i=0; i<musicLength; i++){
        rhythms[i] = [];
    }
}
function nextNote(){
    const secondsPerBeat = 60.0 / tempo / 4;
    nextNoteTime += secondsPerBeat;
    currentNote++;
    if(currentNote === musicLength){
        currentNote = 0;
    }
}
function playNote(beatNumber){
    for(let note of octave){
        if(rhythms[currentNote].includes(note)){
            notePlaying(note);
        } else {
            noteNotPlaying(note);
        }
    }
}
function record(){
    if(!recording){
        initRhythms();
        firstNote = true;
        recording = true;
        playing = false;
    } else {
        window.clearTimeout(timerID);
        recording = false;
    }
}
function playButton(){
    if(playing){
        for(let note of octave){
            noteNotPlaying(note);
        }
        window.clearTimeout(timerID);
        playing = false;
        currentNote = 0
    } else {
        if(rhythms[0]){
            nextNoteTime = audioCtx.currentTime;
            currentNote = 0;
            playing = true;
            recording = false;
            looper();
        } 
    }
}
function looper(){
    while(nextNoteTime < audioCtx.currentTime + scheduleAhead){
        console.dir(rhythms[currentNote]);
        if(playing){
            playNote(currentNote);
        }
        nextNote();
    }
    timerID = window.setTimeout(looper, lookahead);
}
document.addEventListener("keydown", function(event){
    if(controls[event.key]){
        if(recording){
            if(!rhythms[currentNote].includes(controls[event.key])){
                rhythms[currentNote].push(controls[event.key]);
            }
            if(firstNote){
                nextNoteTime = audioCtx.currentTime;
                currentNote = 0;
                firstNote = false;
                looper();
            }  
        } 
        notePressed(controls[event.key]);
    }
});
document.addEventListener("keyup", function(event){
    if(controls[event.key]){
        noteReleased(controls[event.key]);  
    }
});
function notePressed(note){
    if(!note['pressed']){
        note['pressed'] = true;
        oscList[note.frequency] = playTone(note.frequency);
        document.getElementById(note.frequency).dataset["pressed"] = "true";
    }
}
function notePlaying(note){
    if(!note['playing']){
        note['playing'] = true;
        oscList1[note.frequency] = playTone(note.frequency);
    }
}
function noteReleased(note){
    if(note['pressed']){
        note['pressed'] = false;
        oscList[note.frequency].stop();
        oscList[note.frequency] = null;
        document.getElementById(note.frequency).dataset["pressed"] = "false";
    }
}
function noteNotPlaying(note){
    if(note['playing']){
        note['playing'] = false;
        oscList1[note.frequency].stop();
        oscList1[note.frequency] = null;
    }
}
function playTone(frequency){
    let osc = audioCtx.createOscillator();
    osc.connect(audioCtx.destination);
    osc.type = 'triangle';
    osc.frequency.setValueAtTime(frequency, audioCtx.currentTime);
    osc.start(); 
    return osc;
}
window.addEventListener("load", function(){
    generateKeys();
});
function generateKeys(){
    let keyboard = document.querySelector(".keyboard");
    Object.keys(controls).forEach(function(key, i){
        controls[key] = octave[i];
        let keyEl = document.createElement("div");
        let labelEl = document.createElement("div");
        labelEl.innerHTML = key;
        keyEl.innerHTML = controls[key].name;
        if(controls[key].name.length == 1){
            keyEl.className = "whiteKey";
        } else {
            keyEl.className = "blackKey";
        }
        keyEl.id = controls[key].frequency;
        keyEl.appendChild(labelEl);
        keyboard.appendChild(keyEl);
    });
}