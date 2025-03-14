<?php
require_once 'inc/config.php';
require_once 'inc/oauthRequest.php';

global $apiauth;
global $baseURL;

$code = urldecode($_GET['code']);
$env = $_GET['state'];

//Get access tokens
$userAccess = oauthRequest([
    "grant_type" => "authorization_code",
    "code" => $code,
    "redirect_uri" => $apiauth[$env]['ruName']
],$env);

$applicationAccess = oauthRequest([
    "grant_type" => "client_credentials",
    "scope" => implode(" ",$apiauth['app_scopes'])
],$env);

//Write refresh token to temp file
$refresh_token = $userAccess['refresh_token'];
$fp = fopen("/tmp/ebay_refresh_token_".$env,"w");
fwrite($fp, $refresh_token);
fclose($fp);

//Use access tokens as session variables
$_SESSION['ebay_user_access_token_'.$env] = $userAccess['access_token'];
$_SESSION['ebay_user_access_token_expires_'.$env] = time() + $userAccess['expires_in'];
$_SESSION['ebay_application_access_token_'.$env] = $applicationAccess['access_token'];
$_SESSION['ebay_application_access_token_expires_'.$env] = $applicationAccess['expires_in'];

//Redirect to main.php
header('Location: '.$baseURL.'/main.php');
die();
