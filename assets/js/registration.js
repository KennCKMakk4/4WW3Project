function validate(form) {
    let fname = form["input_fname"];
    let lname = form["input_lname"];
    if (fname.value == "" || fname.length > 30) {
        console.log("No first name or too many characters");
        setInvalid(fname);
        return false;
    }
    setValid(fname);
    if (lname.value == "" || lname.length > 30) {
        console.log("No last name or too many characters");
        setInvalid(lname);
        return false;
    }
    setValid(lname);


    let username = form["input_username"];
    let email = form["input_email"];
    if (username.value == "") {
        console.log("No username or too many characters");
        setInvalid(username);
        return false;
    }
    setValid(username);


    if (email.value == "") {
        console.log("No email");
        setInvalid(email);
        return false;
    }
    if (!validateEmail(email.value)) {
        console.log("Not a valid email");
        setInvalid(email);
        return false;
    }
    setValid(email);
    
    let pw1 = form["input_password"];
    let pw2 = form["input_password_confirm"];
    if (pw1.value == "" || pw1.length > 30) {
        console.log("No password or too many characters");
        setInvalid(pw1);
        return false;
    }
    if (pw2.value == "") {
        console.log("No confirmed password");
        setInvalid(pw2);
        return false;
    }
    if (pw1.value != pw2.value) {
        console.log("No matching password");
        setInvalid(pw2);
        setInvalid(pw1);
        return false;
    }
    setValid(pw1);
    setValid(pw2);

    let dob = form["input_dob"];
    if (dob.value == "") {
        console.log ("No DoB");
        setInvalid(dob);
        return false;
    }
    if (!validateDate(dob.value)) {
        console.log("Not a valid date");
        setInvalid(dob);
        return false;
    }
    setValid(dob);

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
    element.focus();
}