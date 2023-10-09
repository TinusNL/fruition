# Database Structure

[Database File](../MySQL%20Table%20Codes.sql)


## Table Structure
### users
| Column Name   | Data Type        | Constraints                                         |
|---------------|-----------------|-----------------------------------------------------|
| id            | INT(11)         | NOT NULL, AUTO_INCREMENT, PRIMARY KEY              |
| userRoleId    | INT(11)         | NOT NULL, FOREIGN KEY (userRoleId) REFERENCES user_roles(id) |
| username      | VARCHAR(255)    | NOT NULL                                            |
| email         | VARCHAR(255)    | NOT NULL                                            |
| phone_number  | VARCHAR(255)    | NOT NULL                                            |
| password      | VARCHAR(255)    | NOT NULL                                            |
| profile_image | LONGBLOB         |                                                     |
| created_at    | DATETIME         | DEFAULT CURRENT_TIMESTAMP                          |
| updated_at    | DATETIME         | DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP |

### user_roles
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
| userId      | INT(11)         | NOT NULL, FOREIGN KEY (userId) REFERENCES users(id) |
| name        | VARCHAR(255)    | NOT NULL                       |
| typeId      | INT(11)         | NOT NULL, FOREIGN KEY (typeId) REFERENCES types(id) |
| seasonId    | INT(11)         | NOT NULL, FOREIGN KEY (seasonId) REFERENCES seasons(id) |
| location    | LONGTEXT         | NOT NULL                       |

### submissions
| Column Name | Data Type        | Constraints                   |
|-------------|-----------------|-------------------------------|
| id          | INT(11)         | NOT NULL, AUTO_INCREMENT, PRIMARY KEY |
| approved    | BOOLEAN         | NOT NULL                       |
| userId      | INT(11)         | NOT NULL, FOREIGN KEY (userId) REFERENCES users(id) |
| itemId      | INT(11)         | NOT NULL, FOREIGN KEY (itemId) REFERENCES items(id) |
