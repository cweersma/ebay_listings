<?php
require_once 'inc/config.php';
global $apiauth;
global $baseURL;

$scopes = urlencode("https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/buy.order.readonly https://api.ebay.com/oauth/api_scope/buy.guest.order https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.marketplace.insights.readonly https://api.ebay.com/oauth/api_scope/commerce.catalog.readonly https://api.ebay.com/oauth/api_scope/buy.shopping.cart https://api.ebay.com/oauth/api_scope/buy.offer.auction https://api.ebay.com/oauth/api_scope/commerce.identity.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.email.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.phone.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.address.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.name.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.status.readonly https://api.ebay.com/oauth/api_scope/sell.finances https://api.ebay.com/oauth/api_scope/sell.payment.dispute https://api.ebay.com/oauth/api_scope/sell.item.draft https://api.ebay.com/oauth/api_scope/sell.item https://api.ebay.com/oauth/api_scope/sell.reputation https://api.ebay.com/oauth/api_scope/sell.reputation.readonly https://api.ebay.com/oauth/api_scope/commerce.notification.subscription https://api.ebay.com/oauth/api_scope/commerce.notification.subscription.readonly https://api.ebay.com/oauth/api_scope/sell.stores https://api.ebay.com/oauth/api_scope/sell.stores.readonly");

function oauthRequest(array $postData, string $env) use ($apiauth) : array {
    $grantUrl = "https://api.".($env == "sandbox" ? "sandbox." : "")."ebay.com/identity/v1/oauth2/token";
    $credentials = $apiauth[$env];
    $headers = [
        'Content-Type: application/x-www-form-urlencoded',
        'Authorization: Basic ' . base64_encode($credentials['clientId'] . ':' . $credentials['clientSecret'])
    ];
    $body = http_build_query($postData);
    $ch = curl_init($grantUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    $response = curl_exec($ch);
    return json_decode($response, true);
}
$code = urldecode($_GET['code']);
$env = $_GET['state'];

//Get user access token
$userAccess = oauthRequest([
    "grant_type" => "authorization_code",
    "code" => $code,
    "redirect_uri" => $apiauth[$env]['ruName']
],$env);

$applicationAccess = oauthRequest([
    "grant_type" => "client_credentials",
    "scope" => $scopes
],$env);

//Write refresh token to temp file
$refresh_token = $userAccess['refresh_token'];
$fp = fopen("/tmp/ebay_refresh_token_".$env,"w");
fwrite($fp, $refresh_token);
fclose($fp);

//Use access tokens as session variable
$_SESSION['ebay_user_access_token_'.$env] = $userAccess['access_token'];
$_SESSION['ebay_user_access_token_expires_'.$env] = time() + $userAccess['expires_in'];
$_SESSION['ebay_application_access_token_'.$env] = $applicationAccess['access_token'];
$_SESSION['ebay_application_access_token_expires_'.$env] = $applicationAccess['expires_in'];

//Redirect to main.php
header('Location: '.$baseURL.'/main.php');
die();
