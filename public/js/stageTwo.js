
function typeWriter() {
        setTimeout(function ()
        {
            $('.centerTextBox').show();
            speakerBox.innerHTML = jsVar
            typeTextChunk()
    }, 2000) // Do nothing and wait 2 seconds 
}

// Function to type a specific chunk of text
function typeTextChunk() {
    if (currentChunkIndex < textChunks.length) {
     var currentChunk = textChunks[currentChunkIndex];
      textContent.innerHTML = currentChunk; // Set the whole chunk at once
      console.log(currentChunkIndex)
    }
  }

//estimate the number of chars you can put in the box
function calculateMaxCharacters(textBox) {
    let computedStyle = window.getComputedStyle(textBox);
    let width = textBox.offsetWidth;
    let height = textBox.offsetHeight;
    let fontSize = parseFloat(computedStyle.fontSize);
    let charactersHorizontally = Math.floor(width / (fontSize )); // Adjust the factor as needed
    let charactersVertically = Math.floor(height / (fontSize));
    let totalChars = charactersHorizontally * charactersVertically
    console.log(charactersHorizontally)
    console.log(charactersVertically)
    return totalChars;
  }

  // Break your textContent into chunks : i want to go a bit past max chuckSize and not cut into a middle of a bord
  function breakTextIntoChunks(text, chunkSize) {
    let chunks = [];
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

function whenArrowPressed(event) 
{
    if (event.key === 'ArrowRight') 
    {
        if (currentChunkIndex < textChunks.length - 1) 
        {
            currentChunkIndex++;
            typeTextChunk();
        }
        else 
        {
            document.removeEventListener('keydown', whenArrowPressed)
            $.ajax({
                url: "/ajaxe/setStage/9999",
                method: "GET",
            }).done(function()
            {
                window.location.replace('/game/hub')
            })
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
}

//jQuery 

$(document).ready(function() {
    // Hide the centerTextBox when the document is ready because we want to display X has joined your team ! 
    $('.centerTextBox').hide();
    setTimeout(function() {
        $('.toHide').remove();
    }, 5000); // moved the closing parenthesis here
    typeWriter();
});

//Vars initialization
// Other : soound 
const mp3FilePath = '/sfx/typewriter.mp3';
var audio = new Audio(mp3FilePath);

//query selectors
let range = document.querySelector("#volume")
let rangeValue = document.querySelector("#volume").value
let ephemeral = document.querySelectorAll(".ephemeral")
let textBox = document.querySelector(".textBox")
let speakerBox = document.querySelector(".speakerBox")
let textContent = document.querySelector('.textContent');
let dialogPassed = 0;
let jsVar = $("#data").data("var");
console.log(jsVar)
//Texts
let text = ''
let text2 = ''
let text3 = ""
let textToDisplay = ''
let textToDisplay2 = ''

if (jsVar == "Horus")
{
    textToDisplay = "That was just a warm-up. More dangers lie ahead. But we're not in a rush, from now on we can explore our surrondings to get stronger."
}
else if(jsVar == "Chernobog")
{
    textToDisplay = "And so it goes back where it belongs, to nothing. Each time the clock ticks, we engulf ourself in this place even more. We might meet some "
    +"more along the way, but we can backtrack to slain more of those weaklings to grow stronger."
}
else if (jsVar == "Xiuhcoatl")
{
    textToDisplay = "What a weak creature. Let's not waste too much time, but we are not in a rush aswell. If you feel we need to get stronger, we can walk back"
    + " . I fear more will come."
}

let index = 0;
let isTypingInProgress = false;
let isScrolling = false;
let currentChunkIndex = 0;
let currentCharIndex = 0;   
let currentIndex = 0;
let maxCharacters = calculateMaxCharacters(textBox);
console.log(`Maximum characters that can fit: ${maxCharacters}`);
let textChunks = breakTextIntoChunks(textToDisplay, maxCharacters);
console.log(`Number of text chunks: ${textChunks.length}`);
console.log(textChunks)
  // Event listener to start typing when spacebar is pressed
document.addEventListener('keydown', whenArrowPressed);
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



