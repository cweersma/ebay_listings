<?php
require_once 'inc/config.php';
global $apiauth;
global $baseURL;
$code = $_GET['code'];
$env = $_GET['state'];
$grantUrl = "https://api.".($env == "sandbox" ? "sandbox." : "")."ebay.com/identity/v1/oauth2/token";
$credentials = $apiauth[$env];
$headers = [
    'Content-Type: application/x-www-form-urlencoded',
    'Authorization: Basic ' . base64_encode($credentials['clientId'] . ':' . $credentials['clientSecret'])
];
$body = "grant_type=authorization_code&code=$code&redirect_uri=" . $credentials['redirect_uri'];
$ch = curl_init($grantUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
$response = curl_exec($ch);
$responseJson = json_decode($response, true);

//Write refresh token to temp file
$refresh_token = $responseJson['refresh_token'];
$fp = fopen("/tmp/ebay_refresh_token_".$env,"w");
fwrite($fp, $refresh_token);
fclose($fp);

//Use access token as session variable
$_SESSION['ebay_access_token_'.$env] = $responseJson['access_token'];
$_SESSION['ebay_access_token_expires_'.$env] = time() + $responseJson['expires_in'];

//Redirect to main.php
header('Location: '.$baseURL.'/main.php');
die();