# Database Structure

[Database File](../MySQL%20Table%20Codes.sql)


## Table Structure
### users
| Column Name   | Data Type        | Constraints                                         |
|---------------|-----------------|-----------------------------------------------------|
| id            | INT(11)         | NOT NULL, AUTO_INCREMENT, PRIMARY KEY              |
| role          | INT(11)         | NOT NULL, FOREIGN KEY (userRoleId) REFERENCES user_roles(id) |
| username      | VARCHAR(255)    | NOT NULL                                            |
| email         | VARCHAR(255)    | NOT NULL                                            |
| phone_number  | VARCHAR(255)    | NOT NULL                                            |
| password      | VARCHAR(255)    | NOT NULL                                            |
| profile_image | VARCHAR(36)     | NULL, FOREING KEY (imagesId) REFERENCES images(id)  |
| created_at    | DATETIME         | DEFAULT CURRENT_TIMESTAMP                          |
| updated_at    | DATETIME         | DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP |

### roles
| Column Name | Data Type        | Constraints                   |
|-------------|-----------------|-------------------------------|
| id          | INT(11)         | NOT NULL, AUTO_INCREMENT, PRIMARY KEY |
| role        | VARCHAR(255)    | NOT NULL                       |

### seasons
| Column Name | Data Type        | Constraints                   |
|-------------|-----------------|-------------------------------|
| id          | INT(11)         | NOT NULL, AUTO_INCREMENT, PRIMARY KEY |
| season      | VARCHAR(255)    | NOT NULL                       |

### types
| Column Name | Data Type        | Constraints                   |
|-------------|-----------------|-------------------------------|
| id          | INT(11)         | NOT NULL, AUTO_INCREMENT, PRIMARY KEY |
| type        | VARCHAR(255)    | NOT NULL                       |

### items
| Column Name | Data Type        | Constraints                   |
|-------------|-----------------|-------------------------------|
| id          | INT(11)         | NOT NULL, AUTO_INCREMENT, PRIMARY KEY |
| author      | INT(11)         | NOT NULL, FOREIGN KEY (userId) REFERENCES users(id) |
| description | LONGTEXT        | NOT NULL                       |
| type        | INT(11)         | NOT NULL, FOREIGN KEY (typeId) REFERENCES types(id) |
| season      | INT(11)         | NOT NULL, FOREIGN KEY (seasonId) REFERENCES seasons(id) |
| longitude   | INT(11)         | NOT NULL                       |
| latitude    | INT(11)         | NOT NULL                       |

### images
| Column Name | Data Type        | Constraints                   |
|-------------|-----------------|-------------------------------|
| id          | VARCHAR(36)     | NOT NULL, PRIMARY KEY         |
| data        | LONGBLOB        | NOT NULL                      |

### submissions
| Column Name | Data Type        | Constraints                   |
|-------------|-----------------|-------------------------------|
| id          | INT(11)         | NOT NULL, AUTO_INCREMENT, PRIMARY KEY |
| approved    | BOOLEAN         | NOT NULL                       |
| user        | INT(11)         | NOT NULL, FOREIGN KEY (userId) REFERENCES users(id) |
| item        | INT(11)         | NOT NULL, FOREIGN KEY (itemId) REFERENCES items(id) |
| created_at    | DATETIME      | DEFAULT CURRENT_TIMESTAMP                          |
| updated_at    | DATETIME      | DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP |