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

        <title>Homepage</title>
        <!-- <link rel="icon" type="image/x-icon" href="img/favicon.ico"> -->

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

        <link href="css/movieHome.css" rel="stylesheet"> 
        <style>
        .card {
          flex-direction: row;
        }
        .card img {
          width: 20%;
        }
        h2   {
          font-family: Garamond, Baskerville, "Baskerville Old Face", "Hoefler Text", "Times New Roman", serif;
          text-align: center;
          font-size: 40px;
          /* background:#42f5b0; */
        }
        h3   {
          font-family: Garamond, Baskerville, "Baskerville Old Face", "Hoefler Text", "Times New Roman", serif;
          text-align: center;
          font-size: 20px;
          /* background:#42f5b0; */
        }
        </style>
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

        <div class="bg-image p-5 text-center shadow-1-strong rounded mb-5 text-white" style="background-image: url('https://hips.hearstapps.com/hmg-prod.s3.amazonaws.com/images/fall-movies-index-1628968089.jpg?crop=0.934xw:1.00xh;0.0337xw,0&resize=1200:*');">
          <br>
          <br>
          <br>
            <h1> What do you want to watch today!! </h1>
            <h1> Here are some reveiws others had!! </h1>
          <br>
          <br>
          <br>
        </div>
            <form class="center">
              <a href="?command=goToPost" class="btn btn-info" style="width: 80%;">Add Review</a>
            </form>
          <div class ="center" style = "align: center; margin: auto;">
            <?php if (isset($_SESSION["Review"]) && (count($_SESSION["Review"]) > 0) ):  ?>
              <?php foreach ($_SESSION["Review"] as $info): ?>
                <?php 
                $baseURL = "https://api.themoviedb.org/3/search/movie?api_key=46caf8e2c80595f99f27e9d1a3a820b4";
                if (strlen($info["movieTitle"]) > 0){
                  $query = urlencode($info["movieTitle"]);
                }
                $theURL = $baseURL . "&query=" . $query;
                $MovieQuery = json_decode(file_get_contents($theURL), true);
                $posterPath = $MovieQuery["results"][0]["poster_path"];
                $thePoster = "https://image.tmdb.org/t/p/original/" . $posterPath;
                ?>
                <div class="card" style="width: 80%; margin: auto;">
                  <img class="card-img-top" src=<?php print_r($thePoster) ?>  alt="Card image cap">
                  <div class="card-body">
                    <h2 class="card-title" style = "align: center; margin: auto;"> Movie Titile: <?php echo ucfirst($info["movieTitle"]) ?></h2>
                    <h3 class="card-text" style="font-weight: bold;"> Created by: <?php echo $info["creator_username"] ?><h3>
                    <h3 class="card-text">The Review: <?php echo $info["description"] ?></h3>
                    <h3 class="card-text">Rating out of 10: <?php echo $info["rating"] ?>/10</h3>
                    <form style="padding: 0;" method="post" action="?command=editReview&theMovieID=<?= $info["reviewID"] ?>&TheUID=<?= $info["uid"] ?>">
                      <button style="width: 100%;" class="btn btn-outline-primary" type="submit"> Edit </button>
                    </form>
                    <form style="padding: 0;" method="post" action="?command=deleteReview&theMovieID=<?= $info["reviewID"] ?>&TheUID=<?= $info["uid"] ?>">
                      <button style="width: 100%;" class="btn btn-danger btn" type="submit"> Delete</button>
                    </form>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>

        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    </body>
</html>