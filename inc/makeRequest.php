<?php
//Include this with every page
session_start();
require_once("checkAuth.php");
require_once("apiRequest.php");
$payload = null;
$headers = null;
if (isset($_POST['payload']){
    $payload = json_decode($_POST['payload'],true);
}
if (isset($_POST['headers'])){
    $headers = json_decode($_POST['headers'],true);
}

echo (json_encode(apiRequest($_POST['url'],$_POST['method'] ?? 'GET',$_POST['tokenType'],$payload,$headers)));