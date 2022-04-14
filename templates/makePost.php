<!DOCTYPE html>
<!-- 
    sources: https://www.w3schools.com/howto/howto_css_rounded_images.asp, https://ui-avatars.com/
 -->
<html lang="en">
    <head>
        <meta charset="UTF-8">  

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="CS4750">
        <meta name="description" content="CS4750 Account">          

        <title>Make Post</title>
        <!-- <link rel="icon" type="image/x-icon" href="img/favicon.ico"> -->

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

        <link href="css/movieHome.css" rel="stylesheet"> 
    </head>

    <body>
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
        <div class="container">
            <div class="row">
                <form id="activity-form" class="col-md my-5 needs-validation" onreset="resetInputs()" method="post" action="?command=makePost" novalidate>
                <div id="create-text" class="lead fs-3 mb-3">Make a movie opinion post</div>
                <!-- Inputs for Creation Form -->
                <div class="row">
                    <label for="MovieTitle" class="form-label">Movie Title</label>
                    <input id="MovieTitle" onkeyup="changeTitle()" name="title" class="form-control" type="text" placeholder="Movie Title" aria-label="Activity Title" required />
                    <div class="invalid-feedback">
                        Please enter an movie title.
                    </div>
                </div>
                <div class="row">
                    <label for="yourOpinion" class="form-label">Your Opinion</label>
                    <textarea class="form-control" name="description" onkeyup="changeDescription()" id="yourOpinion" placeholder="Your Opinion" rows="5" style="resize: none" required></textarea>
                    <div class="invalid-feedback">
                        Please enter a opinion about the movie.
                    </div>
                </div>
                <div class="row">
                    <label for="yourRating" class="form-label">Your Rating</label>
                    <input id="yourRating" name="rating" class="form-control" type="text" placeholder="Your Rating" aria-label="Your Rating" required />
                    <div class="invalid-feedback">
                        Please enter your rating.
                    </div>
                </div>
                <!-- Clear and Create Buttons -->
                <div class="row">
                    <button class="btn btn-outline-success mb-2" type="submit">
                        Create!
                    </button>
                    <input type="reset" class="btn btn-outline-danger" />
                </div>
                <!-- See Authvalidation.js -->
                <script src="javascript/authvalidation.js"></script>
            </form>
            <br>
            <br>
            <!-- Preview Card Start -->
            <div class="col-md my-5">
                <div class="lead fs-3 text-center mb-3" style="color: blueviolet">
                    Preview
                </div>
                <div class="row justify-content-center">
                    <div class="card" style="width: 75%">
                        <img src="images/placeholder.jpg" class="card-img-top" alt="Placeholder Image" width="200" height="300" />
                        <div class="card-body">
                            <h5 class="card-title text-wrap" id="title-ancor">
                                Activity Title
                            </h5>
                            <h6 class="text-muted card-subtitle mb-md-1">
                                Posted By: <?= $_SESSION["name"] ?>
                            </h6>
                            <p class="card-text text-wrap text-body" id="description-ancor">
                                Enter your movie opinion
                            </p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item" id="rating-ancor">Rating:</li>
                        </ul>
                        <div class="card-body">
                            <button class="btn btn-outline-primary">Edit</button>
                            <button class="btn btn-danger btn">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Preview Card End -->
        </div>
    </div>
    <!-- Creation Form End -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script src="javascript/createformcontrol.js"></script>
</body>
</html>