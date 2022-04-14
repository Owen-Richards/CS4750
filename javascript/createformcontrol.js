// Add listeners to the 3 ancors on the card preview
document.getElementById("MovieTitle").addEventListener("keyup", yourMovie);
document.getElementById("yourOpinion").addEventListener("keyup", yourOpinion);
document.getElementById("yourRating").addEventListener("keyup", yourRating);

// Function responsible for updating the title on the preview card
function file_get_contents(filename) {
    fetch(filename).then((resp) => resp.text()).then(function(data) {
        return data;
    });
}

function yourMovie() {
    var Movietitle = document.getElementById("MovieTitle").value;
    document.getElementById("title-ancor").innerHTML = Movietitle;
}

function yourOpinion() {
    var Moviedescription = document.getElementById("yourOpinion").value;
    document.getElementById("description-ancor").innerHTML = Moviedescription;
}

function yourRating() {
    var rating = document.getElementById("yourRating").value;
    if (rating > 10 || rating < 0 || isNaN(rating)){
        alert("Please enter a rating between 0 - 10")
    }
    document.getElementById("rating-ancor").innerHTML =  rating;
}

function validateAnswer(){
    var rating = document.getElementById("yourRating");
    var regex = new RegExp("[0-9]");
    if( !regex.test(rating.value) ) {
        alert('Input is not numeric');
    }
}

function makeSure(){
    if (rating > 10 || rating < 0 || isNaN(rating)){
        alert("Please enter a rating between 0 - 10")
    }
}
// Resets all the preview areas on the preview card back to their defaults
function resetInputs() {
    document.getElementById("title-ancor").innerHTML = "Movie Title";
    document.getElementById("description-ancor").innerHTML = "Enter your movie recommendations!";
    document.getElementById("rating-ancor").innerHTML = "Rating: ";
}