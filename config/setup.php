<?php
require('./database.php');
try
{
    $request = "USE jeguglie_camagru;
                CREATE TABLE comments (img_id INT(11) NOT NULL, comment VARCHAR(255) NOT NULL,
                username VARCHAR(255) NOT NULL, date DATE NOT NULL);
                CREATE TABLE likes (username VARCHAR(255) NOT NULL, img_id INT(11) NOT NULL);
                CREATE TABLE pictures (username VARCHAR(255) NOT NULL, img_link VARCHAR(255) NOT NULL,
                likes INT(11) NOT NULL, comments INT(11) NOT NULL, id INT(11) AUTO_INCREMENT NOT NULL, date DATE NOT NULL, img_filter VARCHAR(255) NOT NULL, PRIMARY KEY (id));
                CREATE TABLE users (username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, 
                mail VARCHAR(255) NOT NULL, valid_key VARCHAR(32) DEFAULT 0 NOT NULL, active INT(1) DEFAULT 0 NOT NULL, password_key VARCHAR(32) NOT NULL,
                send_link INT(1) DEFAULT 0 NOT NULL, new_comment INT(11) DEFAULT 1)";
    $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $bdd->exec($request);
    echo "Database successfully created.\n";
}
catch (PDOException $e)
{
    die("DB ERROR: ". $e->getMessage());
}