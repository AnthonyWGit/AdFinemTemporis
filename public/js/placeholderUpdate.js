$(document).ready(function() {
    let inputStr = $("#the_lab_self_demon_str");
    let inputEnd = $("#the_lab_self_demon_end");
    let inputAgi = $("#the_lab_self_demon_agi");
    let inputInt = $("#the_lab_self_demon_int");
    let inputLck = $("#the_lab_self_demon_lck");

    let inputStrCPU = $("#the_lab_self_demon_strCPU");
    let inputEndCPU = $("#the_lab_self_demon_endCPU");
    let inputAgiCPU = $("#the_lab_self_demon_agiCPU");
    let inputIntCPU = $("#the_lab_self_demon_intCPU");
    let inputLckCPU = $("#the_lab_self_demon_lckCPU");

    let switcher = $('#the_lab_self_demon_demonBase');
    let switcherCPU = $('#the_lab_self_demon_demonBaseCPU');

    // inputStr.attr('placeholder' , switcher.val())
    // inputEnd.attr('placeholder' , switcher.val())
    // inputAgi.attr('placeholder' , switcher.val())
    // inputInt.attr('placeholder' , switcher.val())
    // inputLck.attr('placeholder' , switcher.val())

    switcher.on('change', function() {
        // Your code here
        console.log("Switcher value has changed!");
        console.log(switcher.val());
        // inputStr.attr('placeholder','55')

        $.ajax({
            url: '/the_lab/ajax',  // The URL of the route you defined in your Symfony controller
            method: 'POST',  // Or 'POST', depending on your needs
            data : {
                demonId : switcher.val()
            },
        }).done(function(response) //The rest of the code is loaded only if ajax request is done 
            {
                console.log(response)
                inputStr.attr('placeholder', response[0])
                inputEnd.attr('placeholder', response[1])
                inputAgi.attr('placeholder', response[2])
                inputInt.attr('placeholder', response[3])
                inputLck.attr('placeholder', response[4])
            })
    });

    switcherCPU.on('change', function() {
        // Your code here
        console.log("Switcher CPU  value has changed!");
        console.log(switcherCPU.val());
        // inputStr.attr('placeholder','55')

        $.ajax({
            url: '/the_lab/ajaxCPU',  // The URL of the route you defined in your Symfony controller
            method: 'POST',  // Or 'POST', depending on your needs
            data : {
                demonIdCPU : switcherCPU.val()
            },
        }).done(function(response) //The rest of the code is loaded only if ajax request is done 
            {
                console.log(response)
                inputStrCPU.attr('placeholder', response[0])
                inputEndCPU.attr('placeholder', response[1])
                inputAgiCPU.attr('placeholder', response[2])
                inputIntCPU.attr('placeholder', response[3])
                inputLckCPU.attr('placeholder', response[4])
            })
    });

});
