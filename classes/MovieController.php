<?php

class MovieController {
    private $command;

    private $db;
    
    private $logger;

    public function __construct($command) {
        //***********************************
        // If we use Composer to include the Monolog Logger
        global $log;
        $this->logger = new \Monolog\Logger("MovieController");
        $this->logger->pushHandler($log);
        //***********************************

        $this->command = $command;

        $this->db = new Database();
    }

    public function run() {
        switch($this->command) {
            case "movieHomepage";
                $this->movieHomepage();
                break;
            case "movieFinder";
                $this->movieFinder();
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
            $data = $this->db->query("select * from user where email = ?;", "s", $_POST["email"]);
            if ($data === false) {
                $error_msg = "Error checking for user";
            } else if (!empty($data)) {
                if (password_verify($_POST["password"], $data[0]["password"])) {
                    setcookie("name", $data[0]["name"], time() + 3600);
                    setcookie("email", $data[0]["email"], time() + 3600);
                    $_SESSION["name"] = $data[0]["name"];
                    $_SESSION["email"] = $data[0]["email"];
                    header("Location: ?command=movieHomepage");
                } else {
                    $error_msg = "Wrong password";
                    header("location:?msg=failed");
                }
            } else { 
                $insert = $this->db->query("insert into user (name, email, password) values (?, ?, ?);", 
                        "sss", $_POST["name"], $_POST["email"], 
                        password_hash($_POST["password"], PASSWORD_DEFAULT));
                if ($insert === false) {
                    $error_msg = "Error inserting user";
                } else {
                    setcookie("name", $_POST["name"], time() + 3600);
                    setcookie("email", $_POST["email"], time() + 3600);
                    $_SESSION["name"] = $_POST["name"];
                    $_SESSION["email"] = $_POST["email"];
                    header("Location: ?command=movieHomepage");
                }
            }
        }
        include("templates/login.php");
    }

    private function getWatchlist(){
        $_SESSION["userID"] = $this->db->query("select id from user where email = ?;", "s", $_SESSION["email"]);
        $watchlist = $this->db->query("select movie from watchlist where uid = ?;", "i", intval($_SESSION["userID"][0]["id"]));
        $_SESSION["watchlist"] = $watchlist;
        return $watchlist;
    }

    // private function currentBalance(){
    //     $currentBal = $this->db->query("select sum(amount) as balance from hw5_transaction where user_id = ?;", "i", intval($_SESSION["userID"][0]["id"]));   
    //     $_SESSION["currentBalance"] = $currentBal;
    //     return $currentBal;     
    // }

    private function getLikes(){
        $likes = $this->db->query("select movie from likes where uid = ?;", "i", intval($_SESSION["userID"][0]["id"]));
        $_SESSION["likes"] = $likes;
        return $likes;         
    }

    private function movieHomepage(){
        $watchlist = $this->getWatchlist();
        // // $this->logger->debug("Loaded transaction", $transactions);
        // $totalBalance = $this->currentBalance();
        // // $this->logger->debug("Loaded total Balance", $totalBalance);
        $likes = $this->getLikes();
        // // $this->logger->debug("Loaded Category Balance", $catBalance);

        include("templates/movieHomepage.php");
    }

    private function movieFinder(){
        if (isset($_POST["t_date"])){
            if ($_POST["t_date"] > 1800){
                $theMovie = $this->db->query("select * from movie where Year = ?;", "i", $_POST["t_date"]);
            }
            elseif ( strlen($_POST["tile"]) > 0){
                $theMovie = $this->db->query("select * from movie where Title = ?;", "s", $_POST["tile"]);
            }
            elseif (($_POST["rating"]) > 0){
                $theMovie = $this->db->query("select * from movie where Rotten_Tomatoes = ?;", "s", strval($_POST["rating"]) . "/100");
            }
        }

        // if (isset($_POST["tile"])){
        //     $theMovie = $this->db->query("select * from movie where Title = ?;", "s", $_POST["tile"]);
        //     // if ($theMovie === false) {
        //     //     $error_msg = "Error inserting transaction";
        //     // }
        //     // else {
        //     //     $_SESSION["movie"] = $theMovie
        //     // }

        // }
        // if (isset($_POST["rating"])){
        //     $theMovie = $this->db->query("select * from movie where Rotton_Tomatoes = ?;", "i", $_POST["rating"]);
        // }
        // if (isset($_POST["t_date"])){
        //     $theMovie = $this->db->query("select * from movie where Year = ?;", "i", $_POST["t_date"]);
        // }
        include("templates/movieFinder.php");
    }

    // private function newTransaction(){
    //     if (isset($_POST["type"])){
    //         if ($_POST["type"] == "Debit"){
    //             $insert = $this->db->query("insert into hw5_transaction (id, user_id, name, category, t_date, amount, type) values (NULL, ?, ?, ?, ?, ?, ?);", 
    //                 "isssds", intval($_SESSION["userID"][0]["id"]),$_POST["name"],$_POST["category"], $_POST["t_date"], -$_POST["amount"],$_POST["type"]);
    //             if ($insert === false) {
    //                 $error_msg = "Error inserting transaction";
    //             }
    //         } 
    //         else if ($_POST["type"] == "Credit"){
    //             $insert = $this->db->query("insert into hw5_transaction (id, user_id, name, category, t_date, amount, type) values (NULL, ?, ?, ?, ?, ?, ?);", 
    //                 "isssds", intval($_SESSION["userID"][0]["id"]),$_POST["name"],$_POST["category"], $_POST["t_date"], $_POST["amount"],$_POST["type"]);
    //             if ($insert === false) {
    //                 $error_msg = "Error inserting transaction";
    //             }
    //         }
            
    //     }
    //     include("templates/newTransaction.php");

    // }
}