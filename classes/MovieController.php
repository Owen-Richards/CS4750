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
            case "movieAccount";
                $this->movieAccount();
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
                    header("Location: ?command=movieAccount");
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
                    header("Location: ?command=movieAccount");
                }
            }
        }
        include("templates/login.php");
    }
    private function movieHomepage(){
        include("templates/movieHomepage.php");
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

    private function movieAccount(){
        $watchlist = $this->getWatchlist();
        // // $this->logger->debug("Loaded transaction", $transactions);
        // $totalBalance = $this->currentBalance();
        // // $this->logger->debug("Loaded total Balance", $totalBalance);
        $likes = $this->getLikes();
        // // $this->logger->debug("Loaded Category Balance", $catBalance);

        include("templates/movieAccount.php");
    }

    private function movieFinder(){
        unset($_SESSION['MovieInfo']);
        if (isset($_POST["t_date"])){
            if ($_POST["t_date"] > 1800){
                $theMovie = $this->db->query("select * from movie where Year = ?;", "i", $_POST["t_date"]);
                $count = $this->db->query("select count(*) from movie where Year = ?;", "i", $_POST["t_date"]);
                $numOfMovies = $count[0]["count(*)"];

                $_SESSION["MovieInfo"] = array();

                for ($x = 0; $x < $numOfMovies; $x++){
                    $_SESSION["theMovieTitle"] = $theMovie[$x]["Title"];
                    $TheMovieInfo = $this->getMovieInfo();
                    array_push($_SESSION['MovieInfo'], $TheMovieInfo);
                }
            }
            elseif ( strlen($_POST["title"]) > 0){
                $theMovie = $this->db->query("select * from movie where Title = ?;", "s", $_POST["title"]);
                $MovieQuery = $this->getMoviePoster();
                
            }
            elseif (($_POST["rating"]) > 0){
                $theMovie = $this->db->query("select * from movie where Rotten_Tomatoes = ?;", "s", strval($_POST["rating"]) . "/100");
                $count = $this->db->query("select count(*) from movie where Rotten_Tomatoes = ?;", "s", strval($_POST["rating"]) . "/100");
                $numOfMovies = $count[0]["count(*)"];

                $_SESSION["MovieInfo"] = array();

                for ($x = 0; $x < $numOfMovies; $x++){
                    $_SESSION["theMovieTitle"] = $theMovie[$x]["Title"];
                    $TheMovieInfo = $this->getMovieInfo();
                    array_push($_SESSION['MovieInfo'], $TheMovieInfo);
                }
            }
            elseif (strlen(($_POST["director"])) > 0){
                $theMovie = $this->db->query("select * FROM movie NATURAL JOIN directs WHERE directorName = ?;", "s", $_POST["director"]);
                $count = $this->db->query("select count(*) FROM movie NATURAL JOIN directs WHERE directorName = ?;", "s", $_POST["director"]);
                $numOfMovies = $count[0]["count(*)"];

                $_SESSION["MovieInfo"] = array();

                for ($x = 0; $x < $numOfMovies; $x++){
                    $_SESSION["theMovieTitle"] = $theMovie[$x]["Title"];
                    $TheMovieInfo = $this->getMovieInfo();
                    array_push($_SESSION['MovieInfo'], $TheMovieInfo);
                }
            }
            elseif (strlen(($_POST["service"])) > 0){
                $theMovie = $this->db->query("select Title,Year,Age,Rotten_Tomatoes FROM movie NATURAL JOIN is_on WHERE movieTitle=Title AND serviceName LIKE CONCAT('%', ?, '%');", "s", $_POST["service"]);
                $count = $this->db->query("select count(*) FROM movie NATURAL JOIN is_on WHERE movieTitle=Title AND serviceName LIKE CONCAT('%', ?, '%');", "s", $_POST["service"]);
                $numOfMovies = $count[0]["count(*)"];


                $_SESSION["MovieInfo"] = array();

                for ($x = 0; $x < $numOfMovies; $x++){
                    $_SESSION["theMovieTitle"] = $theMovie[$x]["Title"];
                    $TheMovieInfo = $this->getMovieInfo();
                    array_push($_SESSION['MovieInfo'], $TheMovieInfo);
                }
            }
        }
        include("templates/movieFinder.php");
    }


    // private function getMoviePoster(){
    //     $baseURL = "https://api.themoviedb.org/3/search/movie?api_key=46caf8e2c80595f99f27e9d1a3a820b4";
    //     if (strlen($_POST["title"]) > 0){
    //         $query = urlencode($_POST["title"]);
    //     }
    //     elseif (isset($_SESSION["theMovieTitle"])){
    //         $query = urlencode($_SESSION["theMovieTitle"]);
    //     }
    //     else{
    //         $query = urlencode("superbad");
    //     }
    //     $theURL = $baseURL . "&query=" . $query;
    //     $MovieQuery = json_decode(file_get_contents($theURL), true);
    //     $posterPath = $MovieQuery["results"][0]["poster_path"];
    //     $thePoster = "https://image.tmdb.org/t/p/original/" . $posterPath;
    //     return $thePoster ;}

    private function getMovieInfo(){
        $baseURL = "https://api.themoviedb.org/3/search/movie?api_key=46caf8e2c80595f99f27e9d1a3a820b4";
        if (strlen($_POST["title"]) > 0){
            $query = urlencode($_POST["title"]);
        }
        elseif (isset($_SESSION["theMovieTitle"])){
            $query = urlencode($_SESSION["theMovieTitle"]);
        }
        else{
            $query = urlencode("superbad");
        }
        $theURL = $baseURL . "&query=" . $query;
        $MovieQuery = json_decode(file_get_contents($theURL), true);
        $movieSummary = $MovieQuery["results"][0]["overview"];
        $posterPath = $MovieQuery["results"][0]["poster_path"];
        $thePoster = "https://image.tmdb.org/t/p/original/" . $posterPath;
        $posterAndSummary = [$thePoster, $_SESSION["theMovieTitle"], $movieSummary];
        return $posterAndSummary;}

        // private function getDirectors(){

        // }


        // $triviaData = json_decode(
        //     file_get_contents("https://opentdb.com/api.php?amount=1&category=26&difficulty=easy&type=multiple")
        //     , true);
        // Return the question
        // return $triviaData["results"][0];
}