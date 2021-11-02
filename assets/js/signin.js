function validate(form) {
    let username = form["input_username"];
    // two methods of signin, email or username
    if (username.value == "") {
        console.log("No username/email");
        setInvalid(username);
        return false;
    }

    setValid(username);
    let pw = form["input_password"];
    if (pw.value == "") {
        console.log("No password");
        setInvalid(pw);
        return false;
    }
    setValid(pw);

    console.log("Successful form")
    return true;
}


function setValid(element) {
    element.style.backgroundColor = "white";
}

function setInvalid(element) {
    element.style.backgroundColor = "#ffcccc";
}