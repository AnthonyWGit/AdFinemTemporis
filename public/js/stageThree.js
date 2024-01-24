$(document).ready(function() {

    $(".centerTextBox").hide();

    function typeWriter() {
        if (index < walkingText.length) {
            $(".texting").append(walkingText.charAt(index))
            index++
            setTimeout(typeWriter, 25); // Delay between each character
        }
        else
        {   setTimeout(function (){
            isTypingInProgress = false
            index = 0
            $(".texting").text("")
            typeWriter2()
        }, 2000) // Do nothing and wait 3 seconds 
        }
    }
    
    function typeWriter2() {
        if (index < walkingText2.length) {
            $(".texting").append(walkingText2.charAt(index))
            index++
            setTimeout(typeWriter2, 25); // Delay between each character
        }
        else
        {   setTimeout(function (){
            isTypingInProgress = false
            index = 0
            $(".texting").text("")
            typeWriter3()
        }, 2000) // Do nothing and wait 3 seconds 
        
        }
    }
    
    function typeWriter3() {
        if (index < walkingText3.length) {
            $(".texting").append(walkingText3.charAt(index))
            index++
            setTimeout(typeWriter3, 25) // Delay between each character
        }
        else
        {   setTimeout(function (){
            isTypingInProgress = false
            index = 0
            $(".texting").text("")
            $(".centerTextBox").show()
            isScrolling = false
            dialog()
        }, 2000) // Do nothing and wait 3 seconds 
        
        }
    }

    function dialog()
    {
        console.log($(".TextDiv").attr('data-var'))
        speakerBox.append($(".TextDiv").attr('data-var'))
        maxCharacters = calculateMaxCharacters(textBox)
        textChunks = breakTextIntoChunks(companionText, maxCharacters);
        typeTextChunk()
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
  function breakTextIntoChunks(companionText, chunkSize) {
    let chunks = [];
    while (currentIndex < companionText.length) {
        let chunk = companionText.substring(currentIndex, currentIndex + chunkSize);

        if (currentIndex + chunkSize < companionText.length) {
            const lastSpaceIndex = chunk.lastIndexOf(' ');
            if (lastSpaceIndex !== -1) {
                chunk = chunk.substring(0, lastSpaceIndex);
                currentIndex += lastSpaceIndex + 1;
            } else {
                currentIndex += chunkSize;
            }
        } else {
            currentIndex = companionText.length;
        }
        chunks.push(chunk);
    }
    return chunks;
}

    var index = 0
    let isTypingInProgress = true;
    let isScrolling = true;
    let currentChunkIndex = 0;
    let currentCharIndex = 0;   
    let currentIndex = 0;

    var textBox = document.querySelector('.textBox');
    var textContent = document.querySelector('.textContent')
    var speakerBox = $(".speakerBox")
    walkingText = "You follow the path ahead."
    walkingText2 = "The road is quite long. In a weird sense, you don't feel tired though. As if it was all a dream."
    walkingText3 = "The opaque curtain envelopping you is peirced sparsely as you walk by, letting small" + 
    " fragments of orange light shine the way ahead."
    $('.TextDiv').append('<p class="texting"> </p>')
    companionText = ""
    if ($(".TextDiv").attr('data-var') == "Chernobog")
    {
        companionText = "cadanzdna;kznd;a zndaqndzda drrcadanzdna;kznd;azndaqnd zdadrrcadanzdna; kznd;azndaqndzdadrr" +
        "cadanzdna;kznd; azndaqndzdadrrca danzdna;kznd;azndaqndzdad rrcadanzdna;kznd;azndaqndzd adrr" +
        "cadanzdna;kznd;az ndaqndzdadrrcadanzdna;kzn d;azndaqndzd adrrcadanzdna;kz nd;azndaqndzdadrr" +
        "cadanzdna;kznd; azndaqndzda drrcadan zdna;kznd;azndaqndzdadrrcadanzdna;kznd; azndaqndzdadrr" +
        "cadanzdna;k znd;azndaqndzdadrrcadanzdna;kz nd;azndaqndzdadrrcadanzdna;kznd;azndaqndzdadrr" +
        "cadanzdn a;kznd;azndaqndzdadrrca danzdna;kznd;azndaqndzdadrrcadanzdna;kznd;az ndaqndzdadrr" 
    }
    else if ($(".TextDiv").attr('data-var') == "Horus")
    {
        companionText = "B"
    }
    else if ($(".TextDiv").attr('data-var') == "Xiuhcoatl")
    {
        companionText = "C"
    }

    let maxCharacters
    let textChunks
    console.log(textChunks)
    document.addEventListener("keydown", keyDown)
    function keyDown(event)
    {
        event.stopPropagation(); // Prevent the event from bubbling up
        debounceTimeout = setTimeout(function() { //anti spam filter
        if (!isTypingInProgress)
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
                        isTypingInProgress = true
                        document.removeEventListener("keydown", keyDown)
                        typeWriter2()                
                    }
                    else if (dialogPassed == 1)
                    {
                        $('.centerTextBox').hide();
                        isTypingInProgress = true
                        document.removeEventListener("keydown", keyDown)
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
        }
        else
        {

        }
        }, 1000)
    }

    typeWriter()

    let debounceTimeout;

})