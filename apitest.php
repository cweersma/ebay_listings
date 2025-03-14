<?php
//Include this with every page
session_start();
require_once("inc/checkAuth.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>eBay API test (<?php echo $_SESSION['env']; ?>)</title>
        <link rel="stylesheet" href="style/main.css" type="text/css" />
        <link rel="stylesheet" href="style/<?php echo $_SESSION['env']; ?>.css" type="text/css" />
        <script type="text/javascript" src="script/request.js"></script>
        <script>
            function $(id){
                return document.getElementById(id);
            }
            window.onload = () => {
                $("submitRequest").addEventListener("click", () => {
                    let tokenType = null;
                    if ($("tokenUser").checked){
                        tokenType = "user";
                    }
                    else if($("tokenApp").checked){
                        tokenType = "application";
                    }
                    let headersObj = {};
                    let headersArray = $("headers").value.split("/\r?\n/");
                    for (let i=0; i<headersArray.length; i++){
                        let headerComponents = headersArray[i].split(": ");
                        headersObj[headerComponents[0]] = headerComponents[1];
                    }
                    apiRequest($("path").value,$("method").value,tokenType,$("payload").value,JSON.stringify(headersObj))
                        .then(resultObj => { return JSON.parse(resultObj)});
                });
                $("clearBtn").addEventListener("click",() => {
                    $("path").value = "";
                    $("headers").value = "";
                    $("payload").value = "";
                });
            }
        </script>
        <style>
            #path, #headers { width: 50ch; }
            #headers { height: 5em; }
            #payload { width: 50vw; height: 30vh; }
        </style>
    </head>
    <body>
        <h1>eBay API test (<?php echo $_SESSION['env']; ?>)</h1>
        <div id="input">
            <h2>Input</h2>
            <label for="path">Endpoint URL:</label> <?php echo $_SESSION['env'] == "sandbox" ? "https://api.sandbox.ebay.com/" : "https://api.ebay.com/";?><input type="text" id="path"/>
            <select id="method">
                <option value="GET" selected>GET</option>
                <option value="POST">POST</option>
                <option value="PUT">PUT</option>
                <option value="DELETE">DELETE</option>
            </select>
            <br/>
            <label for="token">Token type:</label>
            <fieldset id="token">
                <label for="tokenUser">User</label><input type="radio" id="tokenUser" name="token" value="user" checked />
                <label for="tokenApp">Application</label><input type="radio" id="tokenApp" name="token" value="app" />
            </fieldset>
            <label for="headers">Headers (Authorization included by default):</label><textarea id="headers" title="Each header should go on its own line."></textarea><br/>
            <label for="payload">Payload:</label><textarea id="payload"></textarea><br/>
            <button id="submitRequest">Submit</button><button id="clearBtn">Clear</button>
        </div>
        <div id="output">
            <h2>Output</h2>
            Raw response:
            <div id="response"></div>
        </div>
    </body>
</html>
