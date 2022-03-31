<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">  

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="CS4750">
        <meta name="description" content="CS4750 Homepage">  
        

        <title>Homepage</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> 
        <style>
        
        h1   {
            font-family: Garamond, Baskerville, "Baskerville Old Face", "Hoefler Text", "Times New Roman", serif;
            text-align: center;
            font-size: 35px;
            /* background:#42f5b0; */
        }

        h2   {
            font-family: Garamond, Baskerville, "Baskerville Old Face", "Hoefler Text", "Times New Roman", serif;
            text-align: left;
            font-size: 30px;
            /* background:#42f5b0; */
        }

        h3   {
            font-family: Garamond, Baskerville, "Baskerville Old Face", "Hoefler Text", "Times New Roman", serif;
            text-align: center;
            font-size: 20px;
            /* background:#42f5b0; */
        }
        h4   {
            font-family: Garamond, Baskerville, "Baskerville Old Face", "Hoefler Text", "Times New Roman", serif;
            text-align: center;
            font-size: 20px;
            /* background:#42f5b0; */
        }

        table, th, td {
            table-layout: fixed;
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            border: 1px solid black;
            width: 100%;
            /* border-collapse: collapse; */
        }
        td, th {
            border: 1px solid #ddd;
            padding: 8px;
        }
        tr:nth-child(even){
            background-color: #f2f2f2;
            width: 20%;
        }
        tr:hover {
            background-color: #bcebd9;
        }
        th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #9becfa;
            color: solid black;
        }
        table.center {
            margin-left: auto; 
            margin-right: auto;
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
              <a class="nav-link" href="?command=movieHomepage">Your Movies</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="?command=newTransaction">Movie Finder</a>
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
                <h1> Your Watchlist </h1>
                <h3>Hello <?=$_SESSION["name"]?>, what would you like to watch today?</h3>
            </div>
            <br>
            <h2> Movies you intend to watch: </h2>
            <div class="row">
                <div class="col-xs-8 mx-auto">
                <form action="?command=movieHomepage" method="post">
 
                    <?php if (count($_SESSION["transactionList"]) > 0): ?>
                        <table class="center">
                            <thead>
                                <tr>
                                    <th>Transaction ID</th>
                                    <th>User ID</th>
                                    <th> Name of Transaction</th>
                                    <th>Category</th>
                                    <th>Transaction Date</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION["transactionList"] as $row): array_map('htmlentities', $row); ?>
                                <tr>
                                    <td><?php echo implode('</td><td>', $row); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php endif; 
                    ?>
                     <?php if (count($_SESSION["transactionList"]) <= 0): ?>
                        <h4> You have no movies. </h4>
                        <?php endif; 
                    ?>
                    <br>

                    <h2> Movies you have liked: </h2>
                    <?php if (count($_SESSION["categoryBalance"]) > 0): ?>
                        <table class="center">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Sum</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION["categoryBalance"] as $row): array_map('htmlentities', $row); ?>
                                <tr>
                                    <td><?php echo implode('</td><td>', $row); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php endif; 
                    ?>
                    <?php if (count($_SESSION["categoryBalance"]) <= 0): ?>
                        <h4> You have no liked movies </h4>
                        <?php endif; 
                    ?>
                    <br>
                    <!-- <h2> Total Balance: $<?=$_SESSION["currentBalance"][0]["balance"]?> </h2> -->
                </form>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    </body>
</html>