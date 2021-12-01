var mymap;
function initialize() {
    console.log("Loading map");
    mymap = L.map('mymap');
    // use the OpenStreetMaps tiles
    initializeMap();


    findMarkers();

        // create a blank pop-up for later use
    // display a popup when the user clicks on the map
    function onMapClick(e) {
        var popup = L.popup();
        popup.setLatLng(e.latlng)
        //popup.setContent("You clicked the map at " + e.latlng.toString())
        //popup.openOn(mymap);
        console.log(e.latlng);
    }
    mymap.on('click', onMapClick);
}

function initializeMap() {
    L.tileLayer(
        'https://a.tile.openstreetmap.org/{z}/{x}/{y}.png',
        { attribution: 'Map data &copy; <a href="http://openstreetmap.org"> OpenStreetMap</a> contributors, ' + '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>' }
        ).addTo(mymap);
}

function findMarkers() {
    // find data from php and render them

    // first - create a marker around our search location
    var latlongtoken = document.getElementById("latlongtoken");
    if (latlongtoken != null) {
        console.log("got data");
        let data = latlongtoken.value.split(", ");
        addMarker( data[0], data[1], data[2]);
        mymap.setView([data[0], data[1]], 15);
    } else {
        console.log("No lat long data");
        latlongtoken = 0;
    }
}
// creates a marker with the latitude, longitude, location name, and the link to the location
// atm we just link to the sample object
function addMarker(lat, long, locName, locLink) {
    L.marker([lat, long])
    .addTo(mymap)
    .bindPopup("<b>" + locName + "</b>" +       // name in bold
                "<br>" +                            // newline
                "<a href='" + locLink + "'>Link</a>")   // link
}
// marker with no link
function addMarkerNL(lat, long, locName) {
    L.marker([lat, long])
    .addTo(mymap)
    .bindPopup("<b>" + locName + "</b>")      // name in bold
}
