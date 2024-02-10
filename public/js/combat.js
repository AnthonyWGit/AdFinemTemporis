
$(document).ready(function ()
{

        //________________________________________AUDIO_______________________________________
    //trying to load audio as soon as possible 
    const mp3FilePath ='/sfx/chill-piano.mp3';
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


    function actionsClick(event) {
        spaceActions.classList.toggle("hidden"); 
        strongS.classList.toggle('hidden'); 
        if (divCreated == 0 ) 
        {
            divCreated = 1;
            textContentCombat.appendChild(createDiv);
            createSkills(ajaxResponse.playerDemons);
            createDiv.appendChild(createPara); 
        }
        else
        {
            document.querySelector(".new").classList.toggle("hidden")
        }
    }
    
    //Retreive demon data and create a paragraph for each 
    function createSkills(playerDemons) {
        playerDemons.forEach(demon => {
            demonPlayer1Id
            demon.skills.forEach(skill => {
                let skillElement = document.createElement('p');
                skillElement.textContent = skill;
                skillElement.classList.add('skill'); // Add a class to each skill paragraph
                skillElement.skillUsed = skill; // Add the skill as a property of the element
                skillElement.addEventListener('click', playerSkillClicked);
                createDiv.appendChild(skillElement);
                console.log(skill)
            });
        });
    }
    function backElement(event) {
        document.querySelector(".new").classList.toggle("hidden")
        spaceActions.classList.toggle("hidden"); // Show the original menu
        strongS.classList.toggle('hidden'); // Hide the title of the combat
    }
    function playerSkillClicked(event)
    {
        event.target.removeEventListener('click', playerSkillClicked)
        let skillUsed = event.target.skillUsed;
        document.querySelector(".new").classList.toggle('hidden')
        $.ajax({
            url: '/game/ajaxe/SkillUsed',  // The URL of the route you defined in your Symfony controller
            method: 'POST',  // Or 'POST', depending on your needs
            data : {
                skill : skillUsed, 
                demonPlayer1Id : demonPlayer1Id, 
                demonPlayer2Id : demonPlayer2Id, 
                hpCurrentCPU : hpCurrentCPU,
                hpCurrentPlayer : hpCurrentPlayer,
                turn : "Player1",
                goldEarned : goldEarned,
                xpEarned : xpEarned,
            }
        }).done(function(response) //The rest of the code is loaded only if ajax request is done 
            {//This means this is cpu turn 
                console.log(response)
                turn = turn + 1
                turnName = player2Name
                hpCurrentCPU = hpCurrentCPU - response.dmg
                document.querySelector("#hpFillCPU").style.width = ((hpCurrentCPU / hpMaxCPU)* 100) + '%'
                document.querySelector("#currentHpCPU").innerHTML = hpCurrentCPU + " HP"
                if (hpCurrentCPU < 1)
                {
                    document.querySelector("#hpFillCPU").style.width = '0%'
                    document.querySelector("#currentHpCPU").innerHTML = "0 HP"
                    textContentCombat.innerHTML = "You win ! </br> Your current Demon gains " + xpEarned + " XP and " + goldEarned + " Gold."
                    setTimeout(playerWon,3000)
                }
                else
                {
                    document.querySelector("#hpFillCPU").style.width = ((hpCurrentCPU / hpMaxCPU)* 100) + '%'
                    document.querySelector("#currentHpCPU").innerHTML = hpCurrentCPU + " HP"
                    ennemyTurn()                
                }
     
            })
    }
    function ennemyTurn(event)
    {
        
        let randomSkill = ajaxResponse.cpuDemon.skills[Math.floor(Math.random() * ajaxResponse.cpuDemon.skills.length)];
        console.log(randomSkill)
        $.ajax({
            url: '/game/ajaxe/SkillUsed',  // The URL of the route you defined in your Symfony controller
            method: 'POST',  // Or 'POST', depending on your needs
            data : {
                skill : randomSkill, 
                demonPlayer1Id : demonPlayer1Id, 
                demonPlayer2Id : demonPlayer2Id, 
                hpCurrentCPU : hpCurrentCPU,
                hpCurrentPlayer : hpCurrentPlayer,
                turn : "CPU",
            }
        }).done(function(response) //The rest of the code is loaded only if ajax request is done 
            {//This means this is cpu turn 
                console.log(response)
                turnName = player2Name
                hpCurrentPlayer = hpCurrentPlayer - response.dmg
                textEnnemy.innerHTML = "Ennemy used " + randomSkill + "!" + "\n" + "It hit for " + response.dmg + " damage !"
                document.querySelector("#hpFillPlayer").style.width = ((hpCurrentPlayer / hpMaxPlayer)*100) + '%'
                document.querySelector("#currentHpPlayer").innerHTML = hpCurrentPlayer + " HP"
                textContentCombat.appendChild(textEnnemy)
                setTimeout(playerTurn, 2000)
            })
    }
    
    function playerTurn()
    {
        textContentCombat.removeChild(textEnnemy);
        console.log("hi")
        spaceActions.classList.toggle("hidden") 
        strongS.classList.toggle('hidden') 
        document.querySelectorAll(".skill").forEach(element => {
            element.addEventListener('click',playerSkillClicked)
        });
        itemUsage = "allow"
    }
    
    function playerWon() {
        $.ajax({
            url: '/ajaxe/combatAjax',
            method: 'POST',
            data: {
                'isCombatResolved': "Yes",
                'Winner': player1Name
            }
        }).done(async function(response) {
            for (var i = 0; i < response.levelsGained; i++) {
                //converting the string to number
                console.log(response)
                if (response.currentLevel == 100)
                {
    
                }
                else
                {
                    let currentPlayerLevel = parseFloat(playerLevel.innerHTML)
                    await new Promise(resolve => setTimeout(resolve, 1000));
                    document.querySelector("#xpFillPlayer").style.width = '100%';
                    currentPlayerLevel += 1;
                    //Kinda clunky need delete transition propoerties from CSS and use JQuery animation to controll it 
                    playerLevel.innerHTML = currentPlayerLevel;
                    await new Promise(resolve => setTimeout(resolve, 1000));
                    document.querySelector("#xpFillPlayer").style.width = '0%';
                    if (i == response.levelsGained - 1) {
                        console.log("i resolve");
                        await new Promise(resolve => setTimeout(resolve, 1000));
                        document.querySelector("#xpFillPlayer").style.width = response.xpPercentage["percentage"] + '%';
                    }                
                }
            }
            console.log(response);
            setTimeout(window.location.replace("/game/combat/resolve"), 3000);
        });
    }
    
    //Sending ajax request to get combat data 
    $.ajax({
        url: '/ajaxe/combatAjax',  // The URL of the route you defined in your Symfony controller
        method: 'GET',  // Or 'POST', depending on your needs
    }).done(function(response) //The rest of the code is loaded only if ajax request is done 
        {
            ajaxResponse = response
            clickable = 1 // we can click now because the data is loaded
            // The 'response' parameter contains the data returned from your Symfony controller
            console.log(response);
            //gloabl vars
    
            if (clickable == 1)
            {
                createPara.addEventListener("click", backElement)
                actions.addEventListener("click", actionsClick)
            }
        initiative = response.initiative.initiative
        player1Name = response.playersNames.player1
        player2Name = response.playersNames.player2
        demonPlayer1Id = response.playerDemons[0].id //Will need fixing bc no loop
        demonPlayer2Id = response.cpuDemon.id
        hpCurrentPlayer = response.playerDemons[0].hpMax //Will need fixing bc no loop
        hpCurrentCPU = response.cpuDemon.hpMax
        hpMaxPlayer = hpCurrentPlayer
        hpMaxCPU = hpCurrentCPU
        xpEarned = response.xpEarned
        goldEarned = response.goldEarned
        if (initiative == player1Name)
        {
            console.log("Player turn")
            turnName = player1Name
        }
        else
        {
            console.log("Enemy turn")
            strongS.classList.toggle('hidden')
            spaceActions.classList.toggle('hidden')
            turnName = 'CPU'
            ennemyTurn()
        }
    });
    
    //Query selectors
    let textContentCombat = document.querySelector(".textContentCombat")
    let actions = document.querySelector("#actions")
    let strongS = document.querySelector("#strong")
    let spaceActions = document.querySelector('.spaceActions')
    //Create elements & classlists
    let createDiv = document.createElement("div");
    let playerLevel = document.querySelector('#playerLevel');
    createDiv.classList = "spaceActions"
    createDiv.classList.add("new")
    
    let createPara = document.createElement("p")
    createPara.innerHTML = "back"
    createPara.classList = "j"
    
    let textEnnemy = document.createElement("p")
    createDiv.appendChild(createPara)
    let createParaSkills = document.createElement("p")
    
    let ajaxResponse = null;
    let player1Name = ''
    let player2Name = ''
    let initiative = ''
    let clickable = 0    
    let divCreated = 0
    let turn = 1
    let turnName = ''
    let demonPlayer1Id = ''
    let demonPlayer2Id = ''
    let hpCurrentPlayer = ''
    let hpCurrentCPU  =''
    let hpMaxPlayer = ''
    let hpMaxCPU  =''
    let xpEarned = ""
    let goldEarned = ""
    let itemUsage = "allow"
    //___________________________INVENTORY______________________________
    $('#Items').on('click', function() {
        $('#modal-inventory').show()
    
        $('#close-inventory').on('click', function() {
            $('#modal-inventory').hide()
        })
    
        $("[id^=using-item-]").click(function(event) {
            if (itemUsage === "allow") {
                itemUsage = "none" //Disallow clicking again
                var itemId = $(this).attr('id')
                var itemWhole = "#using-item" + itemId.split('-')[2]
                console.log(itemId, itemId.split('-')[2])
                $.ajax({
                    type: "POST",
                    url: "/game/ajaxe/itemUsed",
                    data: {
                        itemId : itemId.split('-')[2], //id of HhaveItem !
                        currentHpPlayer : hpCurrentPlayer,
                        maxHpPlayer : hpMaxPlayer
                    }
                }).done(function(response){
                    console.log(response)
                    if(response.doNothing) { //if use on max hp & //real values from controller
                        $(".textContentCombat").hide()
                        setTimeout(function(){
                            $('.textBoxCombat').append('<p id="gonnaRemove">You are already full HP !</p>')
                        },1500)
                        setTimeout(function(){
                            $('#gonnaRemove').remove()
                            $('.textContentCombat').show()
                        },3000)
                    } else { //Checking if healing will overflow hp bar 
                        hpCurrentPlayer = parseInt(response.data.currentHpPlayer) + parseInt(response.hpHealed)
                        console.log(response.data.currentHpPlayer)
                        console.log(response.hpHealed)
                        if (hpCurrentPlayer > parseInt(response.data.maxHpPlayer)) hpCurrentPlayer = response.data.maxHpPlayer
                        var itemIdNumberNew = itemId.split('-')[2]
                        var num = $("#using-item-" + itemIdNumberNew).siblings("span[id^='inventory-number-']")
                        console.log(itemIdNumberNew)
                        if (response.remains === null) $('#all-item-' + response.data.itemId).remove()
                        if (hpCurrentPlayer == maxHpPlayer) {
                            document.querySelector("#hpFillPlayer").style.width = '100%'
                            $('#currentHpPlayer').text(hpMaxPlayer + ' HP')
                            num.text('('+ response.remains +')')
                        } else {
                            document.querySelector("#hpFillPlayer").style.width = ((hpCurrentPlayer / hpMaxPlayer)*100) + '%'
                            $('#currentHpPlayer').text(hpCurrentPlayer + ' HP')
                            num.text('('+ response.remains +')')
                        }
                    }
                })
            }
        })
    })
})
