<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">  

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="CS4750">
        <meta name="description" content="CS4750 Account">          

        <title>Account</title>
        <!-- <link rel="icon" type="image/x-icon" href="img/favicon.ico"> -->

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

        <link href="css/Friends.css" rel="stylesheet"> 
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
        </ul>
        <form class="d-flex">
            <a href="?command=logout" class="btn btn-danger">Logout</a>
        </form>
      </div>
    </div>
  </nav>

        <div class="container" style="margin-top: 10px;">
        <h1>Your Friends</h1>
            <div class="d-flex justify-content-around">
                <div id="search" style="margin-top: 1em; margin-right: 1em; margin-left: 1em; min-width:30%" >
                    <h5 style="text-align:center">Search for Friends</h5>
                    <form action="?command=friends" method="post" class="form-horizontal">
                        <div class="form-group mb-3" >
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email"/>
                        </div>
                        <div class="text-center mb-3">                
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>

                        <?php if (isset($_SESSION["userSearch"]) && (count($_SESSION["userSearch"]) > 0) ): ?>
                            <?php foreach ($_SESSION["userSearch"] as $row): ?>
                                <table style="width:100%">
                                    <tbody>
                                        <tr>
                                            <td><?php echo implode('</td><td>', $row); ?></td>
                                            <td style="text-align:center">
                                                <button type="submit" class="btn btn-outline-success btn-sm">Add</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </form>
                </div>
                <div id="requests" style="margin-top: 1em; margin-right: 1em; margin-left: 1em; min-width:30%">
                <?php if (count($_SESSION["requests"]) > 0): ?>
                        <table class="table" >
                            <thead>
                                <tr>
                                    <th>Requests</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION["requests"] as $row): array_map('htmlentities', $row); ?>
                                <tr>
                                    <td><?php echo implode($row); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php endif; 
                    ?>
                    <?php if (count($_SESSION["requests"]) <= 0): ?>
                        <table class="table" >
                            <thead>
                                <tr>
                                    <th>Requests</th>
                                </tr>
                            </thead>
                            <tbody>
                                <td> You have no friend requests </td>
                            </tbody>
                        </table>
                        <?php endif; 
                    ?> 
                </div>
                <div id="friends" style="margin-top: 1em; margin-right: 1em; margin-left: 1em; min-width:30%">
                <?php if (count($_SESSION["friends"]) > 0): ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan=3>Friends</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION["friends"] as $row): array_map('htmlentities', $row); ?>
                                <tr>
                                    <td><?php echo implode('</td><td>', $row); ?></td>
                                    <td style="text-align:center">
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Remove</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php endif; 
                    ?>
                    <?php if (count($_SESSION["friends"]) <= 0): ?>
                        <table class="table" >
                            <thead>
                                <tr>
                                    <th>Friends</th>
                                </tr>
                            </thead>
                            <tbody>
                                <td > You have no friends </td>
                            </tbody>
                        </table>
                        <?php endif; 
                    ?> 
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    </body>
</html>