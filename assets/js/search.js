function validate(form) {
    let name = form["input_search_name"];
    let loc = form["input_search_loc"];
    if (name.value == "" && loc.value == "") {
        console.log("No search name or location entered! At least one field must be entered");

        name.focus();
        setInvalid(name); setInvalid(loc);
        return false;
    }
    setValid(name); setValid(loc);
    console.log("Successful form")
    return true;
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

    let geoLoc = position.coords.latitude + ", " + position.coords.longitude;
    let form = document.forms["searchForm"];
    let name = form["input_search_name"];
    let loc = form["input_search_loc"];
    loc.value = geoLoc;
    setValid(name);
    setValid(loc);
}

function setValid(element) {
    element.style.backgroundColor = "white";
}

function setInvalid(element) {
    element.style.backgroundColor = "#ffcccc";
}