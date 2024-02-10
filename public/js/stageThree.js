$(document).ready(function() {

        //________________________________________AUDIO_______________________________________
    //trying to load audio as soon as possible 
    const mp3FilePath ='/sfx/chil-adventure.mp3';
    var audio = new Audio(mp3FilePath);
    audio.preload = 'auto';
    audio.volume = localStorage.getItem('volume');
    localStorage.setItem('currentTime', audio.currentTime);
    if (!audio.muted)
    {
        audio.currentTime = 0;
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

    $('.sun').hide()
    $(".centerTextBox").hide();

    function typeWriter() {
        if (index < walkingText.length) {
            $(".texting").append(walkingText.charAt(index))
            index++
            setTimeout(typeWriter, 12); // Delay between each character
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
            setTimeout(typeWriter2, 12); // Delay between each character
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
            setTimeout(typeWriter3, 12) // Delay between each character
        } else {
            setTimeout(function() {
                    index = 0
                    $('.sun').show()
                    $(".texting").text("")
                    $(".centerTextBox").show()
                    dialog()
                }, 2000) // Do nothing and wait 3 seconds 
        }
    }

    function typeWriter4() {
        if (index < walkingText4.length) {
            $(".texting").append(walkingText4.charAt(index))
            index++
            setTimeout(typeWriter4, 12) // Delay between each character
        } else {
            setTimeout(function() {
                    index = 0
                    $(".texting").text("")
                    $(".textContent").text("")
                    isTypingInProgress = false
                    $('.centerTextBox').show();
                    typeTextChunk2();
                }, 2000) // Do nothing and wait 3 seconds 
        }
    }


    function dialog() {
        console.log($(".TextDiv").attr('data-var'))
        speakerBox.append($(".TextDiv").attr('data-var'))
        maxCharacters = calculateMaxCharacters(textBox)
        textChunks = breakTextIntoChunks(companionText, maxCharacters);
        isTypingInProgress = false;
        typeTextChunk()
    }

    // Function to type a specific chunk of text
    function typeTextChunk() {
        if (currentChunkIndex < textChunks.length) {
            var currentChunk = textChunks[currentChunkIndex];
            textContent.innerHTML = currentChunk; // Set the whole chunk at once
        }
    }

    function typeTextChunk2() {
        console.log("next")
        currentCharIndex = 0;
        currentChunkIndex = 0;
        currentIndex = 0
        maxCharacters = calculateMaxCharacters(textBox);
        textChunks = breakTextIntoChunks(warningText, maxCharacters)
        if (currentChunkIndex < textChunks.length) {
            var currentChunk = textChunks[currentChunkIndex];
            textContent.innerHTML = currentChunk; // Set the whole chunk at once
            console.log(currentChunkIndex, 'replace next')
            isTypingInProgress = false
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
    walkingText = "You follow the path ahead."
    walkingText2 = "The road is quite long. In a weird sense, you don't feel tired though. As if it was all a dream."
    walkingText3 = "The opaque curtain envelopping you is peirced sparsely as you walk by, letting small" +
        " fragments of orange light shine the way ahead."
    walkingText4 = 'You wander through this new place. The place opens of a bit, the the corridor morphing into a' +
        ' large field.'
    $('.TextDiv').append('<p class="texting"> </p>')
    companionText = ""
    if ($(".TextDiv").attr('data-var') == "Chernobog") {
        companionText = "This is weird. Only a few of my nature have seen it. The appeareance of those orange lights. We dwell in the dark, nurtured by Human thoughts." +
            " By the way, i'm Chernobog. People in your world revered me as their Death God. But someone else took its place..."
    } else if ($(".TextDiv").attr('data-var') == "Horus") {
        companionText = "Rejoice ! This is a sign that the world is moving ! We usually don't see those... We are darkness dwellers." +
            ' Even those who are made of light. But the balance is shifting, it seems. By the way, i\'m Horus ! Nice to' +
            " meet you ! "
    } else if ($(".TextDiv").attr('data-var') == "Xiuhcoatl") {
        companionText = "Unusual. The sky is burning, as if the impostor somehow woke up. I didn't say before, but i'm" +
            " Xiuhcotal, if you're wondering. There was a change in our world, some ages ago, or whatever time you count in." +
            "a new One, bringing light. Claiming to be all of us in One. A beeing encompassing all..."
    }
    warningText = "There ! Something is comming."

    let maxCharacters
    let textChunks
    console.log(textChunks)
    document.addEventListener("keydown", keyDown)
    textBox.addEventListener('click', keyDown)
    let debounceTimeout;
    function keyDown(event) {
        event.stopPropagation(); // Prevent the event from bubbling up
        debounceTimeout = setTimeout(function() { //anti spam filter
            if (!isTypingInProgress) {
                if (event.key === 'ArrowRight' || event.type === 'click') {
                    if (currentChunkIndex < textChunks.length - 1) {
                        currentChunkIndex++;
                        typeTextChunk();
                    } else if (currentChunkIndex == textChunks.length - 1) {
                        if (dialogPassed == 0) {
                            $('.centerTextBox').hide();
                            isTypingInProgress = true;
                            dialogPassed = 1;
                            typeWriter4();
                        } else if (dialogPassed == 1) {
                            localStorage.setItem('currentTime', audio.currentTime);
                            window.location.replace("/game/secondCombat");
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