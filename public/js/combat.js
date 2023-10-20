function actionsClick(event) {
    spaceActions.classList.add("hidden"); // Hide the original menu
    strongS.classList.add('hidden'); // Hide the strongS element
    createDiv.classList.remove('hidden'); // Show the skills

    if (divCreated == 0 ) {
        divCreated = 1;
        textContentCombat.appendChild(createDiv);
        let paragraphs = createSkills(ajaxResponse.playerDemons);
        createDiv.innerHTML = paragraphs;
        createDiv.appendChild(createPara); // Append createPara after setting innerHTML
    }
}
function backElement(event) {
    spaceActions.classList.remove("hidden"); // Show the original menu
    strongS.classList.remove('hidden'); // Show the strongS element
    createDiv.classList.add('hidden'); // Hide the skills
}

function createSkills(playerDemons) {
    let skillsHTML = '';
    playerDemons.forEach(demon => {
        demon.skills.forEach(skill => {
            skillsHTML += '<p>' + skill + '</p>';
        });
    });
    return skillsHTML;
}

//Sending ajax request to get combat data 

let ajaxResponse = null;

$.ajax({
    url: '/ajaxe/combatAjax',  // The URL of the route you defined in your Symfony controller
    method: 'GET',  // Or 'POST', depending on your needs
}).done(function(response) {
    ajaxResponse = response
    clickable = 1 // we can click now because the data is loaded
    // The 'response' parameter contains the data returned from your Symfony controller
    console.log(response);
});
//gloabl vars
let clickable = 0
let divCreated = 0
//Query selectors
let textContentCombat = document.querySelector(".textContentCombat")
let actions = document.querySelector("#actions")
let strongS = document.querySelector("#strong")
let spaceActions = document.querySelector('.spaceActions')
//Create elements & classlists
let createDiv = document.createElement("div");
createDiv.classList = "spaceActions"

let createPara = document.createElement("p")
createPara.innerHTML = "back"
createPara.classList = "j"

createDiv.appendChild(createPara)
let createParaSkills = document.createElement("p")
//event listeners
if (clickable == 1)
{
    createPara.addEventListener("click", backElement)
    actions.addEventListener("click", actionsClick)    
}


    
    



