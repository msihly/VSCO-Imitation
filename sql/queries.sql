/******************************* USERS / ACCOUNTS *******************************/
/* getLoginInfo($username) */
SELECT      u.UserID,  u.PasswordHash
FROM        User AS u
WHERE       u.Username = :username;

/* getPass($userID) */
SELECT      u.PasswordHash
FROM        User AS u
WHERE       u.UserID = :userID;

/* getProfileInfo($userID) */
SELECT      u.Username, u.Email, u.FirstName, u.LastName, u.Company, u.DateCreated, u.Active
FROM        User AS u
WHERE       u.UserID = :userID;

/* getUser($username) */
SELECT      u.UserID
FROM        User AS u
WHERE       u.Username = :username;

/* register($username, $email, $password, $firstName = null, $lastName = null, $company = null) */
/* FEATURE NOT IMPLEMENTED AS SIGNUPS ARE RESTRICTED TO MOBILE APP */
INSERT INTO User (Username, Email, PasswordHash, FirstName, LastName, Company, DateCreated)
    VALUES (:username, :email, :passwordHash, :firstName, :lastName, :company, :dateCreated);

/* updatePass($userID, $passwordHash) */
UPDATE      User AS u
SET         u.PasswordHash = :passwordHash
WHERE       u.UserID = :userID;

/* updateProfile($userID, $firstName, $lastName, $email, $company) */
UPDATE      User AS u
SET         u.FirstName = :firstName, u.LastName = :lastName, u.Email = :email, u.Company = :company
WHERE       u.UserID = :userID;

/******************************* AUTHENTICATION TOKENS *******************************/
/* createToken($userID, $days) */
INSERT INTO Token (Selector, ValidatorHash, ExpiryDate, UserID)
    VALUES (:selector, :validatorHash, :expiryDate, :userID);

/* deleteToken($selector) */
DELETE
FROM        Token
WHERE       Selector = :selector;

/* validateToken($token) */
SELECT      t.ValidatorHash, t.ExpiryDate, t.UserID
FROM        Token AS t
WHERE       t.Selector = :selector;

/******************************* POSTS *******************************/
/* getFeedPosts($userID) */
SELECT      u1.Username AS Author, u2.Username AS Sharer, p.PostURL, p.DateCreated AS PostDate, i.ImagePath, i.ImageSize, i.DateCreated AS ImageDate
FROM        Follower AS f INNER JOIN Post AS p
                ON f.UserID = p.SharerID
            INNER JOIN User AS u1
                ON p.AuthorID = u1.UserID
            INNER JOIN User AS u2
                ON p.SharerID = u2.UserID
WHERE       f.FollowerID = :userID
ORDER BY    p.DateCreated DESC
LIMIT       140;
    /*** Not signed in version ***/
SELECT      u.Username AS Author, p.PostURL, p.DateCreated AS PostDate, i.ImagePath, i.ImageSize, i.DateCreated AS ImageDate
FROM        Post AS p INNER JOIN User AS u
                ON p.AuthorID = u.UserID
ORDER BY    p.DateCreated DESC
LIMIT       140;

/* getPost($postID) */
SELECT      u.Username, p.DateCreated AS PostDate, i.ImagePath, i.ImageSize, i.DateCreated AS ImageDate
FROM        Post AS p INNER JOIN Images AS i
                ON p.ImageID = i.ImageID
            INNER JOIN User AS u
                ON p.AuthorID = u.UserID
WHERE       p.PostID = :postID;