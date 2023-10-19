function actionsClick(event)
{
    spaceActions.classList.toggle("hidden")
    strongS.classList.toggle('hidden')
    if (divCreated == 0 ) 
    {
        divCreated = 1
        textContentCombat.appendChild(createDiv)
    }
    else
    {
        createDiv.classList.toggle('hidden')
    }

}

function backElement(event)
{
    spaceActions.classList.toggle("hidden")
    strongS.classList.toggle('hidden')
    createDiv.classList.toggle('hidden')
}

let divCreated = 0
let textContentCombat = document.querySelector(".textContentCombat")
let actions = document.querySelector("#actions")
actions.addEventListener("click", actionsClick)
let strongS = document.querySelector("#strong")
let spaceActions = document.querySelector('.spaceActions')
let createDiv = document.createElement("div");
createDiv.classlist = "textContentCombat"

let createPara = document.createElement("p")
createPara.innerHTML = "back"
createPara.addEventListener("click", backElement)

createDiv.appendChild(createPara)

