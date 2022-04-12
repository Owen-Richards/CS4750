<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">  

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="CS4750">
        <meta name="description" content="CS4750 Homepage">          

        <title>Homepage</title>
        <!-- <link rel="icon" type="image/x-icon" href="img/favicon.ico"> -->

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

        <link href="css/Carousel.css" rel="stylesheet"> 
        <link href="css/Homepage.css" rel="stylesheet"> 
        <script src="javascript/Homepage.js"></script>
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
                            <a class="nav-link" href="?command=movieAccount">Your Account</a>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <a href="?command=logout" class="btn btn-danger">Logout</a>
                    </form>
                </div>
            </div>
        </nav>
        
        <!-- Slideshow container -->
        <div class="slideshow-container fade">
            <!-- Full images with numbers and message Info -->
            <div class="Containers">
                <div class="MessageInfo">1 / 3</div>
                <img src="../images/1917.jpg" style="width:100%">
                <div class="Info">First caption</div>
            </div>
            
            <div class="Containers">
                <div class="MessageInfo">2 / 3</div>
                <img src="../images/interstellar.jpg" style="width:100%">
                <div class="Info">Second Caption</div>
            </div>
            
            <div class="Containers">
                <div class="MessageInfo">3 / 3</div>
                <img src="../images/xmen.jpg" style="width:100%">
                <div class="Info">Third Caption</div>
            </div>
            
            <!-- Back and forward buttons -->
            <a class="Back" onclick="plusSlides(-1)">&#10094;</a>
            <a class="forward" onclick="plusSlides(1)">&#10095;</a>
        </div>
        <br>
        
        <!-- The circles/dots -->
        <div style="text-align:center">
            <span class="dots" onclick="currentSlide(1)"></span>
            <span class="dots" onclick="currentSlide(2)"></span>
            <span class="dots" onclick="currentSlide(3)"></span>
        </div> 

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    </body>
</html>