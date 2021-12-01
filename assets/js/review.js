let possibleRating = -1;
let currentRating = -1;

function validate(form) {
    let currentRatingElement = document.getElementById("currentRating");
    if (currentRatingElement.value == -1 || currentRating == -1 && currentRatingElement.value != "") {
        console.log("No value given");
        setInvalidStar(document.getElementById("ratingsbar"));
        return false;
    }
    setValidStar(document.getElementById("ratingsbar"));

    
    let comment = form["input_comment"];
    if (comment.length > 500) {
        console.log("Too many characters");
        setInvalid(comment);
        return false;
    }
    setValid(comment);

    console.log("Successful form")
    return true;
}

function handleClick(e) {
    let ratingsbar = document.getElementById("ratingsbar");
    var rect = ratingsbar.getBoundingClientRect();
    if (rect.left < e.clientX && e.clientX < rect.right && rect.top < e.clientY && e.clientY < rect.bottom) {
        currentRating = -1; // resetting to inital sate
        handleHover(e);
        currentRating = possibleRating; // setting current rating
        document.getElementById("currentRating").value = currentRating;
        setValidStar(document.getElementById("ratingsbar"));
    }
}


// updates possible rating based on current location, then updates the star visuals
function handleHover(e) {
    let ratingsbar = document.getElementById("ratingsbar");
    var rect = ratingsbar.getBoundingClientRect();
    if (rect.left < e.clientX && e.clientX < rect.right && rect.top < e.clientY && e.clientY < rect.bottom) {
        let x = (e.clientX - rect.left);
        //let y = (e.clientY - rect.top);
        let percentage = x/rect.width;
        updateStarVisuals(percentage);
    } else {
        possibleRating = -1;
    }

}

// given a number from [0-1], apply to ratings and change star image
function updateStarVisuals(num) {
    let stars = [document.getElementById("star1"),
                document.getElementById("star2"),
                document.getElementById("star3"),
                document.getElementById("star4"),
                document.getElementById("star5")]
    num *= 5;
    
    if (currentRating != -1)    // if we already selected, turn off dynamic image on hover
        return;


    possibleRating = 0;         // otherwise, start redrawing the stars according to mouse position
    for (var i = 0; i < 5; i++) {
        if (num >= 0.65) {
            stars[i].innerText = 'star';
            possibleRating += 1;
        } else if (num >= 0.3) {
            stars[i].innerText = 'star_half';
            possibleRating += 0.5;
        } else {
            stars[i].innerText = 'star_border';
            possibleRating += 0;
        }
        num-=1;
    }
}

function setValid(element) {
    element.style.backgroundColor = "white";
}

function setInvalid(element) {
    element.style.backgroundColor = "#ffcccc";
    element.focus();
}

function setInvalidStar(element) {
    element.style.backgroundColor = "#ffcccc";
    element.style.fontWeight = "normal";
    element.style.color = "red";
    element.focus();
}
function setValidStar(element) {
    element.style.backgroundColor = "";
    element.style.fontWeight = "bold";
    element.style.color = "green";
}