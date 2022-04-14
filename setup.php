<?php

spl_autoload_register(function($classname) {
    include "classes/$classname.php";
});

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$db = new mysqli(Config::$db["host"], 
Config::$db["user"], Config::$db["pass"], 
Config::$db["database"]);

