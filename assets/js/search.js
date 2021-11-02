function validate(form) {
    let name = form["input_search_name"];
    let loc = form["input_search_loc"];
    if (name.value == "" && loc.value == "") {
        console.log("No search name or location entered! At least one field must be entered");

        name.focus();
        setInvalid(name); setInvalid(loc);
        //getLocation();
        return false;
    }
    setValid(name); setValid(loc);
    console.log("Successful form")
    return faltruese;
}

function getLocation() {
    let form = document.forms["searchForm"];
    let geoLoc = "hamilton, ontario";
    // TODO: geolocation
    form["input_search_loc"].value = geoLoc;
    setValid(name); setValid(loc);
}

function setValid(element) {
    element.style.backgroundColor = "white";
}

function setInvalid(element) {
    element.style.backgroundColor = "#ffcccc";
}