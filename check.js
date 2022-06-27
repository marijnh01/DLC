
    let name = document.getElementById("name")
    let email = document.getElementById("email")
    let date = document.getElementById("date")
    let time = document.getElementById("time")
    let button = document.getElementById("button")

    function buttonSwitch() {
    if (name.value === "" || name.value == null) {
    button.disabled = true;
}
    else if (email.value === "" || email.value == null) {
    button.disabled = true;
}
    else if (date.value === "" || date.value == null) {
    button.disabled = true;
}
    else if (time.value === "" || time.value == null) {
    button.disabled = true;
}
    else {
    button.disabled = false;
}
}
    window.addEventListener("keypress", buttonSwitch)
