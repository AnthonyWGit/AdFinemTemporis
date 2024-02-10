$(document).ready(function()
{
            //________________________________________AUDIO_______________________________________
    //trying to load audio as soon as possible 
    const mp3FilePath ='/sfx/chil-adventure.mp3';
    var audio = new Audio(mp3FilePath);
    audio.preload = 'auto';
    audio.volume = localStorage.getItem('volume');
    localStorage.setItem('currentTime', audio.currentTime);
    if (!audio.muted)
    {
        audio.currentTime = parseFloat(localStorage.getItem('currentTime'));
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
    function moveToHub()
    {
        $.ajax({
            url: '/ajaxe/setStage/10000',  // The URL of the route you defined in your Symfony controller
            method: 'POST',  // Or 'POST', depending on your needs
        }).done(function()
        {
            localStorage.setItem('currentTime', audio.currentTime);
            window.location.replace("/game/hub/second")
        })
    }
    function typeWriter() {
        if (index < walkingText.length) {
            $(".texting").append(walkingText.charAt(index))
            index++
            setTimeout(typeWriter, 12); // Delay between each character
        } else {
            setTimeout(function() {
                    index = 0
                    $(".texting").text("")
                    isTypingInProgress = false;
                    $('.centerTextBox').show()
                    typeTextChunk()
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
                    $(".texting").text("")
                    $('.centerTextBox').show()
                    typeTextChunk2()
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
                    moveToHub()
                }, 2000) // Do nothing and wait 3 seconds 
        }
    }

    // Function to type a specific chunk of text
    function typeTextChunk() {
        speakerBox.append($(".TextDiv").attr('data-var'))
        maxCharacters = calculateMaxCharacters(textBox)
        textChunks = breakTextIntoChunks(companionText, maxCharacters);
        if (currentChunkIndex < textChunks.length) {
            var currentChunk = textChunks[currentChunkIndex];
            textContent.innerHTML = currentChunk; // Set the whole chunk at once
        }
    }

    function typeTextChunk2() {
        if (once)
        {
            currentCharIndex = 0;
            currentChunkIndex = 0;
            currentIndex = 0          
            once = false;
            maxCharacters = calculateMaxCharacters(textBox);
            textChunks = breakTextIntoChunks(companionText2, maxCharacters)
        }
        if (currentChunkIndex < textChunks.length) {
            var currentChunk = textChunks[currentChunkIndex];
            textContent.innerHTML = currentChunk; // Set the whole chunk at once
            isTypingInProgress = false
        }
    }

    //estimate the number of chars you can put in the box
    function calculateMaxCharacters(textBox) {
        let computedStyle = window.getComputedStyle(textBox);
        let width = textBox.offsetWidth;
        let height = textBox.offsetHeight;
        let fontSize = parseFloat(computedStyle.fontSize);

        let charactersHorizontally = Math.floor(width / fontSize); // Adjust the factor as needed
        let charactersVertically = Math.floor(height / fontSize);
        let totalChars = (charactersHorizontally * charactersVertically) * 0.75
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
    let currentIndex = 0
    let once = true
    var textBox = document.querySelector('.textBox');
    var textContent = document.querySelector('.textContent')
    var speakerBox = $(".speakerBox")
    let walkingText = "Something drops on the floor with a loud thud."
    let walkingText2 = "You chat with you companion along the way, navigating through this large prairie. It contrasts" +
    " with the emptyness of the areas you were in before. Butterflies with black and violet wings float around."
    let walkingText3 = "Some small birds are chirping. You don't feel any exhaustion."
    let walkingText4 = 'A bell rings. The driver, a black-hooded goat, waves at you.'
    $('.TextDiv').append('<p class="texting"> </p>')
    let companionText = ""
    let companionText2 = ""
    if ($(".TextDiv").attr('data-var') == "Chernobog") {
        companionText = "Usefull. Keep it in your bag."
        companionText2 = "Hey. Let's sit for a while. Take a break, and choose if you want to strenghten our" 
        + " forces."
        + " And just a friendly advice... Spare your gold. We WILL need it"
    } else if ($(".TextDiv").attr('data-var') == "Horus") {
        companionText = "A shiny thing ! A SHINY, TRANSPARENT red thing ! Looks like a potion to me."
        companionText2 = "Let's set up a camp here. I want to have a break. I'm up for cleaning this place of"
        + " shadows, or continue if you want to. Choice is yours."
        + " And just a friendly advice... Spare your gold. We WILL need it"
    } else if ($(".TextDiv").attr('data-var') == "Xiuhcoatl") {
        companionText = "This little recipient contains some red liquid in it. Might be a healing item."
        companionText2 = "Stop there. We don't have to be hasty. I forsee good things. A merchant is coming."
        + " Wait him, buy stuff. We can fight roaming shadows. Proceed further when you're ready." 
        + " And just a friendly advice... Spare your gold. We WILL need it"
    }

    let maxCharacters
    let textChunks
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
                        if (dialogPassed == 0) typeTextChunk();
                        if (dialogPassed == 1) typeTextChunk2()
                    } else if (currentChunkIndex == textChunks.length - 1) {
                        if (dialogPassed == 0) {
                            isTypingInProgress = true;
                            dialogPassed = 1;
                            $('.centerTextBox').hide()
                            typeWriter2();
                        } else if (dialogPassed == 1) {
                            isTypingInProgress = true;
                            dialogPassed == 2
                            typeWriter4()
                            $('.centerTextBox').hide()
                        }
                    }
                } else if (event.key === 'ArrowLeft') {
                    if (currentChunkIndex > 0) {
                        currentChunkIndex--;
                        if (dialogPassed == 0) typeTextChunk();
                        if (dialogPassed == 1) typeTextChunk2()
                    }
                }
            }
        }, 1000);
    }
    setTimeout(function()
    {
        $('.flashes').hide()
    }, 2000)
    setTimeout(function()
    {
        typeWriter()
    }, 5000)
})