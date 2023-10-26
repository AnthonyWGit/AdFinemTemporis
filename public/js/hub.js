$(document).ready(function() {
    // Hide the centerTextBox when the document is ready because we want to display X has joined your team ! 
    $('.centerTextBox').hide();
    setTimeout(function() {
        $('.toHide').remove();
    }, 5000); // moved the closing parenthesis here
});
