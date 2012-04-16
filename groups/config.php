<?php
include 'dbinfo.php';
include_once 'mhd.php' ;
session_start ();
try {
    $dbh = new PDO("mysql:host=$server;dbname=$database", $user_name, $password);
    }
catch(PDOException $e)
    {
    echo $e->getMessage();
    echo 'FFFFFFFFFFF!';
    return;
    }
$test_ip = $_SERVER ['REMOTE_ADDR'];
$GroupAdd=$SiteURL.'groups/';
$MyRoot=dirname(__FILE__).'/';
$MyClasses=$MyRoot.'classes/';
?>