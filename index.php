<?php
// Sources used: https://cs4640.cs.virginia.edu, https://developer.mozilla.org/en-US/docs/Learn/CSS/Building_blocks/Styling_tables, https://www.w3schools.com/css/css_table.asp,
// https://www.php.net/manual/en/mysqli-stmt.bind-param.php, https://getbootstrap.com/docs/5.0/examples/offcanvas-navbar/, https://stackoverflow.com/questions/42648/sql-server-best-way-to-get-identity-of-inserted-row

// Register the autoloader
spl_autoload_register(function($classname) {
    include "classes/$classname.php";
});

//**********************
// If we use Composer to include the Monolog Logger
include "vendor/autoload.php";

use \Monolog\Logger;
use \Monolog\Handler\BrowserConsoleHandler;
$log = new BrowserConsoleHandler();
//**********************

// Parse the query string for command
$command = "login";
if (isset($_GET["command"]))
    $command = $_GET["command"];

// If the user's email is not set in the cookies, then it's not
// a valid session (they didn't get here from the login page),
// so we should send them over to log in first before doing
// anything else!
if (!isset($_COOKIE["email"])) {
    // they need to see the login
    $command = "login";
}

// Instantiate the controller and run
$trivia = new MovieController($command);
session_start();
$trivia->run();