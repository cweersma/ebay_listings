<?php
//Include this with every page
session_start();
require_once("inc/checkAuth.php");
?>
<html>
    <head>
        <title>eBay API test (<?php echo $_SESSION['env']; ?>)</title>
        <link rel="stylesheet" href="style/main.css" type="text/css" />
        <link rel="stylesheet" href="style/<?php echo $_SESSION['env']; ?>.css" type="text/css" />
        <script>
            window.onload = function(){
                document.getElementById("submit").addEventListener("click", function(){
                    let url = document.getElementById("path").value;
                    if (!url){
                        alert("URL path required");
                        return;
                    }
                    fetch("inc/makeRequest.php",{
                        method: "POST",
                        body: new URLSearchParams({
                            'url': document.getElementById("path").value,
                            'headers': document.getElementById("headers").value,
                            'payload': document.getElementById("payload").value,
                            'method': document.getElementById("method").value
                        })
                    ).then(response => response.text)
                        .then(resultText => { document.getElementById("response").innerHTML = resultText; });
                    })
                });
            }
        </script>
    </head>
    <body>
        <h1>eBay API test (<?php echo $_SESSION['env']; ?>)</h1>
        <div id="input">
            <h2>Input</h2>
            Endpoint URL: <?php echo $_SESSION['env'] == "sandbox" ? "https://api.sandbox.ebay.com/" : "https://api.ebay.com/";?><input type="text" id="path"/>
            <select id="method">
                <option value="GET" selected>GET</option>
                <option value="POST">POST</option>
                <option value="PUT">PUT</option>
                <option value="DELETE">DELETE</option>
            </select>
            <br/>
            <label for="headers">Headers (Authorization included by default):</label><textarea id="headers" title="Each header should go on its own line."></textarea><br/>
            <label for="payload">Payload:</label><textarea id="payload"></textarea><br/>
            <button id="submit">Submit</button>
        </div>
        <div id="output">
            <h2>Output</h2>
            Raw response:
            <div id="response"></div>
        </div>
    </body>
</html>
