<?php
require_once 'config.php';
require_once 'oauthRequest.php';

global $apiauth;
global $baseURL;

//First we need to check whether we're on sandbox or production. If we're not on either, boot the user to the home page to choose
if (!$_SESSION['env']){
    header('Location: '.$baseURL);
    die();
}

//Check to see if we have an active, unexpired user access token; refresh it if necessary.
if (!isset($_SESSION['ebay_user_access_token_'.$_SESSION['env']]) || $_SESSION['ebay_user_access_token_expires_'.$_SESSION['env']] >= time()){
    //If the refresh token exists, retrieve it; else send the user to authorize.php
    if (!file_exists("/tmp/ebay_refresh_token_".$_SESSION['env'])){
        header('Location: '.$baseURL.'/authorize.php');
        die();
    }
    $refresh_token = file_get_contents("/tmp/ebay_refresh_token_".$_SESSION['env']);
    if ($refresh_token == ""){
        header('Location: '.$baseURL.'/authorize.php');
        die();
    }

    $userAccess = oauthRequest([
        "grant_type" => "refresh_token",
        "refresh_token" => $refresh_token,
        "scope" => implode(" ",$apiauth['user_scopes'])
    ],$_SESSION['env']);

    $_SESSION['ebay_user_access_token_'.$_SESSION['env']] = $userAccess['access_token'];
    $_SESSION['ebay_user_access_token_expires_'.$_SESSION['env']] = time() + $userAccess['expires_in'];
}
if (!isset($_SESSION['ebay_application_access_token_'.$_SESSION['env']]) || $_SESSION['ebay_application_access_token_expires_'.$_SESSION['env']] >= time()){
    $applicationAccess = oauthRequest([
        "grant_type" => "client_credentials",
        "scope" => implode(" ",$apiauth['app_scopes'])
    ],$_SESSION['env']);
    $_SESSION['ebay_application_access_token_'.$_SESSION['env']] = $applicationAccess['access_token'];
    $_SESSION['ebay_application_access_token_expires_'.$_SESSION['env']] = time() + $applicationAccess['expires_in'];
}