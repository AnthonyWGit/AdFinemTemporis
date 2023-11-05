$(document).ready(function() {
    // Hide the centerTextBox when the document is ready because we want to display X has joined your team ! 
    if ($('.flashes').html().trim() != "" )  // Jquery quivalent to .innerHTML 
    {
        $('.toHude').hide();
        console.log('WWWW')
    }
    else
    {
        $('.gameGlobalDiv').remove();
        console.log("HAAA")
    }
    setTimeout(function() {
        $(' .flashes').remove();
        $('.toHide').show();
    }, 5000); // moved the closing parenthesis here
});
