<?php
//Set the session variable and use inc/checkAuth.php to validate
try {
    session_start();
    $_SESSION['env'] = $_GET['env'];
}
catch (Exception $e) {
    die("Improper query string");
}
require_once("checkAuth.php"); //This will check the access token and ensure that it's valid for this session

//We'll get here if checkAuth succeeds, so redirect to main.php
header('Location: https://nis.npcautomotive.com/ebay_listings/main.php');
die();
