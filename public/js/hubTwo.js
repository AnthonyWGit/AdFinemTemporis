$(document).ready(function()
{
        //________________________________________AUDIO_______________________________________
    //trying to load audio as soon as possible 
    const mp3FilePath ='/sfx/chil-adventure.mp3';
    var audio = new Audio(mp3FilePath);
    audio.preload = 'auto';
    audio.volume = localStorage.getItem('volume');
    
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

    // Hide the centerTextBox when the document is ready because we want to display X has joined your team ! 
    if ($('.flashes').html().trim() != "" )  // Jquery quivalent to .innerHTML 
    {
        $('.toHide').hide();
        console.log('WWWW')
    }
    else
    {
        $('.flashes').remove();
        console.log("HAAA")
    }
    setTimeout(function() {
        $(' .flashes').remove();
        $('.toHide').show();
    }, 5000); // moved the closing parenthesis here

    $('.demonCol').on('click', function() 
    {

        $('#close').on('click', function() {
            $('#modal').hide();
        });

        var demonId = $(this).data('demon-id');
        $.get('/game/ajaxe/demon/' + demonId + '/stats', function(data) {
            let pts = data.LvlUpPoints;
            let stats = [
                {name: "Strength", value: data.Strength},
                {name: "Endurance", value: data.Endurance},
                {name: "Agility", value: data.Agility},
                {name: "Intelligence", value: data.Intelligence},
                {name: "Luck", value: data.Luck}
            ];
            // Remove all paragraph elements within .modal-content and .modal-points
            $('.modal-stats p').remove();
            $('.modal-points p').remove();
            stats.forEach(function(stat) {
                console.log(stat);
                if (pts > 0) {
                    $('.modal-stats').append('<p>' + stat.name + ': ' + stat.value + ' <button class="lvlUpBtn" data-stat="' + stat.name + '">' + '+' + '</button></p>');
                } else {
                    $('.modal-stats').append('<p>' + stat.name + ': ' + stat.value + '</p>');
                }
            });
            $('#modal').css({
                'display': 'flex',
                'justify-content': 'center',
                'align-items': 'center'
            });
            $('.modal-points').append('<p> Level up Pts left : ' + pts + '</p>');
            $('#modal').show();

            $('.modal-stats').off('click', '.lvlUpBtn').on('click', '.lvlUpBtn', function() { //Unbid privous event listener if there is one 
                // Get the current stat and points

                let currentStatName = $(this).data('stat');
                let currentStatValue = parseInt($(this).parent().text().split(':')[1]);
                console.log(currentStatName)
                console.log(currentStatValue)
            
                // Decrease points and increase stat
                if (pts > 0) {
                    pts--;
                    currentStatValue++;
            
                // Update the stat and points in the modal
                $(this).parent().text(currentStatName + ': ' + currentStatValue + ' +');
                $('.modal-points p').text('Level up Pts left : ' + pts);
            
                    // Send an AJAX request to the server to update the stat and points
                    console.log("UUUUUUUUUUU")
                    $.ajax({
                        type: 'POST',
                        url: '/game/ajaxe/demon/' + demonId + '/update',
                        data: {
                            'stat': currentStatName,
                            'value': currentStatValue,
                            'points': pts
                        },
                        success: function(data) {
                            console.log('Stat and points updated successfully');
                        },
                        error: function() {
                            console.log('Error updating stat and points');
                        }
                    });
                }
            });
        });
    });

    $('#open-shop').on('click', function()
    {
        $('#modal-inventory').show()
        $('#modal-merchant').show()


        $('#close-inventory').on('click', function() {
            $('#modal-inventory').hide();
        });

        $('#close-merchant').on('click', function() {
            $('#modal-merchant').hide();
        });

        $("[id^=button-merchant-]").click(function(event) 
        {
            event.preventDefault();
            var itemId = $(this).attr('id');
            //break the string into two parts and pick the number
            var inputFieldId = "#input-number-merchant-" + itemId.split('-')[2];
            var formData = $(inputFieldId).val();
            console.log(formData)
            $.ajax(
                {
                    type: "POST",
                    url: "/game/merchant",
                    data: 
                    {
                        number: formData,
                        itemId : itemId.split('-')[2]
                    }
                }).done(function(response)
                {
                    console.log(response)
                    if (response.newItem == null)
                    {
                        $('#inventory-number-'+ response.target).text('('+ response.quantity + ')')
                        $('#gold-number').text(response.gold);
                    } 
                    else
                    {
                        var newItem = $('<li>').text(response.newItem + '('+ response.quantity + ')');
                        $('#items-list').append(newItem);
                        $('#gold-number').text(response.gold);
                    }
                })
        });
    });
//end of document ready
})

