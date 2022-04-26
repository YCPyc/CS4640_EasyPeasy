<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

spl_autoload_register(function($classname){
    include "classes/$classname.php";
});

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$db = new mysqli(Config::$db["host"],Config::$db["user"],Config::$db["pass"],Config::$db["database"]);

$db->query("drop table if exists user");
$db->query("create table user (
            userId varchar(50) not null,
            name text not null,
            password text not null,
            primary key (userId)
        );");     

$db->query("drop table if exists recipe");
$db->query("create table recipe (
            recipeId varchar(50) not null,
            userId varchar(50) not null,
            description text not null,
            primary key (recipeId)
        );");

$db->query("drop table if exists ingredient");
$db->query("create table ingredient (
            ingredientId int not null auto_increment,
            recipeId varchar(50) not null,
            measurement int not null,
            unit text not null,
            item text not null,
            primary key (ingredientId)
        );");