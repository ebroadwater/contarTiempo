<?php 
error_reporting(E_ALL);
ini_set("display_errors", 1);

spl_autoload_register(function ($classname) {
    // include "/opt/src/Web-PL-Project/$classname.php";
    // include "/Applications/MAMP/htdocs/contarTiempo copy/$classname.php";
    include "/D:/XAMPP/htdocs/contarTiempo/$classname.php";
});
        
$time = new TimeController($_GET);

$time->run();