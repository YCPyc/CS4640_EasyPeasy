<!-- CS Server: https://cs4640.cs.virginia.edu/jp6ax/Easypeasy/ -->
<!-- Page by Yancheng Pan and Jun Song Park -->
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