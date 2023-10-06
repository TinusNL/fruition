CREATE TABLE userRoles (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    role VARCHAR(255) NOT NULL
);

CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    userRoleId INT(11) NOT NULL,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    profile_image LONGBLOB,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_userRoleId FOREIGN KEY (userRoleId) REFERENCES userRoles(id)
);

CREATE TABLE seasons (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    season VARCHAR(255) NOT NULL
);

CREATE TABLE types (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(255) NOT NULL
);

CREATE TABLE items (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    userId INT(11) NOT NULL,
    name VARCHAR(255) NOT NULL,
    typeId INT(11) NOT NULL,
    seasonId INT(11) NOT NULL,
    location LONGTEXT NOT NULL,

    CONSTRAINT fk_userId FOREIGN KEY (userId) REFERENCES users(id),
    CONSTRAINT fk_typeId FOREIGN KEY (typeId) REFERENCES types(id),
    CONSTRAINT fk_seasonId FOREIGN KEY (seasonId) REFERENCES seasons(id)
);

CREATE TABLE submission_approval (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    approved BOOLEAN NOT NULL,
    userId INT(11) NOT NULL,
    itemId INT(11) NOT NULL,

    CONSTRAINT fk_userId FOREIGN KEY (userId) REFERENCES users(id),
    CONSTRAINT fk_itemId FOREIGN KEY (itemId) REFERENCES items(id)
);

/////////////////////////////////////////////////////////////////////////

CREATE TABLE user_roles(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    role VARCHAR(255) NOT NULL
);

CREATE TABLE users(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    userRoleId INT(11) NOT NULL,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone_number VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    profile_image LONGBLOB,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_userRoleId FOREIGN KEY (userRoleId) REFERENCES user_roles(id)
);

CREATE TABLE seasons(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    season VARCHAR(255) NOT NULL
);

CREATE TABLE types(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(255) NOT NULL
);

CREATE TABLE items(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    userId INT(11) NOT NULL,
    name VARCHAR(255) NOT NULL,
    typeId INT(11) NOT NULL,
    seasonId INT(11) NOT NULL,
    location LONGTEXT NOT NULL,

    CONSTRAINT fk_userId FOREIGN KEY (userId) REFERENCES users(id),
    CONSTRAINT fk_typeId FOREIGN KEY (typeId) REFERENCES types(id),
    CONSTRAINT fk_seasonId FOREIGN KEY (seasonId) REFERENCES seasons(id)
);

CREATE TABLE submissions(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    approved BOOLEAN NOT NULL,
    userId INT(11) NOT NULL,
    itemId INT(11) NOT NULL,

    CONSTRAINT fk_sa_userId FOREIGN KEY (userId) REFERENCES users(id),
    CONSTRAINT fk_itemId FOREIGN KEY (itemId) REFERENCES items(id)
);