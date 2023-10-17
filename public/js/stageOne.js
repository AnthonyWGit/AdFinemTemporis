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
        typeTextChunk()
    }, 2000) // Do nothing and wait 2 seconds 

    }
}

// Function to type a specific chunk of text
function typeTextChunk() {
    if (currentChunkIndex < textChunks.length) {
     var currentChunk = textChunks[currentChunkIndex];
      textContent.innerHTML = currentChunk; // Set the whole chunk at once
      console.log(currentChunkIndex)
    }
  }
  
  // Event listener to start typing when spacebar is pressed
  document.addEventListener('keydown', function (event) 
  {
    if (event.key === 'ArrowRight') 
    {
        if (currentChunkIndex < textChunks.length - 1) 
        {
            currentChunkIndex++;
            typeTextChunk();
        }
    } 
    else if (event.key === 'ArrowLeft') 
    {
        if (currentChunkIndex > 0) 
        {
            currentChunkIndex--;
            typeTextChunk();
        }
    }
});

//estimate the number of chars you can put in the box
function calculateMaxCharacters(textBox) {
    const computedStyle = window.getComputedStyle(textBox);
    const width = textBox.offsetWidth;
    const height = textBox.offsetHeight;
    const fontSize = parseFloat(computedStyle.fontSize);
  
    const charactersHorizontally = Math.floor(width / (fontSize )); // Adjust the factor as needed
    const charactersVertically = Math.floor(height / (fontSize));
    const totalChars = charactersHorizontally * charactersVertically
    console.log(charactersHorizontally)
    console.log(charactersVertically)
    return totalChars;
  }

  // Break your textContent into chunks : i want to go a bit past max chuckSize and not cut into a middle of a bord
  function breakTextIntoChunks(text, chunkSize) {
    const chunks = [];
    while (currentIndex < text.length) {
        let chunk = text.substring(currentIndex, currentIndex + chunkSize);

        if (currentIndex + chunkSize < text.length) {
            const lastSpaceIndex = chunk.lastIndexOf(' ');
            if (lastSpaceIndex !== -1) {
                chunk = chunk.substring(0, lastSpaceIndex);
                currentIndex += lastSpaceIndex + 1;
            } else {
                currentIndex += chunkSize;
            }
        } else {
            currentIndex = text.length;
        }

        chunks.push(chunk);
    }

    return chunks;
}
  
//jQuery 

$(document).ready(function() {
    // Hide the centerTextBox when the document is ready because we want to display X has joined your team ! 
    $('.centerTextBox').hide();

});

//Vars initialization
//Texts
var jsVar = $(".TextDiv").data("var");
let text = jsVar + " joined your team !"

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
let textContent = document.querySelector('.textContent');
let isScrolling = false;
let currentChunkIndex = 0;
let currentCharIndex = 0;
let currentIndex = 0;

let textToDisplay = "I didn't think you would be a birdie person. Expect the others to be pretty much mad. We don't have much time, let's press forward." +
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

// Function to handle Spacebar key press for scrolling

  

const maxCharacters = calculateMaxCharacters(textBox);
console.log(`Maximum characters that can fit: ${maxCharacters}`);

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


const textChunks = breakTextIntoChunks(textToDisplay, maxCharacters);
console.log(`Number of text chunks: ${textChunks.length}`);
console.log(textChunks)

typeWriter();
