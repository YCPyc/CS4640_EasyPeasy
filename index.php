<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

spl_autoload_register(function($classname){
    include "classes/$classname.php";
});

$command = "mainPage";
if(isset($_GET["command"])){
    $command = $_GET["command"];
}



$epeasy = new EpeasyController($command);
$epeasy->run();