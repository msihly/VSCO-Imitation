/************************** TABLES **************************/
CREATE TABLE IF NOT EXISTS User (
	UserID          INT UNSIGNED NOT NULL AUTO_INCREMENT,
	Username     	VARCHAR(40) NOT NULL,
	Email           VARCHAR(255) NOT NULL,
	PasswordHash    VARCHAR(255) NOT NULL,
	FirstName       VARCHAR(100),
	LastName        VARCHAR(100),
	Company         VARCHAR(255),
	DateCreated		DATETIME,
	Active          TINYINT(1) DEFAULT 1,
		PRIMARY KEY (UserID)
);

CREATE TABLE IF NOT EXISTS Token (
	TokenID         INT UNSIGNED NOT NULL AUTO_INCREMENT,
	Selector        CHAR(20) NOT NULL UNIQUE,
	ValidatorHash   CHAR(64) NOT NULL,
	ExpiryDate      DATETIME NOT NULL,
	UserID       	INT UNSIGNED NOT NULL,
		PRIMARY KEY (TokenID)
);

CREATE TABLE IF NOT EXISTS Follower (
	UserID			INT UNSIGNED NOT NULL,
	FollowerID		INT UNSIGNED NOT NULL,
		PRIMARY KEY (UserID, FollowerID)
);

CREATE TABLE IF NOT EXISTS Post (
	PostID			INT UNSIGNED NOT NULL AUTO_INCREMENT,
	PostURL			VARCHAR(255) NOT NULL,
	DateCreated		DATETIME,
	ImageID			INT UNSIGNED NOT NULL,
	AuthorID		INT UNSIGNED NOT NULL,
	SharerID		INT UNSIGNED NOT NULL,
		PRIMARY KEY (PostID)
);

CREATE TABLE IF NOT EXISTS Images (
    ImageID         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    ImagePath		VARCHAR(94) NOT NULL,
    ImageHash       VARCHAR(32) NOT NULL UNIQUE,
    ImageSize       INT,
    DateCreated		DATETIME,
        PRIMARY KEY (ImageID)
);

/************************** FOREIGN KEYS **************************/
ALTER TABLE Token
	ADD CONSTRAINT fk_token_user
		FOREIGN KEY (UserID) REFERENCES User (UserID);

ALTER TABLE Post
	ADD CONSTRAINT fk_post_image
		FOREIGN KEY (ImageID) REFERENCES Images (ImageID),
	ADD CONSTRAINT fk_post_author
		FOREIGN KEY (AuthorID) REFERENCES User (UserID),
	ADD CONSTRAINT fk_post_sharer
		FOREIGN KEY (SharerID) REFERENCES User (UserID);

ALTER TABLE Follower
	ADD CONSTRAINT fk_follower_user
		FOREIGN KEY (UserID) REFERENCES User (UserID),
	ADD CONSTRAINT fk_follower_follower
		FOREIGN KEY (FollowerID) REFERENCES User (UserID);