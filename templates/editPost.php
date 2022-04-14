<!doctype html>
<html lang="en">

    <head>
        <meta charset="UTF-8">  

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="CS4750">
        <meta name="description" content="CS4750 Account">          

        <title>Edit Post</title>
        <!-- <link rel="icon" type="image/x-icon" href="img/favicon.ico"> -->

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

        <link href="css/movieHome.css" rel="stylesheet"> 
    </head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand navbar-dark bg-dark" aria-label="Second navbar example">
            <div class="container-fluid">
                <a class="navbar-brand" href="?command=movieHomepage">Home</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarsExample02">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="?command=movieHomepage">Your Homepage</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?command=movieFinder">Movie Finder</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?command=friends">Your Friends</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?command=movieAccount">Your Account</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?command=goToPost">Create Post</a>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <a href="?command=logout" class="btn btn-danger">Logout</a>
                    </form>
                </div>
            </div>
        </nav>
    <!-- Navbar End -->
    <div class ="center">
        <form class="form-control needs-validation" method="post" action="?command=changeReview" novalidate>
            <div class="row">
                <div class="Private-Info">
                    <h6>
                        Email: <?= $_SESSION["email"] ?> (Private)
                    </h6>
                    <h6>
                        Your ID: <?=  $_SESSION["userID"][0]["id"] ?> (Private)
                    </h6>
                    <h6>
                        This Review ID: <?= $_SESSION["editOpinion"][0]["reviewID"]?>
                    </h6>
                </div>
                <div class="Public-Info">
                    <div class="center">
                        <label for="firstname" class="form-label">The Movie Title</label>
                        <input type="text" class="form-control" id="movie" name="movie" placeholder="Please enter the Movie." value="<?= $opinionEdit[0]["movieTitle"] ?>" required>
                        <div class="invalid-feedback">
                            Please enter the Movie
                        </div>
                    </div>
                    <div class="row">
                        <div class="Your Review">
                            <h6>
                                Your Review
                            </h6>
                        </div>
                    </div>
                    <div class="center">
                        <textarea class="form-control" id="about" name="about" rows="6" style="resize: none" required> <?= $opinionEdit[0]["description"]?> </textarea>
                        <div class="invalid-feedback">
                            Please enter your review
                        </div>
                    </div>
                    <div class="center">
                        <label for="yourRating" class="form-label">Your Rating</label>
                        <input id="yourRating" name="yourRating" class="form-control" type="number" min="0" max="10" placeholder="Your Rating" value="<?= $opinionEdit[0]["rating"] ?>" aria-label="Your Rating" required />
                        <div class="invalid-feedback">
                            Please enter your rating.
                        </div>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            <script src="javascript/authvalidation.js"></script>
        </form>
    </div>
    <script src="javascript/createformcontrol.js"></script>
</body>
</html>