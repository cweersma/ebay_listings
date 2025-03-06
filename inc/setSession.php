<?php
//Set the session variable and use inc/checkAuth.php to validate
session_start(["env"=>$_GET["env"]]);
require_once("inc/checkAuth.php"); //This will check the access token and ensure that it's valid for this session

//We'll get here if checkAuth succeeds, so redirect to main.php
header('Location: https://nis.npcautomotive.com/ebay_listings/main.php');
die();
