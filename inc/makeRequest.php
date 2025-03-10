<?php
//Include this with every page
session_start();
require_once("checkAuth.php");

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
//Add common headers
$commonHeaders = [
    "Accept: application/json",
    "Accept-Charset: utf-8",
    "Accept-Language: en-US",
    "Authorization: Bearer ".$_SESSION['ebay_access_token_'.$_SESSION['env']],
    "Content-Type: application/json",
    "Content-Language: en-US"
];
$headerArray = array_merge($commonHeaders, $headerArray);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
curl_setopt($ch, CURLOPT_ENCODING,'gzip');
if ($body) curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
$response = curl_exec($ch);

echo $response;

