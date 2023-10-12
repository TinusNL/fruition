# Database Structure

[Database File](./fruition-database.sql)

## Table Structure
### users
| Column Name   | Data Type        | Constraints                                         |
|---------------|-----------------|-----------------------------------------------------|
| id            | INT(11)         | NOT NULL, AUTO_INCREMENT, PRIMARY KEY              |
| role          | INT(11)         | NOT NULL, FOREIGN KEY (userRoleId) REFERENCES user_roles(id) |
| username      | VARCHAR(255)    | NOT NULL                                            |
| email         | VARCHAR(255)    | NOT NULL                                            |
| password      | VARCHAR(255)    | NOT NULL                                            |
| profile_image | VARCHAR(36)     | NULL, FOREING KEY (imagesId) REFERENCES images(id)  |
| created_at    | DATETIME         | DEFAULT CURRENT_TIMESTAMP                          |
| updated_at    | DATETIME         | DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP |

### roles
| Column Name | Data Type        | Constraints                   |
|-------------|-----------------|-------------------------------|
| id          | INT(11)         | NOT NULL, AUTO_INCREMENT, PRIMARY KEY |
| name        | VARCHAR(255)    | NOT NULL                       |

### seasons
| Column Name | Data Type        | Constraints                   |
|-------------|-----------------|-------------------------------|
| id          | INT(11)         | NOT NULL, AUTO_INCREMENT, PRIMARY KEY |
| name      | VARCHAR(255)    | NOT NULL                       |
| start      | DATE    | NOT NULL                       |
| end      | DATE    | NOT NULL                       |


### types
| Column Name | Data Type        | Constraints                   |
|-------------|-----------------|-------------------------------|
| id          | INT(11)         | NOT NULL, AUTO_INCREMENT, PRIMARY KEY |
| name        | VARCHAR(255)    | NOT NULL                       |
| season      | INT(11)         | NOT NULL, FOREIGN KEY (seasonId) REFERENCES seasons(id) |

### items
| Column Name | Data Type        | Constraints                   |
|-------------|-----------------|-------------------------------|
| id          | INT(11)         | NOT NULL, AUTO_INCREMENT, PRIMARY KEY |
| author      | INT(11)         | NOT NULL, FOREIGN KEY (userId) REFERENCES users(id) |
| description | LONGTEXT        | NOT NULL                       |
| type        | INT(11)         | NOT NULL, FOREIGN KEY (typeId) REFERENCES types(id) |
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
| item        | INT(11)         | NOT NULL, FOREIGN KEY (itemId) REFERENCES items(id) |
| admin       | INT(11)         | NOT NULL, FOREIGN KEY (userId) REFERENCES users(id) |
| created_at  | DATETIME      | DEFAULT CURRENT_TIMESTAMP                          |
| updated_at  | DATETIME      | DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP |

### favorites
| Column Name | Data Type        | Constraints                   |
|-------------|-----------------|-------------------------------|
| id          | INT(11)         | NOT NULL, AUTO_INCREMENT, PRIMARY KEY |
| user        | INT(11)         | NOT NULL, FOREIGN KEY (userId) REFERENCES users(id) |
| item        | INT(11)         | NOT NULL, FOREIGN KEY (itemId) REFERENCES items(id) |