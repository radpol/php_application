<?php
require 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or 
  die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

// Vytvo�te tabulku u�ivatel�.
$query = 'CREATE TABLE IF NOT EXISTS site_user (
            user_id     INTEGER     NOT NULL AUTO_INCREMENT,
            username    VARCHAR(20) NOT NULL,
            password    CHAR(41)    NOT NULL,

            PRIMARY KEY (user_id)
          )
          ENGINE=MyISAM';
mysql_query($query, $db) or die (mysql_error($db));

// Vytvo�te tabulku informac� o u�ivatel�ch.
$query = 'CREATE TABLE IF NOT EXISTS site_user_info (
            user_id     INTEGER     NOT NULL,
            first_name  VARCHAR(20) NOT NULL,
            last_name   VARCHAR(20) NOT NULL,
            email       VARCHAR(50) NOT NULL,
            city        VARCHAR(20),
            state       CHAR(2),
            hobbies     VARCHAR(255),

            FOREIGN KEY (user_id) REFERENCES site_user(user_id)
          )
          ENGINE=MyISAM';
mysql_query($query, $db) or die (mysql_error($db));

// Napl�te tabulku u�ivatel�.
$query = 'INSERT IGNORE INTO site_user
            (user_id, username, password)
          VALUES
            (1, "jan", PASSWORD("tajn�")),
            (2, "jana", PASSWORD("heslo"))';
mysql_query($query, $db) or die (mysql_error($db));

// Napl�te tabulku dopl�uj�c�ch informac� o u�ivatel�ch.
$query = 'INSERT IGNORE INTO site_user_info
            (user_id, first_name, last_name, email, city, state, hobbies)
          VALUES
            (1, "Jan", "Nov�k", "jan@priklad.cz", NULL, NULL, NULL),
            (2, "Jana", "Nov�kov�", "jana@priklad.cz", NULL, NULL, NULL)';
mysql_query($query, $db) or die (mysql_error($db));

echo 'P��kaz �sp�n� vykon�n!';
?>