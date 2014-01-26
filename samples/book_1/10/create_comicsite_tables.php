<?php
require 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or 
  die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

// Vytvo�te tabulku komiksov�ch postav.
$query = 'CREATE TABLE IF NOT EXISTS comic_character (
            character_id  INTEGER UNSIGNED     NOT NULL AUTO_INCREMENT,
            alias         VARCHAR(40)          NOT NULL DEFAULT "",
            real_name     VARCHAR(80)          NOT NULL DEFAULT "",
            lair_id       INTEGER UNSIGNED     NOT NULL DEFAULT 0,
            alignment     ENUM("dobro", "zlo") NOT NULL DEFAULT "dobro",

            PRIMARY KEY (character_id)
          )
          ENGINE=MyISAM';
mysql_query($query, $db) or die (mysql_error($db));

// Vytvo�te tabulku schopnost� komiksov�ch postav.
$query = 'CREATE TABLE IF NOT EXISTS comic_power (
            power_id  INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
            power     VARCHAR(40)      NOT NULL DEFAULT "",

            PRIMARY KEY (power_id)
          )
          ENGINE=MyISAM';
mysql_query($query, $db) or die (mysql_error($db));

// Vytvo�te vazebn� tabulku poostav a schopnost�.
$query = 'CREATE TABLE IF NOT EXISTS comic_character_power (
            character_id  INTEGER UNSIGNED NOT NULL DEFAULT 0,
            power_id      INTEGER UNSIGNED NOT NULL DEFAULT 0,

            PRIMARY KEY (character_id, power_id)
          )
          ENGINE=MyISAM';
mysql_query($query, $db) or die (mysql_error($db));

// Vytvo�te tabulku pro doupata.
$query = 'CREATE TABLE IF NOT EXISTS comic_lair (
            lair_id     INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
            zipcode_id  CHAR(5)          NOT NULL DEFAULT "00000",
            address     VARCHAR(40)      NOT NULL DEFAULT "",

            PRIMARY KEY (lair_id)
          )
          ENGINE=MyISAM';
mysql_query($query, $db) or die (mysql_error($db));

// Vytvo�te tabulku pro informace o m�st� doup�t�.
$query = 'CREATE TABLE IF NOT EXISTS comic_zipcode (
            zipcode_id  CHAR(5)     NOT NULL DEFAULT "00000",
            city        VARCHAR(40) NOT NULL DEFAULT "",
            state       CHAR(2)     NOT NULL DEFAULT "",

            PRIMARY KEY (zipcode_id)
          )
          ENGINE=MyISAM';
mysql_query($query, $db) or die (mysql_error($db));

// Vytvo�te tabulku rival�.
$query = 'CREATE TABLE IF NOT EXISTS comic_rivalry (
            hero_id     INTEGER UNSIGNED  NOT NULL DEFAULT 0,
            villain_id  INTEGER UNSIGNED  NOT NULL DEFAULT 0,

            PRIMARY KEY (hero_id, villain_id)
          )
          ENGINE=MyISAM';
mysql_query($query, $db) or die (mysql_error($db));

echo 'Hotovo.';
?>