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
        console.log(latlongtoken.value);
        let lat = latlongtoken.value.split(", ")[0];
        let long = latlongtoken.value.split(", ")[1];
        mymap.setView([lat,long], 10);
        addMarkerNL( lat,long, "Your Search Location");
    } else {
        console.log("No lat long data");
        latlongtoken = 0;
    }

    // sets location/center of map
    var locationtoken = document.getElementById("locationtoken");
    if (locationtoken != null) {
        console.log("Got location data");
        console.log(locationtoken.value);

        // each section of data[4] is info to create a marker
        // lat, long, name, id
        // id used to allow markers to link to the object.html
        var data = locationtoken.value.split(", ");
        console.log(data.length)
        for (var i = 0; i < data.length; i+=4) {
            var lat = parseFloat(data[i]);
            var long = parseFloat(data[i+1]);
            addMarker(parseFloat(data[i]), parseFloat(data[i+1]), data[i+2], "object.php?id="+data[i+3]);

            // setting marker on first result if we are not already marked
            if (latlongtoken == 0) {
                latlongtoken = 1;
                mymap.setView([lat,long], 10);
            }
        }
    } else {
        console.log("No location data");
        locationtoken = 0;
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
