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
                <div class="col-xs-8 mx-auto">
                <form action="?command=movieAccount" method="post">
 
                    <?php if (count($_SESSION["watchlist"]) > 0): ?>
                        <table class="center">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION["watchlist"] as $row): array_map('htmlentities', $row); ?>
                                <tr>
                                    <td><?php echo implode($row); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>

                    <?php if (count($_SESSION["watchlist"]) <= 0): ?>
                        <h4> You have no movies. </h4>
                    <?php endif; ?>
                    
                    <br>
                    
                    <h2> Movies you have liked: </h2>
                    <?php if (count($_SESSION["likes"]) > 0): ?>
                        <table class="center">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION["likes"] as $row): array_map('htmlentities', $row); ?>
                                <tr>
                                    <td><?php echo implode($row);?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>

                    <?php if (count($_SESSION["likes"]) <= 0): ?>
                        <h4> You have no liked movies </h4>
                    <?php endif; ?> 

                    <br>

                    <h2> Movies you have watched: </h2>
                    <?php if (count($_SESSION["watched"]) > 0): ?>
                        <table class="center">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION["watched"] as $row): array_map('htmlentities', $row); ?>
                                <tr>
                                    <td><?php echo implode($row); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>

                    <?php if (count($_SESSION["watched"]) <= 0): ?>
                        <h4> You have not watched any movies. </h4>
                    <?php endif; ?>

                </form>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    </body>
</html>