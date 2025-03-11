<?php
//Include this with every page
session_start();
require_once("inc/checkAuth.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>NPC eBay Listing Automation (<?php echo $_SESSION['env']; ?>)</title>
        <link rel="stylesheet" href="style/main.css" type="text/css" />
        <link rel="stylesheet" href="style/<?php echo $_SESSION['env']; ?>.css" type="text/css" />
        <script>
            function $(id){
                return document.getElementById(id);
            }
            window.onload = () => {
                $("logout").addEventListener("click",() => {
                    window.location = "logout.php";
                });
            }
        </script>
    </head>
    <body>
        <h1>NPC eBay Listing Automation (<?php echo $_SESSION['env']; ?>)</h1>
        <button id="logout">Log Out</button>
        <a href="apitest.php">eBay API test form</a>
    </body>
</html>