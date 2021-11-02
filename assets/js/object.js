var mymap;
function initialize() {
    console.log("Loading map");
    mymap = L.map('mymap');
    // use the OpenStreetMaps tiles
    initializeMap();


    // sets location/center of map
    mymap.setView([43.240260, -79.789990], 15);
    // Hamilton Archery Centre
    addMarker( 43.240260, -79.789990,
        "Hamilton Archery Centre", "object.html");

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
