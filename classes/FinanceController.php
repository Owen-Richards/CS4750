<?php

class FinanceController {
    private $command;

    private $db;
    
    private $logger;

    public function __construct($command) {
        //***********************************
        // If we use Composer to include the Monolog Logger
        global $log;
        $this->logger = new \Monolog\Logger("FinanceController");
        $this->logger->pushHandler($log);
        //***********************************

        $this->command = $command;

        $this->db = new Database();
    }

    public function run() {
        switch($this->command) {
            case "transactionHistory";
                $this->transactionHistory();
                break;
            case "newTransaction";
                $this->newTransaction();
                break;
            case "logout":
                $this->destroyCookies();
            case "login":
            default:
                $this->login();
        }
    }

    private function destroyCookies() {
        setcookie("name", "", time() - 3600);
        setcookie("email", "", time() - 3600);
        session_destroy();
    }

    private function login() {
        if (isset($_POST["email"])) {
            $data = $this->db->query("select * from hw5_user where email = ?;", "s", $_POST["email"]);
            if ($data === false) {
                $error_msg = "Error checking for user";
            } else if (!empty($data)) {
                if (password_verify($_POST["password"], $data[0]["password"])) {
                    setcookie("name", $data[0]["name"], time() + 3600);
                    setcookie("email", $data[0]["email"], time() + 3600);
                    $_SESSION["name"] = $data[0]["name"];
                    $_SESSION["email"] = $data[0]["email"];
                    // setcookie("score", $data[0]["score"], time() + 3600);
                    header("Location: ?command=transactionHistory");
                } else {
                    $error_msg = "Wrong password";
                }
            } else { 
                $insert = $this->db->query("insert into hw5_user (name, email, password) values (?, ?, ?);", 
                        "sss", $_POST["name"], $_POST["email"], 
                        password_hash($_POST["password"], PASSWORD_DEFAULT));
                if ($insert === false) {
                    $error_msg = "Error inserting user";
                } else {
                    setcookie("name", $_POST["name"], time() + 3600);
                    setcookie("email", $_POST["email"], time() + 3600);
                    $_SESSION["name"] = $_POST["name"];
                    $_SESSION["email"] = $_POST["email"];
                    header("Location: ?command=transactionHistory");
                }
            }
        }
        include("templates/login.php");
    }

    private function previousTransactions(){
        $_SESSION["userID"] = $this->db->query("select id from hw5_user where email = ?;", "s", $_SESSION["email"]);
        $transactionslist = $this->db->query("select * from hw5_transaction where user_id = ? order by t_date desc;", "i", intval($_SESSION["userID"][0]["id"]));
        $_SESSION["transactionList"] = $transactionslist;
        return $transactionslist;
    }

    private function currentBalance(){
        $currentBal = $this->db->query("select sum(amount) as balance from hw5_transaction where user_id = ?;", "i", intval($_SESSION["userID"][0]["id"]));   
        $_SESSION["currentBalance"] = $currentBal;
        return $currentBal;     
    }

    private function categoryBalance(){
        $categoryBal = $this->db->query("select category, sum(amount) as balance from hw5_transaction where user_id = ? group by category;", "i", intval($_SESSION["userID"][0]["id"]));
        $_SESSION["categoryBalance"] = $categoryBal;
        return $categoryBal;         
    }

    private function transactionHistory(){
        $transactions = $this->previousTransactions();
        // $this->logger->debug("Loaded transaction", $transactions);
        $totalBalance = $this->currentBalance();
        // $this->logger->debug("Loaded total Balance", $totalBalance);
        $catBalance = $this->categoryBalance();
        // $this->logger->debug("Loaded Category Balance", $catBalance);

        include("templates/transactionHistory.php");
    }

    private function newTransaction(){
        if (isset($_POST["type"])){
            if ($_POST["type"] == "Debit"){
                $insert = $this->db->query("insert into hw5_transaction (id, user_id, name, category, t_date, amount, type) values (NULL, ?, ?, ?, ?, ?, ?);", 
                    "isssds", intval($_SESSION["userID"][0]["id"]),$_POST["name"],$_POST["category"], $_POST["t_date"], -$_POST["amount"],$_POST["type"]);
                if ($insert === false) {
                    $error_msg = "Error inserting transaction";
                }
            } 
            else if ($_POST["type"] == "Credit"){
                $insert = $this->db->query("insert into hw5_transaction (id, user_id, name, category, t_date, amount, type) values (NULL, ?, ?, ?, ?, ?, ?);", 
                    "isssds", intval($_SESSION["userID"][0]["id"]),$_POST["name"],$_POST["category"], $_POST["t_date"], $_POST["amount"],$_POST["type"]);
                if ($insert === false) {
                    $error_msg = "Error inserting transaction";
                }
            }
            
        }
        include("templates/newTransaction.php");

    }
}