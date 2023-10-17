function typeWriter() {
    if (index < text.length) {
        document.querySelector(".TextDiv").innerHTML += text.charAt(index);
        index++;
        setTimeout(typeWriter, 5); // Delay between each character
    }
    else
    {   setTimeout(function (){
        isTypingInProgress = false
        index = 0
        document.querySelector(".TextDiv").innerHTML = ""
    }, 2000) // Do nothing and wait 3 seconds 

    }
}


//Vars initialization
//Texts
const text = "Horus joined your team !"

let index = 0;
let isTypingInProgress = false;

const mp3FilePath = '/sfx/typewriter.mp3';
var audio = new Audio(mp3FilePath);

//query selectors
let range = document.querySelector("#volume")
let rangeValue = document.querySelector("#volume").value
let ephemeral = document.querySelectorAll(".ephemeral")

//eventListeners

document.querySelector('#mute').addEventListener('click', function() {
    if (audio.muted == false)
    {
        audio.muted = true; // Unmute the audio
        audio.play();
    }
    else
    {
        audio.muted = false; // Unmute the audio            
    }
});

volume.addEventListener('input', function() {
    rangeValue = document.querySelector("#volume").value
    audio.volume = (rangeValue / 100)
    console.log(rangeValue);
});

document.addEventListener('keyup', choiceHorus);
