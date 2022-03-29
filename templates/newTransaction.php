<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">  

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="CS4640">
        <meta name="description" content="CS4640 Trivia Login Page">  

        <title>New Transaction</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> 
        <style>
        
        h1   {
            font-family: Garamond, Baskerville, "Baskerville Old Face", "Hoefler Text", "Times New Roman", serif;
            text-align: center;
            font-size: 35px;
        }
        p   {
            font-family: Garamond, Baskerville, "Baskerville Old Face", "Hoefler Text", "Times New Roman", serif;
            text-align: center;
        }
        </style>

    </head>

    <body>
        <nav class="navbar navbar-expand navbar-dark bg-dark" aria-label="Second navbar example">
            <div class="container-fluid">
                <a class="navbar-brand" href="?command=transactionHistory">Finance Tracker</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarsExample02">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="?command=transactionHistory">Your Transaction History</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?command=newTransaction">New Transaction</a>
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
                <h1>Enter a new transaction</h1>
                <p> This transaction will be added to your transaction history</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-4">
                <form action="?command=newTransaction" method="post">
                <div class="mb-5">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required/>
                    </div>
                    <div class="mb-5">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" class="form-control" id="category" name="category" required/>
                    </div>
                    <div class="mb-5">
                        <label for="t_date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="t_date" name="t_date" required/>
                    </div>
                    <div class="mb-5">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" min="0.00" max="10000.00" step="0.01" class="form-control" id="amount" name="amount" required/>
                    </div>
                    <div class="mb-5">
                        <label for="type" class="form-label">Type</label>
                        <select id="type" class="form-control"  name="type" size="2" required>
                            <option value="Credit">Credit</option>
                            <option value="Debit">Debit</option>
                        </select>
                    </div>
                    <div class="text-center">                
                        <button type="submit" class="btn btn-primary">Submit Transaction</button>
                    </div>
                </form>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    </body>
</html>