function actionsClick(event) {
    spaceActions.classList.add("hidden"); 
    strongS.classList.add('hidden'); 
    createDiv.classList.remove('hidden'); 

    if (divCreated == 0 ) {
        divCreated = 1;
        textContentCombat.appendChild(createDiv);
        createSkills(ajaxResponse.playerDemons);
        createDiv.appendChild(createPara); 
    }
}

function createSkills(playerDemons) {
    playerDemons.forEach(demon => {
        demonPlayer1Id
        demon.skills.forEach(skill => {
            let skillElement = document.createElement('p');
            skillElement.textContent = skill;
            skillElement.classList.add('skill'); // Add a class to each skill paragraph
            skillElement.addEventListener('click', playerSkillClicked);
            createDiv.appendChild(skillElement);
            skillUsed = skill
            console.log(skillUsed)
        });
    });
}
function backElement(event) {
    spaceActions.classList.remove("hidden"); // Show the original menu
    strongS.classList.remove('hidden'); // Show the strongS element
    createDiv.classList.add('hidden'); // Hide the skills
}
function playerSkillClicked(event)
{
    event.target.removeEventListener('click', playerSkillClicked)
    turn = turn + 1
    turnName = player2Name
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
        }
    }).done(function(response) //The rest of the code is loaded only if ajax request is done 
        {
            console.log(response)
        })
}
function ennemyTurn(event)
{
    if (event.key === 'ArrowUp')
    {
        textContentCombat.classList.toggle('hidden')    
    }

}
//Sending ajax request to get combat data 

let ajaxResponse = null;

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
    if (initiative == player1Name)
    {
        console.log("Player turn")
        turnName = player1Name
    }
    else
    {
        console.log("Enemy turn")
        textContentCombat.classList.toggle('hidden')
        turnName = 'CPU'
    }
        
});

let player1Name = ''
let player2Name = ''
let initiative = ''
let clickable = 0    
let divCreated = 0
let turn = 1
let turnName = ''
let skillUsed = ''
let demonPlayer1Id = ''
let demonPlayer2Id = ''
let hpCurrentPlayer = ''
let hpCurrentCPU  =''
//Query selectors
let textContentCombat = document.querySelector(".textContentCombat")
let actions = document.querySelector("#actions")
let strongS = document.querySelector("#strong")
let spaceActions = document.querySelector('.spaceActions')
//Create elements & classlists
let createDiv = document.createElement("div");
createDiv.classList = "spaceActions"
createDiv.classList.add("new")

let createPara = document.createElement("p")
createPara.innerHTML = "back"
createPara.classList = "j"

createDiv.appendChild(createPara)
let createParaSkills = document.createElement("p")
//event listeners
document.addEventListener("keydown", ennemyTurn)
