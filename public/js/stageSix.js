$(document).ready(function()
{
    
    //________________________________________AUDIO_______________________________________
    //trying to load audio as soon as possible 
    const mp3FilePath ='/sfx/stage6.mp3';
    var audio = new Audio(mp3FilePath);
    audio.volume = localStorage.getItem('volume');
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
    function moveToCredits()
    {
        $('#data-2').append('<a href="/game/credits" class="endButton">The End</a> ')
        $('#data-2').removeClass('hidden')
    }
    function typeWriter() {
        if (index < walkingText.length) {
            $(".texting").append(walkingText.charAt(index))
            index++
            setTimeout(typeWriter, 25); // Delay between each character
        } else {
            setTimeout(function() {
                    index = 0
                    isTypingInProgress = false
                    $(".texting").text("")
                    $(".centerTextBox").show()
                    typeTextChunk()
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
                    moveToCredits()
                }, 2000) // Do nothing and wait 3 seconds 
        }
    }

    // Function to type a specific chunk of text
    function typeTextChunk() {
        speakerBox.append($(".TextDiv").attr('data-var'))
        maxCharacters = calculateMaxCharacters(textBox)
        console.log(maxCharacters)
        textChunks = breakTextIntoChunks(companionText, maxCharacters);
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
    let dialogPassed = 0;
    let isTypingInProgress = true;
    let currentChunkIndex = 0;
    let currentCharIndex = 0;
    let currentIndex = 0;

    var textBox = document.querySelector('.textBox');
    var textContent = document.querySelector('.textContent')
    var speakerBox = $(".speakerBox")
    let walkingText = "Dust settles. You take your time to breath. This sea of ink around you... It faints..."
    let walkingText2 = "You wave at the one who stand with you."
    let walkingText3 = "You look at the horizon. Waves come and crash on the shore with violence. But you see a door"
    + " in the distance. You run on a ray of light."
    $('#data').append('<p class="texting"> </p>')
    let companionText = ""
    let companionText2 = ""
    if ($(".TextDiv").attr('data-var') == "Chernobog") {
        companionText = "This is it. Pleasure to have met you, but i shall no stray much longer. I'm not supposed"
        + " to roam in this part of Humans hidden mind. I have a feeling we will again in the future." +
        " Until then, good bye."
    } else if ($(".TextDiv").attr('data-var') == "Horus") {
        companionText = "This area this is bright. Suits me better, you see. I was going to get blind swimming in"
        + "this black abyss, i swear ! I wish we could take a walk together here, but i feel we've got little time..."
        + "Go on. I'll have you in my mind, 'till we meet again."
    } else if ($(".TextDiv").attr('data-var') == "Xiuhcoatl") {
        companionText = "We turned this thing into ashes. Nicely done ! If only we had a little bit of time to" +
        " rejoice or reminisce when we met. Time flew, huh. Well, i'm not that sad, something tells me we are" +
        "going to meet once again, some time. Now, rush, this place is not stable and it's gonna crash in a minute !"
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
                            dialogPassed = 1
                            $('.centerTextBox').hide()
                            typeWriter2()
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