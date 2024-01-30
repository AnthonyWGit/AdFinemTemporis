$(document).ready(function()
{
    //________________________________________AUDIO_______________________________________
    //trying to load audio as soon as possible 
    const mp3FilePath ='/sfx/credits-music.mp3';
    var audio = new Audio(mp3FilePath);
    audio.preload = 'auto';
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
   $('body').css('overflow','hidden')
   $('.gameGlobalDivCredits').on('animationend', function() {
        // Remove the old div
        this.remove();
        // Create a new div with the text "The End"
        setTimeout(function()
        {
            var newElement = $('<div class="gameGlobalDiv charm theEnd center-align">The End (For Real)</div>');
            $('#container').append(newElement);
            var homeLink = $('<div class="gameGlobalDiv front center-align"><a href="/home" class="endButton">Homepage</a></div>');
            $('#container').append(homeLink);
        },3000)
    });
});
