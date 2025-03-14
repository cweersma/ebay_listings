<?php
require_once('config.php');
global $apiauth;
function oauthRequest(array $postData, string $env) : array {
    global $apiauth;
    $grantUrl = "https://api.".($env == "sandbox" ? "sandbox." : "")."ebay.com/identity/v1/oauth2/token";
    $credentials = $apiauth[$env];
    $headers = [
        'Content-Type: application/x-www-form-urlencoded',
        'Authorization: Basic ' . base64_encode($credentials['clientId'] . ':' . $credentials['clientSecret'])
    ];
    $body = http_build_query(data: $postData, encoding_type: PHP_QUERY_RFC3986);
    $ch = curl_init($grantUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    $responseJson = json_decode(curl_exec($ch),true);
    if (isset($responseJson['error'])){
        throw new Exception($responseJson['error'].": ".$responseJson['error_description']);
    }
    return $responseJson;
}