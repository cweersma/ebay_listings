<?php
//Include this with every page
session_start();
require_once("inc/checkAuth.php");
?>
<html>
    <head>
        <title>NPC eBay Listing Automation (<?php echo $_SESSION['env']; ?>)</title>
        <link rel="stylesheet" href="style/main.css" type="text/css" />
        <link rel="stylesheet" href="style/<?php echo $_SESSION['env']; ?>.css" type="text/css" />
    </head>
    <body>
    </body>
</html>