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
        let lat = latlongtoken.value.split(", ")[0];
        let long = latlongtoken.value.split(", ")[1];
        mymap.setView([lat,long], 10);
        console.log("Setting to search location");
        addMarkerNL( lat,long, "Your Search Location");
    } else {
        console.log("No lat long data");
        latlongtoken = 0;
    }
    
    // sets location/center of map
    var locationtoken = document.getElementById("locationtoken");
    if (locationtoken != null && locationtoken.value != "") {
        console.log("Got location data");

        // each section of data[4] is info to create a marker
        // lat, long, name, id
        // id used to allow markers to link to the object.html
        var data = locationtoken.value.split(", ");
        for (var i = 0; i < data.length; i+=4) {
            var lat = parseFloat(data[i]);
            var long = parseFloat(data[i+1]);
            addMarker(parseFloat(data[i]), parseFloat(data[i+1]), data[i+2], "object.php?id="+data[i+3]);

            // setting marker on first result if we are not already marked
            if (latlongtoken == 0) {
                latlongtoken = 1;
                console.log("Setting to first marker");
                mymap.setView([lat,long], 10);
            }
        }
    } else {
        console.log("No location data");
        locationtoken = 0;
    }


    // default setview so it doesn't just render at empty screen
    if (latlongtoken == 0) {
        console.log("Setting default marker");
        latlongtoken = 1;
        mymap.setView([44.99491, -95.894876], 10);
    }
}


// On hover over this table row, we center the map on that location
function setMarkerTo(element) {
    var contentsInColumn0 = element.children[0].innerHTML;
    if (!contentsInColumn0) 
        return;
    // removing <a>name</a> tags
    var name = extractDataFromCell(contentsInColumn0, 0);

    // finding name from our token data to re-get latlong we used at the very beginning
    var data = locationtoken.value.split(", ");
    // each set of 4 is details for one object
    // lat, long, name, id, lat, long, name, id...
    for (var i = 0; i < data.length; i+=4) {
        // if we found the name
        if (data[i+2] === name) {
            // set view
            mymap.setView([data[i],data[i+1]], 10);
        }
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

var sort = "desc";
function changeSort() {
    if (sort == "asc")
        sort = "desc";
    else
        sort = "asc";
}

function extractDataFromCell(data, columnNum) {
    // name has <a> tags, ratings has <b>val</b> tags
    // Location Name
    if (columnNum == 0 ) {
        return data.split(">")[1].split("<")[0];
    }
    // Location Reviews
    if (columnNum == 1) {
        // if we ever change formatting of of innerHTML in cell, we need to change this
        if (data.includes(">") || data.includes("<"))
            return data.split(">")[1].split("<")[0];
        else
            return data.split(" ")[0];

    }
    
    // else; just return data as is
    return data;
}

var lastSelectedColumn = "";
function sortTable(columnNum) {
    let table = document.getElementById("results_table");

    if (lastSelectedColumn == columnNum) 
        changeSort();
    // name, rating, address
    var rows = table.rows;
    
    var switching = true;
    var shouldSwap;
    while (switching) {
        switching = false;
        
        for (var i = 1; i < (rows.length)-1; i++) {
            shouldSwap = false;
            let cell1 = rows[i].getElementsByTagName("TD")[columnNum];
            let cell1Value = extractDataFromCell(cell1.innerHTML, columnNum);

            let cell2 = rows[i+1].getElementsByTagName("TD")[columnNum];
            let cell2Value = extractDataFromCell(cell2.innerHTML, columnNum);

            if (sort == "asc") {
                if (cell1Value > cell2Value) {
                    shouldSwap = true;
                    break;
                }
            } else {
                if (cell1Value < cell2Value) {
                    shouldSwap = true;
                    break;
                }
            }
        }

        if (shouldSwap) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
    lastSelectedColumn = columnNum;
}