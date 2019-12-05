const AudioContext = window.AudioContext || window.webkitAudioContext;
const audioCtx = new AudioContext();
let oscList = [];   //live playing
let oscList1 = [];  //playback
let rhythms = [];
let tempo = 120;
const lookahead = 15;
const scheduleAhead = 0.05;
let currentNote = 0;
let nextNoteTime = 0.0;
let timerID;
let musicLength = 256; //number of partials
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
    'g':[],
    'y':[],
    'h':[],
    'u':[],
    'j':[],
    'k':[],
    'o':[],
    'l':[],
    'p':[],
    ';':[]
}
//controls references each note by address since notes are objects
let notes = [
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
    },
    {
        name: "C#",
        frequency: 554.3653
    },
    {
        name: "D",
        frequency: 587.3295
    },
    {
        name: "D#",
        frequency: 622.2540
    },
    {
        name: "E",
        frequency: 659.2551
    }
];
function saveLoop(){
    //let myJson = JSON.stringify(rhythms);
    console.dir(rhythms);
}
function initRhythms(){
    for(let i=0; i<musicLength; i++){
        rhythms[i] = [];
    }
    clearRecords();
}
function nextNote(){
    const secondsPerBeat = 60.0 / tempo / 16; //64th notes
    nextNoteTime += secondsPerBeat;
    currentNote++;
    if(currentNote === musicLength){
        currentNote = 0;
    }
}
function playNote(){
    for(let note of notes){
        if(rhythms[currentNote].includes(note)){
            notePlaying(note);
        } else {
            noteNotPlaying(note);
        }
    }
}
function record(button){
    window.clearTimeout(timerID);
    if(!recording){
        button.innerHTML = "stop recording"
        for(let note of notes){
            noteNotPlaying(note);
        }
        initRhythms();
        currentNote = 0;
        clearPartials();
        drawCurrent();
        firstNote = true;
        recording = true;
        playing = false;
    } else {
        button.innerHTML = "start recording";
        for(let note of notes){
            noteNotPlaying(note);
        }
        recording = false;
    }
}
function playButton(button){
    window.clearTimeout(timerID);
    if(playing){
        button.innerHTML = "start playback";
        for(let note of notes){
            noteNotPlaying(note);
        }
        playing = false;
        currentNote = 0;
        clearPartials();
        drawCurrent();
    } else {
        button.innerHTML = "stop playback";
        nextNoteTime = audioCtx.currentTime;
        playing = true;
        looper();
    }
}
function looper(){
    while(nextNoteTime <= audioCtx.currentTime + scheduleAhead){
        if(recording){
            notes.forEach(function(note){
                if(note['pressed']){
                    rhythms[currentNote].push(note);
                    let id = String(currentNote) + String(note.frequency);
                    let record = document.getElementById(id);
                    record.dataset['recorded'] = true;
                }
            });
        } 
        if(playing){
            playNote(currentNote);
        } 
        nextNote();
    }
    clearPartials();
    drawCurrent();
    timerID = window.setTimeout(looper, lookahead);
}
function clearRecords(){
    let allPartials = document.querySelectorAll(".partial ");
    allPartials.forEach(function(partial){
        partial.dataset["recorded"] = false;
    });
}
function clearPartials(){
    let allPartials = document.querySelectorAll(".partial ");
    allPartials.forEach(function(partial){
        partial.dataset["current"] = false;
    });
}
function drawCurrent(){
    let currentPartials = document.querySelectorAll(".p"+currentNote);
    for(let partial of currentPartials){
        partial.dataset["current"] = true;
    }
}
document.addEventListener("keydown", function(event){
    if(controls[event.key]){
        notePressed(controls[event.key]);
        if(recording && firstNote){
            nextNoteTime = audioCtx.currentTime;
            currentNote = 0;
            firstNote = false;
            looper();
        } 
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
    //osc.type = 'triangle';
    osc.frequency.setValueAtTime(frequency, audioCtx.currentTime);
    osc.start(); 
    return osc;
}
window.addEventListener("load", function(){
    setupKeys();
    initRhythms();
    setupLayers();
});
function setupKeys(){
    let rightBlack = ['C','D','F','G','A'];
    let keyboard = document.querySelector(".keyboard");
    while(keyboard.firstChild){
        keyboard.removeChild(keyboard.firstChild);
    }
    Object.keys(controls).forEach(function(key, i){
        controls[key] = notes[i];
        let keyEl = document.createElement("li");
        let labelEl = document.createElement("p");
        labelEl.innerHTML = key;
        if(controls[key].name.length == 1){
            keyEl.className = "whiteKey";
            if(rightBlack.includes(controls[key].name)){
                keyEl.dataset['rightBlack'] = 'true';
            }
        } else {
            keyEl.className = "blackKey";
        }
        if(controls[key].name)
        keyEl.id = controls[key].frequency;
        keyEl.append(labelEl);
        keyboard.appendChild(keyEl);
    });
}
function setupLayers(){
    let layers = document.querySelector(".layers");
    while(layers.firstChild){
        layers.removeChild(layers.firstChild);
    }
    for(let note of notes){
        let labelEl = document.createElement('div');
        labelEl.className = "noteLabel";
        labelEl.innerHTML = note.name;
        let sequence = document.createElement('div');
        sequence.className = "sequence ";  
        sequence.prepend(labelEl);
        sequence.classList += note.frequency;
        layers.prepend(sequence);
        for(let [i, rhythm] of rhythms.entries()){
            let partial = document.createElement('div');
            partial.className = "partial ";
            partial.classList += "p"+i;
            partial.id = String(i)+String(note.frequency);
            sequence.appendChild(partial);
        }
    }
}