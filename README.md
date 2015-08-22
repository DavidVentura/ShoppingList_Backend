# ShoppingList Backend

##Installation

###Database
You can either use MySQL or SQLite. SQLite is easier to set up.

####SQLite
Just edit your config.php so that<br>
```php $database = 'SQLite'; ```<br>
The file/database should get created automatically.<br>

####MySQL
Just edit your config.php so that<br>
```php $database = 'MySQL'; ```<br><br>
The sql command does the following things.<br>
Please replace user, password and host where necessary.<br>
1. Create a user.<br>
2. Create a database.<br>
3. Create a table with the necessary structure.<br>
4. Grant all privileges only on the newly created database and table for the new user.<br>
5. Refresh the privileges.<br>

```SQL
CREATE USER 'newuser'@'localhost' IDENTIFIED BY 'password';
CREATE DATABASE shopping;
USE shopping;
CREATE TABLE ShoppingList (
item VARCHAR(255),
count VARCHAR(255),
RID int(11) NOT NULL auto_increment,
primary KEY (RID))
ENGINE=InnoDB DEFAULT COLLATE=utf8_general_ci;
GRANT ALL PRIVILEGES ON shopping.ShoppingList TO 'newuser'@'localhost';
FLUSH PRIVILEGES;
```

### PHP files

In config.php replace to match your details from above.<br>
```php
<?php
    
    //password used for app
	$authKey = "Your Password For The App Here";
	
	$dataBase = "SQLite or MySQL";
	//only for SQLite
	$SQLiteConfig = [
        'file' => "shoppinglist.sqlite",
	];
	//only for MySQL
	$MySQLConfig = [
        'host' => "host",
        'db' => "db",
        'user' => "user",
        'password' => "password",
    ];
?>
```

## Feedback
Please do never hesitate to open an issue!<br>
I know there a some bugs, most likely because I had no idea how to do it otherwise and therefore had to use a workaround.
