function validate(form) {
    let name = form["input_name"];
    if (name.value == "") {
        console.log("No first name");
        setInvalid(name);
        return false;
    }
    setValid(name);

    let about = form["input_about"];
    if (about.value == "") {
        console.log("No about description");
        setInvalid(about);
        return false;
    }
    setValid(about);

    let phone = form["input_phone"];
    if (phone.value != "" && !validatePhone(phone.value)) {
        console.log("Not a valid Canadian phone number");
        setInvalid(phone);
        return false;
    }
    setValid(phone);
    
    let email = form["input_email"];
    if (email.value != "" && !validateEmail(email.value)) {
        console.log("Not a valid email");
        setInvalid(email);
        return false;
    }
    setValid(email);

    let long = form["input_longitude"];
    if (long.value == "") {
        console.log("No longitudinal value");
        setInvalid(long);
        return false;
    }
    if (!validateLongitude(long.value)) {
        console.log("Invalid longitudinal value");
        setInvalid(long);
        return false;
    }
    setValid(long);

    let lat = form["input_latitude"];
    if (lat.value == "") {
        console.log("No latitudinal value");
        setInvalid(lat);
        return false;
    }
    if (!validateLatitude(lat.value)) {
        console.log("Invalid latitudinal value");
        setInvalid(lat);
        return false;
    }
    setValid(lat);




    console.log("Successful form")
    return true;
}

function validatePhone(input) {
    //https://stackoverflow.com/questions/21030347/regex-test-for-us-canada-long-distance-phone-number
    let phoneReg = /^(\+?1 ?)?\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
    return phoneReg.test(input);
}

function validateEmail(input) {
    let reg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,})+$/;
    return reg.test(input);
}

function validateDate(input) {
    let dateReg = /^(18|19|20)\d\d[-/](0[1-9]|1[012])[-/](0[1-9]|[12][0-9]|3[01])$/;
    return dateReg.test(input);
}

// https://stackoverflow.com/a/31408260
// Note; other option is ^-?[0-9]{1,3}(?:\.[0-9]{1,10})?$ (one of other answers)
// {1,6 = decimal points}
function validateLatitude(input) {
    let reg = /^(\+|-)?(?:90(?:(?:\.0{1,9})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,9})?))$/;
    return reg.test(input);
}

function validateLongitude(input) {
    let reg = /^(\+|-)?(?:180(?:(?:\.0{1,9})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,9})?))$/;
    return reg.test(input);
}

function setValid(element) {
    element.style.backgroundColor = "white";
}

function setInvalid(element) {
    element.style.backgroundColor = "#ffcccc";
    element.focus();
}


function getLocation() {
    // TODO: geolocation
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        console.log("Geolocation not accessible or supported");
    }
}

function showPosition(position) {
    console.log(position.coords.latitude);
    console.log(position.coords.longitude);

    // find form, then the latitude and longitude elements in the form
    let form = document.forms["submissionForm"];
    let lat = form["input_latitude"];
    let long = form["input_longitude"];

    // write values from geolocation
    lat.value = position.coords.latitude;
    long.value = position.coords.longitude;

    // if there was an error before; negate it since it is filled now
    setValid(lat);
    setValid(long);
}