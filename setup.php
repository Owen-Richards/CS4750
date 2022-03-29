<?php

spl_autoload_register(function($classname) {
    include "classes/$classname.php";
});

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$db = new mysqli(Config::$db["host"], 
Config::$db["user"], Config::$db["pass"], 
Config::$db["database"]);

$db->query("drop table if exists hw5_transaction;");
$db->query("create table hw5_transaction (
        id int not null auto_increment,
        user_id int not null,
        name text not null,
        category text not null,
        t_date date not null,
        amount decimal(10,2) not null,
        type text not null,
        primary key (id)
    );");

$db->query("drop table if exists hw5_user;");
$db->query("create table hw5_user (
            id int not null auto_increment,
            email text not null,
            name text not null,
            password text not null,
            primary key (id)
        );");