function validateSearch(form) {
    let name = form["input_search_name"];
    let loc = form["input_search_loc"];
    if (name.value == "" && loc.value == "") {
        console.log("No search name or location entered! At least one field must be entered");
        getLocation();
        return false;
    }
    console.log("Successful form")
    return true;
}

function getLocation() {
    let form = document.forms["searchForm"];
    let geoLoc = "hamilton, ontario";
    // TODO: geolocation
    form["input_search_loc"].value = geoLoc;
}