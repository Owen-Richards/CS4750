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

        <title>Account</title>
        <!-- <link rel="icon" type="image/x-icon" href="image/favicon.ico"> -->

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

        <link href="css/Homepage.css" rel="stylesheet"> 
        <style>
            .card img{
                width:20%;
            }
            
            p{
                font-family: Garamond, Baskerville, "Baskerville Old Face", "Hoefler Text", "Times New Roman", serif;
                text-align: center;
                font-size: 20px;
            }
            h5   {
                font-family: Garamond, Baskerville, "Baskerville Old Face", "Hoefler Text", "Times New Roman", serif;
                text-align: center;
                font-size: 30px;
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

        <div class="bg-image p-5 text-center shadow-1-strong rounded mb-5 text-white" style="background-image: url('https://s3-us-west-2.amazonaws.com/prd-rteditorial/wp-content/uploads/2018/03/13153742/RT_300EssentialMovies_700X250.jpg');">
            <img style = "border-radius: 50%;" src="https://ui-avatars.com/api/?name=<?= $_SESSION["name"]?>&background=0D8ABC&color=fff" alt="Avatar" width="100" height="100">
            <h1> Welcome to all your movie needs <?= $_SESSION["name"]?></h1>
            <h1> Email: <?= $_SESSION["email"]?></h1>
        </div>
        
        <div class="container" style="margin-top: 10px;">
            <div class="row col-xs-8">
                <h1> Your Account </h1>
            </div>
            <br>
            <h2> Movies you intend to watch: </h2>
            <div class="row">
                <div class="d-flex flex-wrap justify-content-around">                 
                    <?php if (isset($_SESSION["watchlistMovieInfo"]) && (count($_SESSION["watchlistMovieInfo"]) > 0) ):  ?>
                        <?php foreach ($_SESSION["watchlistMovieInfo"] as $info): ?>
                            <div class="card" style="margin-top: 1em; margin-bottom: 1em; flex-direction: row; max-width:auto">
                                <img class="card-img-top" src=<?php print_r($info[0]) ?>  alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $info[1] ?></h5>
                                        <p class="card-text"><?php echo $info[2] ?></p>
                                        <form style="padding: 0;text-align:center;" method="post" action="?command=removeWatchList&movieTitle=<?= $info[1] ?>">
                                            <button style="width: 50%;" class="btn btn-danger" type="submit"> Remove </button>
                                        </form>
                                    </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <h4> You have no movies. </h4>
                    <?php endif; ?>
                </div>
                    
                <br>
                    
                    <h2> Movies you have liked: </h2>
                <div class="d-flex flex-wrap justify-content-around">                 
                    <?php if (isset($_SESSION["likes"]) && (count($_SESSION["likes"]) > 0) ):  ?>
                        <?php foreach ($_SESSION["likes"] as $info): ?>
                            <div class="card" style="margin-top: 1em; margin-bottom: 1em; flex-direction: row; max-width:auto">
                                <img class="card-img-top" src=<?php print_r($info[0]) ?>  alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $info[1] ?></h5>
                                        <p class="card-text"><?php echo $info[2] ?></p>
                                        <form style="padding: 0;text-align:center;" method="post" action="?command=removeLikelist&movieTitle=<?= $info[1] ?>">
                                            <button style="width: 50%;" class="btn btn-danger" type="submit"> Remove </button>
                                        </form>
                                    </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <h4> You have no liked movies  </h4>
                    <?php endif; ?>
                </div>

                <br>

                    <h2> Movies you have watched: </h2>
                    <div class="d-flex flex-wrap justify-content-around">                 
                    <?php if (isset($_SESSION["watched"]) && (count($_SESSION["watched"]) > 0) ):  ?>
                        <?php foreach ($_SESSION["watched"] as $info): ?>
                            <div class="card" style="margin-top: 1em; margin-bottom: 1em; flex-direction: row; max-width:auto">
                                <img class="card-img-top" src=<?php print_r($info[0]) ?>  alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $info[1] ?></h5>
                                        <p class="card-text"><?php echo $info[2] ?></p>
                                        <form style="padding: 0;text-align:center;" method="post" action="?command=removeAlreadySeenlist&movieTitle=<?= $info[1] ?>">
                                            <button style="width: 50%;" class="btn btn-danger" type="submit"> Remove </button>
                                        </form>
                                    </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <h4> You have not watched any movies. </h4>
                    <?php endif; ?>
                </div>
                </form>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    </body>
</html>