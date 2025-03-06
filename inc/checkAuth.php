<?php
require_once 'inc/apiauth.php';
global $apiauth;

//First we need to check whether we're on sandbox or production. If we're not on either, boot the user to the home page to choose
if (!$_SESSION['env']){
    header('Location: https://nis.npcautomotive.com/ebay_listings');
    die();
}

//Check to see if we have an active, unexpired access token; refresh it if necessary.
if (!isset($_SESSION['ebay_access_token_'.$_SESSION['env']]) || $_SESSION['ebay_access_token_expires_'.$_SESSION['env']] >= time()){
    //If the refresh token exists, retrieve it; else send the user to authorize.php
    if (!file_exists("/tmp/ebay_refresh_token_".$_SESSION['env'])){
        header('Location: https://nis.npcautomotive.com/ebay_listings');
        die();
    }
    $refresh_token = file_get_contents("/tmp/ebay_refresh_token_".$_SESSION['env']);
    $credentials = $apiauth[$_SESSION['env']];
    $url = "https://api.".($_SESSION['env'] == "sandbox" ? "sandbox." : "")."ebay.com/identity/v1/oauth2/token";
    $headers = [
        'Content-Type: application/x-www-form-urlencoded',
        'Authorization: Basic '.base64_encode($credentials['clientId'].':'.$credentials['clientSecret'])
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=refresh_token&refresh_token=".$refresh_token);
    $response = curl_exec($ch);
    curl_close($ch);
    $responseJson = json_decode($response, true);
    $_SESSION['ebay_access_token_'.$_SESSION['env']] = $responseJson['access_token'];
    $_SESSION['ebay_access_token_expires_'.$_SESSION['env']] = time() + $responseJson['expires_in'];
}
