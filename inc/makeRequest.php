<?php
//Include this with every page
session_start();
require_once("inc/checkAuth.php");

$requestDetails = $_POST;
$url = "https://api.".($_SESSION['env'] == "sandbox" ? "sandbox." : "")."ebay.com/".$requestDetails['url'];
$headers = $requestDetails['headers'] ?? "";
$body = $requestDetails['body'] ?? null;
$method = $requestDetails['method'] ?? "GET";

//Parse any headers passed
$headerArray = [];
if ($headers){
    $headerArray = explode("\n", $headers);
}
//Add Authorization header
$headerArray[] = "Authorization: Bearer ".$_SESSION['ebay_access_token_'.$_SESSION['env']];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
if ($body) curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
$response = curl_exec($ch);

echo $response;

