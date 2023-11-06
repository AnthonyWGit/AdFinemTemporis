$(document).ready(function()
{
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

    $('.demonCol').on('click', function() {

        $('.close').on('click', function() {
            $('#modal').hide();
        });

        var demonId = $(this).data('demon-id');
        $.get('ajaxe/demon/' + demonId + '/stats', function(data) {
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
});
