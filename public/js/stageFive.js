$(document).ready(function()
{
                //________________________________________AUDIO_______________________________________
    //trying to load audio as soon as possible 
    const mp3FilePath ='/sfx/firedance.mp3';
    var audio = new Audio(mp3FilePath);
    audio.preload = 'auto';
    audio.volume = localStorage.getItem('volume');
    localStorage.setItem('currentTime', audio.currentTime);
    if (!audio.muted)
    {
        audio.play()
    }
    console.log(audio.volume, audio.muted);
    document.querySelector('#mute').addEventListener('click', function() {
        if (audio.muted == false)
        {
            audio.muted = true; // Unmute the audio
            audio.play();
            localStorage.setItem('volume', audio.volume)
            localStorage.setItem('muted', "1")
        }
        else
        {
            audio.muted = false; // Unmute the audio       
            localStorage.setItem('muted', "0")     
        }
    });

    volume.addEventListener('input', function() {
        rangeValue = document.querySelector("#volume").value
        audio.volume = (rangeValue / 100)
        localStorage.setItem('volume', audio.volume)
        console.log(rangeValue);
    });
//________________________________________ENDAUDIO____________________________________

    $('.centerTextBox').hide()
    function moveToFinale()
    {
        window.location.replace("/game/finalBattle")
    }
    function typeWriter() {
        if (index < walkingText.length) {
            $(".texting").append(walkingText.charAt(index))
            index++
            setTimeout(typeWriter, 25); // Delay between each character
        } else {
            setTimeout(function() {
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
        } else {
            setTimeout(function() {
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
        } else {
            setTimeout(function() {
                    index = 0
                    isTypingInProgress = false;
                    $(".texting").text("")
                    $(".centerTextBox").show()
                    speakerBox.append($(".TextDiv").attr('data-var'))
                    maxCharacters = calculateMaxCharacters(textBox)
                    console.log(maxCharacters)
                    textChunks = breakTextIntoChunks(companionText, maxCharacters);
                    typeTextChunk()
                }, 2000) // Do nothing and wait 3 seconds 
        }
    }

    function typeWriter4() {
        if (index < walkingText4.length) {
            $(".texting").append(walkingText4.charAt(index))
            index++
            setTimeout(typeWriter4, 25) // Delay between each character
        } else {
            setTimeout(function() {
                    index = 0
                    $(".texting").text("")
                    $(".textContent").text("")
                    isTypingInProgress = false
                    moveToFinale()
                }, 2000) // Do nothing and wait 3 seconds 
        }
    }

    // Function to type a specific chunk of text
    function typeTextChunk() {
        if (currentChunkIndex < textChunks.length) {
            var currentChunk = textChunks[currentChunkIndex];
            textContent.innerHTML = currentChunk; // Set the whole chunk at once
        }
    }

    //estimate the number of chars you can put in the box
    function calculateMaxCharacters(textBox) {
        let computedStyle = window.getComputedStyle(textBox);
        let width = textBox.offsetWidth;
        let height = textBox.offsetHeight;
        let fontSize = parseFloat(computedStyle.fontSize);

        let charactersHorizontally = Math.floor(width / (fontSize)); // Adjust the factor as needed
        let charactersVertically = Math.floor(height / (fontSize));
        let totalChars = (charactersHorizontally * charactersVertically) * 0.8
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
    let dialogPassed = 0;
    let isTypingInProgress = true;
    let currentChunkIndex = 0;
    let currentCharIndex = 0;
    let currentIndex = 0;

    var textBox = document.querySelector('.textBox');
    var textContent = document.querySelector('.textContent')
    var speakerBox = $(".speakerBox")
    let walkingText = "The prairie ends narrowing a bit, branching paths beeing blocked by mountains and rocks."
    + " You find a way leading to a dense forest."
    let walkingText2 = "Going forward becomes more and more painfull. Vines and branches thick as great trees" + 
    " slowing you. But suddenly, you feel fresh air, making you fast and slick as the wind."
    let walkingText3 = "You see an exit. An unreal scene lies upon you, a cosmic horror devouring a beach."
    let walkingText4 = 'You rush to battle, envigorated with courage !'
    $('.TextDiv').append('<p class="texting"> </p>')
    let companionText = ""
    let companionText2 = ""
    if ($(".TextDiv").attr('data-var') == "Chernobog") {
        companionText = "The End of the road. The final Obstacle. One final step before going where you came from."
        + " Don't hold back."
    } else if ($(".TextDiv").attr('data-var') == "Horus") {
        companionText = "I'm going to miss you. That was surprisingly fun... This thing is going to eat your world."
        + "let's end it, here and now !"
    } else if ($(".TextDiv").attr('data-var') == "Xiuhcoatl") {
        companionText = "And so we nearly reach the end. Just one last challenge. After that, well, sadly we would have"
        " to say our farewells. For now, let's get it together, one last time."
    }

    let maxCharacters
    let textChunks
    document.addEventListener("keydown", keyDown)
    let debounceTimeout;
    function keyDown(event) {
        event.stopPropagation(); // Prevent the event from bubbling up
        debounceTimeout = setTimeout(function() { //anti spam filter
            if (!isTypingInProgress) {
                if (event.key === 'ArrowRight') {
                    if (currentChunkIndex < textChunks.length - 1) {
                        currentChunkIndex++;
                        typeTextChunk();
                    } else if (currentChunkIndex == textChunks.length - 1) {
                        if (dialogPassed == 0) {
                            isTypingInProgress = true;
                            dialogPassed = 1;
                            $('.centerTextBox').hide()
                            typeWriter4();
                        }
                    }
                } else if (event.key === 'ArrowLeft') {
                    if (currentChunkIndex > 0) {
                        currentChunkIndex--;
                        typeTextChunk();
                    }
                }
            }
        }, 1000);
    }
    typeWriter()
})