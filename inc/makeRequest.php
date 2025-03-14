<?php
//Include this with every page
session_start();
require_once("checkAuth.php");
require_once("apiRequest.php");

$payload = isset($_POST['payload']) ? json_decode($_POST['payload'],true) : null;
$headers = isset($_POST['headers']) ? json_decode($_POST['headers'], true) : null;

echo (json_encode(apiRequest($_POST['url'],$_POST['method'] ?? 'GET',$_POST['tokenType'],$payload,$headers)));