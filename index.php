<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>NPC eBay Listing Automation</title>
        <script>
            window.onload = function(){
                document.getElementById("sandbox").addEventListener("click",function(){
                    window.location = "inc/setSession.php?env=sandbox";
                });
                document.getElementById("production").addEventListener("click",function(){
                    window.location = "inc/setSession.php?env=production";
                });
            }
        </script>
    </head>
    <body>
        <h1>NPC eBay Listing Automation</h1>
        <p>Choose which eBay environment you will be working in to continue.</p>
        <p>(note: this refers only to the eBay environment, not the NPC databases. Production NPC data is read in either case.)</p>
        <button id="sandbox">Sandbox</button><button id="production">Production</button>
    </body>
</html>