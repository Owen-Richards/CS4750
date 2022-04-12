<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">  

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="CS4640">
        <meta name="description" content="CS4750 Movie Finder">  

        <title>Movie Finder</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> 
        <link href="css/Homepage.css" rel="stylesheet"> 
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

        <div class="container" style="margin-top: 10px;">
            <div class="row col-xs-8">
                <h1>Movie Finder</h1>
                <p> Search for what movie you would like to watch. </p>
            </div>
            <div class="row justify-content-center">
                <div class="col-4">
                <form action="?command=movieFinder" method="post">
                <div class="mb-3">
                        <label for="title" class="form-label">Title of Movie</label>
                        <input type="text" class="form-control" id="title" name="title" />
                    </div>
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rotten Tomato Rating</label>
                        <input type="number" class="form-control" id="rating" name="rating" />
                    </div>
                    <div class="mb-3">
                        <label for="t_date" class="form-label">Date (year)</label>
                        <input type="number" class="form-control" id="t_date" name="t_date" />
                    </div>
                    <div class="text-center">                
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                    
                    <?php if (isset($MovieQuery)): ?>
                        <p><?php print_r($MovieQuery) ?></p>
                        <img src=<?php print_r($MovieQuery) ?> alt="Italian Trulli" width = 200px height = 300px>
                    <?php endif; ?>

                    <?php if (isset($theMovieTitle)):  ?>
                        <h3>Hello <?=print_r($theMovieTitle)?>, what would you like to watch today?</h3>
                        <h3> Number of movies : <?=print_r($numOfMovies)?></h3>
                    <?php endif; ?>

                    <?php if (isset($_SESSION["ListOfMoviePosters"]) && (count($_SESSION["ListOfMoviePosters"]) > 0) ):  ?>
                        <?php foreach ($_SESSION["ListOfMoviePosters"] as $poster): ?>
                            <p><?php print_r($poster) ?></p>
                            <img src=<?php print_r($poster) ?> alt="Italian Trulli" width = 200px height = 300px>
                        <?php endforeach; ?>
                    <?php endif; ?>



                    <?php if (isset($theMovie)): ?>
                        <table class="center">
                            <thead>
                                <tr>
                                    <th> Title </th>
                                    <th> Release Year</th>
                                    <th> Age Rating </th>
                                    <th> Rotton Tomatoes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($theMovie as $row): array_map('htmlentities', $row); ?>
                                <tr>
                                    <td><?php echo implode('</td><td>', $row); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php endif; 
                    ?>
                </form>
                </div>
            </div>


        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    </body>
</html>