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
            case "movieFinderReload";
                $this->movieFinderReload();
                break;
            case "likeMovie";
                $this->likeMovie();
                break;
            case "watchedMovie";
                $this->watchedMovie();
                break;
            case "friends";
                $this->friends();
                break;
            case "addToWatchlist";
                $this->addToWatchlist();
                break;
            case "logout":
                $this->destroyCookies();
                break;
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
                    $wrongCredentials = $this->db->query("insert into `securityLog`(`email`, `name`, `password`) VALUES (?,?,?)", "sss", $_POST["email"], $_POST["name"], $_POST["password"]);
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

    private function friends(){
        unset($_SESSION['userSearch']);
        $friends = $this->getFriends();
        $requests = $this->getFriendRequests();
        if (isset($_POST["email"])){
            $users = $this->db->query("select name, email from user where email = ?;", "s", $_POST["email"]);
            $_SESSION['userSearch'] = $users;
        }
        include("templates/friends.php");
    }

    private function getFriends(){
        $_SESSION["userID"] = $this->db->query("select id from user where email = ?;", "s", $_SESSION["email"]);
        $friends = $this->db->query("select name, email FROM friends NATURAL JOIN user WHERE friend_uID = id AND uID = ?;", "i", intval($_SESSION["userID"][0]["id"]));
        $_SESSION["friends"] = $friends;
        return $friends;
    }

    private function getFriendRequests(){
        $_SESSION["userID"] = $this->db->query("select id from user where email = ?;", "s", $_SESSION["email"]);
        $requests = $this->db->query("select name, email FROM friends NATURAL JOIN user WHERE friend_uID = id AND uID = ?;", "i", intval($_SESSION["userID"][0]["id"]));
        $_SESSION["requests"] = [];
        return $requests;
    }

    private function getWatchlist(){
        $_SESSION["userID"] = $this->db->query("select id from user where email = ?;", "s", $_SESSION["email"]);
        $watchlist = $this->db->query("select movie from watchlist where uid = ?;", "i", intval($_SESSION["userID"][0]["id"]));
        $_SESSION["watchlist"] = $watchlist;
        return $watchlist;
    }

    private function getAlreadyWatched(){
        $_SESSION["userID"] = $this->db->query("select id from user where email = ?;", "s", $_SESSION["email"]);
        $watched = $this->db->query("select movie from has_watched where uid = ?;", "i", intval($_SESSION["userID"][0]["id"]));
        $_SESSION["watched"] = $watched;
        return $watched;
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
        $likes = $this->getLikes();
        $watched = $this->getAlreadyWatched();
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
                $count = $this->db->query("select count(*) from movie where Title = ?;", "s", $_POST["title"]);
                $numOfMovies = $count[0]["count(*)"];

                $_SESSION["MovieInfo"] = array();

                for ($x = 0; $x < $numOfMovies; $x++){
                    $_SESSION["theMovieTitle"] = $theMovie[$x]["Title"];
                    $TheMovieInfo = $this->getMovieInfo();
                    array_push($_SESSION['MovieInfo'], $TheMovieInfo);
                }
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

        private function likeMovie(){
            if (isset($_GET["movieTitleID"])){
                $movieTitleID = $_GET["movieTitleID"];
                $user = $this->db->query("select * from user where email = ?;", "s", $_SESSION["email"] );
                // Need to make sure not already liked
                $alreadyLiked = $this->db->query("select * from likes where uid = ? and movie = ?", "is", intval($_SESSION["userID"][0]["id"]), $movieTitleID );

                if (empty($alreadyLiked)) {
                    $insertLike = $this->db->query("insert into likes (uid, movie) values (?,?)", "is", intval($_SESSION["userID"][0]["id"]), $movieTitleID );
                    if ($insertLike === false){
                        $error_msg = "Error inserting profile";
                    } else {
                        include("templates/movieFinder.php");                    
                    }
                }
                else{
                    $unlikeMovie = $this->db->query("delete from likes where uid = ? and movie = ?", "is", intval($_SESSION["userID"][0]["id"]), $movieTitleID);
                    include("templates/movieFinder.php");
                }
            } else{
                $_SESSION["likeError"] = "Unable to like movie";
                include("templates/movieFinder.php");            }
        }

        private function watchedMovie(){
            if (isset($_GET["movieTitleID"])){
                $movieTitleID = $_GET["movieTitleID"];
                $user = $this->db->query("select * from user where email = ?;", "s", $_SESSION["email"] );
                // Need to make sure not already in has_watched
                $alreadyWatched = $this->db->query("select * from has_watched where uid = ? and movie = ?", "is", intval($_SESSION["userID"][0]["id"]), $movieTitleID );

                if (empty($alreadyWatched)) {
                    $insertWatched = $this->db->query("insert into has_watched (uid, movie) values (?,?)", "is", intval($_SESSION["userID"][0]["id"]), $movieTitleID );
                    if ($insertWatched === false){
                        $error_msg = "Error inserting profile";
                    } else {
                        include("templates/movieFinder.php");                    }
                }
                else{
                    $unwatchMovie = $this->db->query("delete from has_watched where uid = ? and movie = ?", "is", intval($_SESSION["userID"][0]["id"]), $movieTitleID);
                    include("templates/movieFinder.php");
                }
            } else{ //need to fix this
                $_SESSION["watchedError"] = "Unable to add to has watched list";
                include("templates/movieFinder.php");            }
        }

        private function addToWatchlist(){
            if (isset($_GET["movieTitleID"])){
                $movieTitleID = $_GET["movieTitleID"];
                $user = $this->db->query("select * from user where email = ?;", "s", $_SESSION["email"] );
                // Need to make sure not already on watchlist
                $alreadyOnList = $this->db->query("select * from watchlist where uid = ? and movie = ?", "is", intval($_SESSION["userID"][0]["id"]), $movieTitleID );

                if (empty($alreadyOnList)) {
                    $insertWatchlist = $this->db->query("insert into watchlist (uid, movie) values (?,?)", "is", intval($_SESSION["userID"][0]["id"]), $movieTitleID );
                    if ($insertWatchlist === false){
                        $error_msg = "Error inserting profile";
                    } else {
                        include("templates/movieFinder.php");                    }
                }
                else{
                    $unWatchlistMovie = $this->db->query("delete from watchlist where uid = ? and movie = ?", "is", intval($_SESSION["userID"][0]["id"]), $movieTitleID);
                    include("templates/movieFinder.php");
                }
            } else{ //need to fix this
                $_SESSION["watchlistError"] = "Unable to add to watchlist";
                include("templates/movieFinder.php");            }
        }
}