function typeWriter() {
    if (index < text.length) {
        document.querySelector(".TextDiv").innerHTML += text.charAt(index);
        index++;
        setTimeout(typeWriter, 1); // Delay between each character
    }
    else
    {   setTimeout(function (){
        isTypingInProgress = false
        index = 0
        document.querySelector(".TextDiv").innerHTML = ""
        $('.centerTextBox').show();
        speakerBox.innerHTML = "Horus"
        textBox.innerHTML = "I didn't think you would be a birdie person. Expect the others to be pretty much mad. We don't have much time, let's press forward." +
        "I didn't think you would be a birdie person. Expect the others to be pretty much mad. We don't have much time, let's press forward."
        +
        "I didn't think you would be a birdie person. Expect the others to be pretty much mad. We don't have much time, let's press forward."
        +
        "I didn't think you would be a birdie person. Expect the others to be pretty much mad. We don't have much time, let's press forward."
        +"I didn't think you would be a birdie person. Expect the others to be pretty much mad. We don't have much time, let's press forward."
        +"I didn't think you would be a birdie person. Expect the others to be pretty much mad. We don't have much time, let's press forward."
        +"I didn't think you would be a birdie person. Expect the others to be pretty much mad. We don't have much time, let's press forward."
        +"I didn't think you would be a birdie person. Expect the others to be pretty much mad. We don't have much time, let's press forward."
        +"I didn't think you would be a birdie person. Expect the others to be pretty much mad. We don't have much time, let's press forward."
        +"I didn't think you would be a birdie person. Expect the others to be pretty much mad. We don't have much time, let's press forward."

    }, 2000) // Do nothing and wait 3 seconds 

    }
}

//jQuery 

$(document).ready(function() {
    // Hide the centerTextBox when the document is ready because we want to display X has joined your team ! 
    $('.centerTextBox').hide();

});

//Vars initialization
//Texts
var jsVar = $(".TextDiv").data("var");
const text = jsVar + " joined your team !"

let index = 0;
let isTypingInProgress = false;

const mp3FilePath = '/sfx/typewriter.mp3';
var audio = new Audio(mp3FilePath);

//query selectors
let range = document.querySelector("#volume")
let rangeValue = document.querySelector("#volume").value
let ephemeral = document.querySelectorAll(".ephemeral")
let textBox = document.querySelector(".textBox")
let speakerBox = document.querySelector(".speakerBox")

let textContent = document.querySelector('.text-content');
let isScrolling = false;


// Function to handle Spacebar key press for scrolling

  


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


typeWriter();
