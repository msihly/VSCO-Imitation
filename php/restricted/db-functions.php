<?php
require_once("db-connect.php");
include_once("logging.php");

/******************************* USERS / ACCOUNTS *******************************/
function getLoginInfo($username) {
    GLOBAL $conn;
    $query = "SELECT      u.UserID,  u.PasswordHash
              FROM        User AS u
              WHERE       u.Username = :username;";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return empty($result) ? false : $result[0];
}

function getPass($userID) {
    GLOBAL $conn;
    $query = "SELECT      u.PasswordHash
              FROM        User AS u
              WHERE       u.UserID = :userID;";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":userID", $userID);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return empty($result) ? false : $result[0]["PasswordHash"];
}

function getProfileInfo($userID) {
    GLOBAL $conn;
    $query = "SELECT      u.Username, u.Email, u.FirstName, u.LastName, u.Company, u.DateCreated, u.Active
              FROM        User AS u
              WHERE       u.UserID = :userID;";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":userID", $userID);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return empty($result) ? false : $result[0];
}

function getUser($username) {
    GLOBAL $conn;
    $query = "SELECT      u.UserID
              FROM        User AS u
              WHERE       u.Username = :username;";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return empty($result) ? false : $result[0]["UserID"];
}

function register($username, $email, $password, $firstName = null, $lastName = null, $company = null) {
    GLOBAL $conn;
    $dateCreated = date('Y-m-d H:i:s');
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = "INSERT INTO User (Username, Email, PasswordHash, FirstName, LastName, Company, DateCreated)
                VALUES (:username, :email, :passwordHash, :firstName, :lastName, :company, :dateCreated);";
    $query = $conn->prepare($stmt);
    $query->bindParam(":username", $username);
    $query->bindParam(":email", $email);
    $query->bindParam(":passwordHash", $passwordHash);
    $query->bindParam(":firstName", $firstName);
    $query->bindParam(":lastName", $lastName);
    $query->bindParam(":company", $company);
    $query->bindParam(":dateCreated", $dateCreated);
    $query->execute();

    return $conn->lastInsertId();
}

function updatePass($userID, $passwordHash) {
    GLOBAL $conn;
    $query = "UPDATE      User AS u
              SET         u.PasswordHash = :passwordHash
              WHERE       u.UserID = :userID;";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":userID", $userID);
    $stmt->bindParam(":passwordHash", $passwordHash);
    $stmt->execute();

    return true;
}

function updateProfile($userID, $firstName, $lastName, $email, $company) {
    GLOBAL $conn;
    $query = "UPDATE      User AS u
              SET         u.FirstName = :firstName, u.LastName = :lastName, u.Email = :email, u.Company = :company
              WHERE       u.UserID = :userID;";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":userID", $userID);
    $stmt->bindParam(":firstName", $firstName);
    $stmt->bindParam(":lastName", $lastName);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":company", $company);
    $stmt->execute();

    return true;
}

/******************************* AUTHENTICATION TOKENS *******************************/
function createToken($userID, $days) {
    GLOBAL $conn;
    $selector = base64_encode(random_bytes(15));
    $validator = base64_encode(random_bytes(33));
    $validatorHash = hash("sha256", $validator);
    $expiryDate = date("Y-m-d H:i:s", time() + (86400 * $days));

    $query = "INSERT INTO Token (Selector, ValidatorHash, ExpiryDate, UserID)
                VALUES (:selector, :validatorHash, :expiryDate, :userID);";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":selector", $selector);
    $stmt->bindParam(":validatorHash", $validatorHash);
    $stmt->bindParam(":expiryDate", $expiryDate);
    $stmt->bindParam(":userID", $userID);
    $stmt->execute();

    return $selector . ":" . $validator;
}

function deleteToken($selector) {
    GLOBAL $conn;
    if (strlen($selector) !== 20) {
        logToFile("Invalid selector $selector", "e");
        return false;
    }

    $query = "DELETE
              FROM        Token
              WHERE       Selector = :selector;";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":selector", $selector);
    $stmt->execute();

    return true;
}

function validateToken($token) {
    GLOBAL $conn;
    if (strpos($token, ":") === false) {
        logToFile("Failed to find ':' in token $token", "e");
        return false;
    }

    list($selector, $validator) = explode(":", $token);

    if (strlen($selector) !== 20 || strlen($validator) !== 44) {
        logToFile("Invalid length of selector [$selector] or validator [$validator]", "e");
        return false;
    }

    $validatorHash = hash("sha256", $validator);

    $query = "SELECT      t.ValidatorHash, t.ExpiryDate, t.UserID
              FROM        Token AS t
              WHERE       t.Selector = :selector;";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":selector", $selector);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($result) || !hash_equals($result[0]["ValidatorHash"], $validatorHash)) {
        logToFile("Selector lookup failed or validator does not match", "e");
        return false;
    } else if (time() - strtotime($result[0]["ExpiryDate"]) > 0) {
        $deleteResult = deleteToken($conn, $selector);
        if ($deleteResult) { logToFile("Token [$token] has expired and been deleted"); }
        else { logToFile("Failed to delete token [$token]", "e"); }
        return false;
    }

    return $result[0]["UserID"];
}

/******************************* POSTS *******************************/
function getFeedPosts($userID = null) {
    GLOBAL $conn;

    if (!is_null($userID)) {
        $query = "SELECT      u1.Username AS Author, u2.Username AS Sharer, p.PostURL, p.DateCreated AS PostDate, i.ImagePath, i.ImageSize, i.DateCreated AS ImageDate
                  FROM        Follower AS f INNER JOIN Post AS p
                                  ON f.UserID = p.SharerID
                              INNER JOIN User AS u1
                                  ON p.AuthorID = u1.UserID
                              INNER JOIN User AS u2
                                  ON p.SharerID = u2.UserID
                  WHERE       f.FollowerID = :userID
                  ORDER BY    p.DateCreated DESC
                  LIMIT       140;";
    } else {
        $query = "SELECT      u.Username AS Author, p.PostURL, p.DateCreated AS PostDate, i.ImagePath, i.ImageSize, i.DateCreated AS ImageDate
                  FROM        Post AS p INNER JOIN User AS u
                                  ON p.AuthorID = u.UserID
                  ORDER BY    p.DateCreated DESC
                  LIMIT       140;";
    }

    $stmt = $conn->prepare($query);
    $stmt->bindParam(":userID", $userID);
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return empty($posts) ? [] : $posts;
}

function getPost($postID) {
    GLOBAL $conn;
    $query = "SELECT      u.Username, p.DateCreated AS PostDate, i.ImagePath, i.ImageSize, i.DateCreated AS ImageDate
              FROM        Post AS p INNER JOIN Images AS i
                              ON p.ImageID = i.ImageID
                          INNER JOIN User AS u
                              ON p.AuthorID = u.UserID
              WHERE       p.PostID = :postID;";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":postID", $postID);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return empty($result) ? false : $result[0];
}

?>