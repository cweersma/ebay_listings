<?php
require_once 'vendor/autoload.php';
require_once 'inc/config.php';

use EbayOauthToken\EbayOauthToken;

/**
 * @param string $content A JSON string to be sent as the request body
 * @param bool $sandbox Whether this is a sandbox call
 * @return void
 * @throws Exception
 */
function ebayRequest(string $content, bool $sandbox = false) {
    global $apiauth;
    $credentials = $apiauth[$sandbox ? 'sandbox' : 'production'];
    $ebayAuthToken = new EbayOauthToken([
        'env' => ($sandbox ? 'SANDBOX' : 'PRODUCTION'),
        'clientId' => $credentials["clientId"],
        'devId' => $credentials["devId"],
        'clientSecret' => $credentials["clientSecret"]
    ]);
    $headers = [
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . $apiauth[$sandbox ? 'sandbox' : 'production'],
        'Accept' => 'application/json',
        'Accept-Language' => 'en-US',
        'Content-Language' => 'en-US'
    ];
    //Everything we need to do should use the Inventory API, so we'll use that as our base URI.
    $baseURI = "https://api.".($sandbox ? 'sandbox.' : '')."ebay.com/sell/inventory/v1/";

}