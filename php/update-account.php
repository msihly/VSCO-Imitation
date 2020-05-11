<?php
require_once("restricted/db-functions.php");
include_once("restricted/logging.php");

try {
    if(!empty($_POST) && isset($_SESSION["uid"])) {
        $userID = $_SESSION["uid"];
        $formType = $_POST["formType"];

        if ($formType == "profile") {
            $firstName = $_POST["firstName"];
            $lastName = $_POST["lastName"];
            $email = $_POST["email"];
            $company = $_POST["company"];

            if (empty($email)) {
                echo json_encode(["Success" => false, "Message" => "Email field is required"]);
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(["Success" => false, "Message" => "Invalid email"]);
            } else if (!empty($firstName) && strlen($firstName) > 255) {
                echo json_encode(["Success" => false, "Message" => "First name field cannot exceed 255 characters"]);
            } else if (!empty($lastName) && strlen($lastName) > 255) {
                echo json_encode(["Success" => false, "Message" => "Last name field cannot exceed 255 characters"]);
            } else {
                updateProfile($userID, $firstName, $lastName, $email, $company);
                echo json_encode(["Success" => true, "Message" => "Profile updated"]);
            }
        } else if ($formType == "pass") {
            $passCur = $_POST["password"];
            $passNew = $_POST["password-new"];
            $passConf = $_POST["password-confirm"];

            if(empty($passCur) || empty($passNew) || empty($passConf)) {
                echo json_encode(["Success" => false, "Message" => "All fields are required"]);
            } else if (strlen($passNew) < 8) {
                echo json_encode(["Success" => false, "Message" => "New password must be a minimum of 8 characters"]);
            } else if ($passNew != $passConf) {
                echo json_encode(["Success" => false, "Message" => "New Password and Confirm Password mismatch"]);
            } else if ($passCur === $passNew) {
                echo json_encode(["Success" => false, "Message" => "New Password cannot match Current Password"]);
            } else {
                $passHash = getPass($userID);
                if (password_verify($passCur, $passHash)) {
                    updatePass($userID, password_hash($passNew, PASSWORD_DEFAULT));
                    echo json_encode(["Success" => true, "Message" => "Password updated"]);
                } else {
                    echo json_encode(["Success" => false, "Message" => "Current password is incorrect"]);
                }
            }
        } else {
            echo json_encode(["Success" => false, "Message" => "Invalid form information"]);
        }
    } else {
        echo json_encode(["Success" => false, "Message" => "Invalid form information"]);
    }
} catch(PDOException $e) {
    $conn->rollback();
    logToFile("Error: " . $e->getMessage(), "e");
	echo json_encode(["Success" => false, "Message" => "Error logged to file"]);
}

$conn = null;
?>