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
        <script>
            function $(id){
                return document.getElementById(id);
            }
            window.onload = function(){
                $("submitRequest").addEventListener("click", function(e){
                    let url = $("path").value;
                    if (!url){
                        alert("URL path required");
                        return;
                    }
                    fetch("inc/makeRequest.php", {
                        method: "POST",
                        body: new URLSearchParams({
                            'url': url,
                            'headers': $("headers").value,
                            'payload': $("payload").value,
                            'method': $("method").value
                        })
                    }).then(response => { return response.text(); }).then(resultText => { $("response").innerHTML = resultText; });
                });
                $("clearBtn").addEventListener("click",function(e){
                    $("path").text = "";
                    $("headers").text = "";
                    $("payload").text = "";
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
