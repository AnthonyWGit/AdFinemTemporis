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
function typeWriter2() {
    if (index < text2.length) {
        document.querySelector(".TextDiv").innerHTML += text2.charAt(index);
        index++;
        setTimeout(typeWriter2, 1); // Delay between each character
    }
    else
    {   setTimeout(function (){
        isTypingInProgress = false
        index = 0
        document.querySelector(".TextDiv").innerHTML = ""
        $('.centerTextBox').show();
        document.querySelector(".textContent").innerHTML = ""
        typeTextChunk2()
    }, 2000) // Do nothing and wait 2 seconds 

    }
}

function typeWriter3() {
    if (index < text3.length) {
        
        document.querySelector(".TextDiv").innerHTML += text3.charAt(index);
        index++;
        setTimeout(typeWriter3, 1); // Delay between each character
    }
    else
    {   setTimeout(function (){
        isTypingInProgress = false
        index = 0
        document.querySelector(".TextDiv").innerHTML = ""
        document.querySelector(".textContent").innerHTML = ""
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

  function typeTextChunk2() 
  {
    console.log("next")
    currentCharIndex = 0;
    currentChunkIndex = 0;
    currentIndex = 0
    maxCharacters = calculateMaxCharacters(textBox);
    console.log(textToDisplay2)
    console.log(maxCharacters)
    textChunks = breakTextIntoChunks(textToDisplay2, maxCharacters)

    if (currentChunkIndex < textChunks.length) 
    {
        var currentChunk = textChunks[currentChunkIndex];
        textContent.innerHTML = currentChunk; // Set the whole chunk at once
        console.log(currentChunkIndex)
        dialogPassed = 1
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
  
//jQuery 

$(document).ready(function() {
    // Hide the centerTextBox when the document is ready because we want to display X has joined your team ! 
    $('.centerTextBox').hide();

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
var jsVar = $(".TextDiv").data("var");
//Texts
let text = jsVar + " joined your team !"
let text2 = "Some screams are heard, far away, lost in the void. They echo through nothing."
let text3 = "You are walking with your new companion. He makes some great good company. Shh, something is comming !"
let textToDisplay = "I didn't think you would be a birdie person. I... am quite surprised. Maybe you wonder why you are here now..."
let textToDisplay2 = "I'll explain to you soon, in time. But for now, let's join our forces together. You'll need me."

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


// test with long text
// let textToDisplay = "I didn't think you would be a birdie person. Expect the others to be pretty much mad. We don't have much time, let's press forward." +
// "I didn't think you would be a birdie person. Expect the others to be pretty much mad. We don't have much time, let's press forward."
// +
// "I didn't think you would be a birdie person. Expect the others to be pretty much mad. We don't have much time, let's press forward."
// +
// "I didn't think you would be a birdie person. Expect the others to be pretty much mad. We don't have much time, let's press forward."
// +"I didn't think you would be a birdie person. Expect the others to be pretty much mad. We don't have much time, let's press forward."
// +"I didn't think you would be a birdie person. Expect the others to be pretty much mad. We don't have much time, let's press forward."
// +"I didn't think you would be a birdie person. Expect the others to be pretty much mad. We don't have much time, let's press forward."
// +"I didn't think you would be a birdie person. Expect the others to be pretty much mad. We don't have much time, let's press forward."
// +"I didn't think you would be a birdie person. Expect the others to be pretty much mad. We don't have much time, let's press forward."
// +"I didn't think you would be a birdie person. Expect the others to be pretty much mad. We don't have much time, let's press forward."

// Function to handle Spacebar key press for scrolling
//eventListeners

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
        else if (currentChunkIndex == textChunks.length - 1)
        {
            if(dialogPassed == 0)
            {
                $('.centerTextBox').hide();
                typeWriter2()                
            }
            else if (dialogPassed == 1)
            {
                $('.centerTextBox').hide();
                typeWriter3()
            }
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
