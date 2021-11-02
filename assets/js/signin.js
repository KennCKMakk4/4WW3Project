function validate(form) {
    let fname = form["input_fname"];
    let lname = form["input_lname"];
    if (fname.value == "") {
        console.log("No first name");
        return false;
    }
    if (lname.value == "") {
        console.log("No last name");
        return false;
    }


    let username = form["input_username"];
    let email = form["input_email"];
    if (username.value == "") {
        console.log("No username");
        return false;
    }
    if (email.value == "") {
        console.log("No email");
        return false;
    }
    if (!validateEmail(email.value)) {
        console.log("Not a valid email");
        return false;
    }

    
    let pw1 = form["input_password"];
    let pw2 = form["input_password_confirm"];
    if (pw1.value == "") {
        console.log("No password");
        return false;
    }
    if (pw2.value == "") {
        console.log("No confirmed password");
        return false;
    }
    if (pw1.value != pw2.value) {
        console.log("No matching password");
        return false;
    }

    let dob = form["input_dob"];
    if (dob.value == "") {
        console.log ("No DoB");
        return false;
    }
    if (!validateDate(dob.value)) {
        console.log("Not a valid date");
        return false;
    }

    console.log("Successful form")
    return true;
}

function validateEmail(input) {
    let reg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,})+$/;
    return reg.test(input);
}

function validateDate(input) {
    let dateReg = /^(18|19|20)\d\d[-/](0[1-9]|1[012])[-/](0[1-9]|[12][0-9]|3[01])$/g;
    return dateReg.test(input);
}



function setValid(element) {
    element.style.backgroundColor = "white";
}

function setInvalid(element) {
    element.style.backgroundColor = "#ffcccc";
}