# Using Database

## Structure
[Structure](./Database%20Structure.md)

## Examples

### Select
```php
$stmt = Database::prepare('SELECT * FROM users WHERE id = :id;');
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);
```
### Insert
```php
$stmt = Database::prepare('INSERT INTO users (username, password) VALUES (:username, :password);');
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->bindParam(':password', $password, PDO::PARAM_STR);
$stmt->execute();
```
### Update
```php
$stmt = Database::prepare('UPDATE users SET username = :username, password = :password WHERE id = :id;');
$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->bindParam(':password', $password, PDO::PARAM_STR);
$stmt->execute();
```
### Delete
```php
$stmt = Database::prepare('DELETE FROM users WHERE id = :id;');
$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
$stmt->execute();
```