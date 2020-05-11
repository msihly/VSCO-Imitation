<?php
require_once("restricted/db-functions.php");
include_once("restricted/logging.php");

try {
    if (isset($_SESSION["uid"])) {
        $userID = $_SESSION["uid"];
        $posts = getFeedPosts($userID);
        echo json_encode(["Success" => true, "Posts" => $posts]);
    } else {
        $posts = getFeedPosts();
        echo json_encode(["Success" => true, "Posts" => $posts]);
    }
} catch(PDOException $e) {
    logToFile("Error: " . $e->getMessage(), "e");
	echo json_encode(["Success" => false, "Message" => "Error logged to file"]);
}

$conn = null;
?>