<?php
/*include ("imenc.php");*/
/*** mysql hostname ***/
$hostname = 'localhost';

/*** trader ***/
$database = 'schoolgate';

/*** mysql username ***/
$username = 'root';

/*** mysql password ***/
$password = '';

try {
    $dbh = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    
    }
catch(PDOException $e)
    {
    echo $e->getMessage();
    }
?>