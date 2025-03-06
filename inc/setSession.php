<?php
//Set the session variable and use inc/checkAuth.php to validate
session_start(["env"=>$_GET["env"]]);
require_once("inc/checkAuth.php");