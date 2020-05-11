<?php
    session_start();
    if (!isset($_SESSION["uid"]) && isset($_COOKIE["authToken"])) {
        include_once("php/restricted/db-functions.php");
        $userID = validateToken($_COOKIE["authToken"]);
        $userID === false ? setcookie("authToken", "", 1) : $_SESSION["uid"] = $userID;
    }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Feed | VSCO</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" type="image/ico" href="images/favicon.ico">
	</head>
	<body>
	</body>
</html>