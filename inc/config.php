<?php
/* -------- Configuration information --------- */

/*
 * This configuration provides necessary credentials and other information required for the Listings Automation
 * to interact with eBay. This information will need to be provided at the time of installation and revised
 * whenever changes are made (keyset changes, site root is moved, etc.)
 *
*/

/* ------------------------------------------------------------------- */

/* eBay Application Keys (found at https://developer.ebay.com/my/keys)
 *
 * For each environment, provide the following information in $apiauth:
 * (the following three can be found at https://developer.ebay.com/my/keys)
 *
 * "clientId": the App ID
 * "devId": the Dev ID
 * "clientSecret": the Cert ID
*/
$apiauth = [
    "sandbox"=> [
        "clientId" => "",
        "devId" => "",
        "clientSecret" => ""
    ],
    "production"=> [
        "clientId" => "",
        "devId" => "",
        "clientSecret" => ""
    ]
];

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