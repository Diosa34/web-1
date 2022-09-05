let x = null
function validationX(){
    let xElem = document.getElementById("x")
    let warning = document.getElementById("x-warning")
    if (isNaN(xElem.value) || xElem.value === "" || +xElem.value <= -3 || 3 <= +xElem.value) {
        warning.innerText = "Координата Х должна быть числом из диапазона (-3; 3)"
        warning.style.display = "inline-block"
        x = null
    } else {
        warning.style.display = "none"
        x = xElem.value
    }
    buttonDisable()
}

let selectedCheckbox = null
function checkboxVal(checkbox){
    if (checkbox.checked) {
        if (selectedCheckbox !== null) {
            selectedCheckbox.checked = false
        }
        selectedCheckbox = checkbox
    } else {
        selectedCheckbox = null
    }
    buttonDisable()
}

function buttonDisable(){
    if (x === null || selectedCheckbox === null){
        document.getElementById("btn1").disabled = true
        document.getElementById("btn2").disabled = true
        document.getElementById("btn3").disabled = true
        document.getElementById("btn4").disabled = true
        document.getElementById("btn5").disabled = true
    } else {
        document.getElementById("btn1").disabled = false
        document.getElementById("btn2").disabled = false
        document.getElementById("btn3").disabled = false
        document.getElementById("btn4").disabled = false
        document.getElementById("btn5").disabled = false
    }
}

let selectedButton = null
function rChoose(button) {
    if (selectedButton !== null) {
        selectedButton.disabled = false
    }
    selectedButton = button
    selectedButton.disabled = true
    document.getElementById("chosen-button").value = button.value
}