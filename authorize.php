<?php
global $apiauth;
require_once 'vendor/autoload.php';
require_once 'inc/apiauth.php';
$sandbox = isset($_GET['sandbox']);
$credentials = $apiauth[($sandbox ? 'sandbox' : 'production')];
$clientId = $credentials['client_id'];
$redirectUri = $credentials['ruName'];

$baseUrl = "https://auth.".($sandbox ? "sandbox.": "")."/oauth2/authorize";
$url = $baseUrl."?client_id=".$clientId."&redirect_uri=".$redirectUri."&response_type=code";
?>
<html>
    <head>
        <title>Authorization Required</title>
    </head>
    <body>
        <h1>Access Token Requires Reauthorization</h1>
        <p>
            The refresh token for this application has expired; this may have been because of a password reset or a server reboot.
            To reauthorize the application, click the following button and you will be redirected to eBay's application
            access grant page. Once you have successfully granted access, you will be returned to this application.
        </p>
        <button onclick="window.location = '<?php echo $url; ?>';">Login</button>
    </body>

</html>
