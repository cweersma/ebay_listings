<?php
/* -------- Configuration information --------- */

/*
 * This configuration provides necessary credentials and other information required for the Listings Automation
 * to interact with eBay. This information will need to be provided at the time of installation and revised
 * whenever changes are made (keyset changes, site root is moved, etc.)
 *
*/

/* ------------------------------------------------------------------- */
/* Server details */

/* $baseURL must be specified as the URL path corresponding with the directory in which this repository is installed. */
$baseURL = "";

/* Database credentials
 *
 * Credentials for each database connection are supplied here. These should point to the production copies of the
 * respective databases, but can be changed to other copies if needed for testing.
 *
*/

$db['WP'] = [
    "host" => "localhost",
    "username" => "",
    "password" => "",
    "database" => "",
];
$db['NIS'] = [
    "host" => "localhost",
    "username" => "",
    "password" => "",
    "database" => "",
];

/* ------------------------------------------------------------------- */

/* eBay Application Keys (found at https://developer.ebay.com/my/keys)
 *
 * For each environment, provide the following information in $apiauth:
 * (the following three can be found at https://developer.ebay.com/my/keys)
 *
 * "clientId": the App ID
 * "devId": the Dev ID
 * "clientSecret": the Cert ID
 *
 * "ruName" is the eBay Redirect URL name, which is automatically generated
 * when you add a Redirect URL under the "Your eBay Sign-in Settings" section on the
 * User Access Tokens page at https://developer.ebay.com/my/auth?env=sandbox&index=0
 * (for sandbox) or https://developer.ebay.com/my/auth?env=production&index=0 (for production).
 *
 * When creating this Redirect URL, make sure "Your auth accepted URL" points to <<baseURL>>/reauth.php
 * (where <<baseURL>> is the URL specified for $baseURL above).
 *
*/
$apiauth = [
    "sandbox"=> [
        "clientId" => "",
        "devId" => "",
        "clientSecret" => "",
        "ruName" => ""
    ],
    "production"=> [
        "clientId" => "",
        "devId" => "",
        "clientSecret" => "",
        "ruName" => ""
    ]
];