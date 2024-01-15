function typeWriter() {
    if (index < text.length) {
        document.querySelector(".TextDiv").innerHTML += text.charAt(index);
        index++;
        setTimeout(typeWriter, 25); // Delay between each character
    }
    else
    {   setTimeout(function (){
        isTypingInProgress = false
        index = 0
        document.querySelector(".TextDiv").innerHTML = ""
        typeWriter2()
    }, 2000) // Do nothing and wait 3 seconds 
    }
}

function typeWriter2() {
    if (index < text2.length) {
        document.querySelector(".TextDiv").innerHTML += text2.charAt(index);
        index++;
        setTimeout(typeWriter2, 25); // Delay between each character
    }
    else
    {   setTimeout(function (){
        isTypingInProgress = false
        index = 0
        typeWriter3()
    }, 2000) // Do nothing and wait 3 seconds 
    
    }
}

function typeWriter3() {
    if (index < text3.length) {
        document.querySelector("#part2").innerHTML += text3.charAt(index);
        index++;
        setTimeout(typeWriter3, 50); // Delay between each character
    }
    else
    {   setTimeout(function (){
        isTypingInProgress = false
        index = 0
        typeWriter4()
    }, 2000) // Do nothing and wait 3 seconds 
    
    }
}

function typeWriter4() {
    if (index < text4.length) {
        document.querySelector("#part3").innerHTML += text4.charAt(index);
        index++;
        setTimeout(typeWriter4, 50); // Delay between each character
    }
    else
    {   setTimeout(function (){
        isTypingInProgress = false
        index = 0
        typeWriter5()
    }, 2000) // Do nothing and wait 3 seconds 
    
    }
}

function typeWriter5() {
    if (index < text5.length) {
        document.querySelector("#part4").innerHTML += text5.charAt(index);
        index++;
        setTimeout(typeWriter5, 50); // Delay between each character
    }
    else
    {   setTimeout(function (){
        isTypingInProgress = false
        audio.pause()
        audio.currentTime = 0; //stopping audio
        document.querySelector("#part2").appendChild(createButtonHorus)
        document.querySelector("#part3").appendChild(createButtonXiuhcoatl)
        document.querySelector("#part4").appendChild(createButtonChernobog)

    }, 2000) // Do nothing and wait 3 seconds 
        
    }
}

function choiceHorus()
{
    document.removeEventListener('keyup', choiceChernobog);
    window.location.replace("/game/choice/Horus");
}

function choiceXiuhcoatl()
{
    document.removeEventListener('keyup', choiceChernobog);
    window.location.replace("/game/choice/Xiuhcoatl");
}

function choiceChernobog()
{
    document.removeEventListener('keyup', choiceChernobog);
    window.location.replace("/game/choice/Chernobog");
}


//Vars initialization
//Texts
let text = "Those dreams never felt so real. Night became as deep as ink. Something is happening. Somewhere, somehow." + 
"How will you shape your fate ? ";
let text2 = "A long corridor. Endless, wrapped in shadows. In the distance, three figures. To which one are you drawn to ?"
let text3 = "The first one is a radiant eagle standing on two legs. His gaze is lost into the horizon."
let text4 = "The second is a floting serpent. Ethereal, hanging in the air; suspended by time."
let text5 = "The third is barely visible. It is shrouded in darkness, blending in with its surroundings."

let index = 0;
let isTypingInProgress = false
const mp3FilePath = '/sfx/typewriter.mp3';
var audio = new Audio(mp3FilePath);

//query selectors
let range = document.querySelector("#volume")
let rangeValue = document.querySelector("#volume").value
let ephemeral = document.querySelectorAll(".ephemeral")

//create and set properties to element 
const createButtonHorus = document.createElement("button")
createButtonHorus.textContent = "Select"
createButtonHorus.setAttribute('id','choiceHorus')
createButtonHorus.addEventListener("click", choiceHorus)

const createButtonXiuhcoatl = document.createElement("button")
createButtonXiuhcoatl.textContent = "Select"
createButtonXiuhcoatl.setAttribute('id','choiceXiuhcoatl')
createButtonXiuhcoatl.addEventListener("click", choiceXiuhcoatl)

const createButtonChernobog = document.createElement("button")
createButtonChernobog.textContent = "Select"
createButtonChernobog.setAttribute('id','choiceChernobog')
createButtonChernobog.addEventListener("click", choiceChernobog)
//eventListeners
document.getElementById('yesButton').addEventListener('click', function() {
    audio.muted = false; // Unmute the audio
    audio.volume = 0.3;
    audio.play();
    ephemeral.forEach(function (element) {
        element.remove()
    }); 
    typeWriter();
});

document.getElementById('noButton').addEventListener('click', function() {
    audio.pause(); // Pause the audio
    audio.currentTime = 0; // Reset audio to the beginning
    ephemeral.forEach(function (element) {
        element.remove()
    }); 
    typeWriter();
});

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

document.addEventListener('keyup', choiceChernobog);
