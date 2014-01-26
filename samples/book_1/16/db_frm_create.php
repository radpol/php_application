<?php
require 'db.inc.php';

date_default_timezone_set('Europe/Prague');

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
  die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');

mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$sql = 'CREATE TABLE IF NOT EXISTS frm_access_levels (
            access_lvl   TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
            access_name  VARCHAR(50)      NOT NULL,

            PRIMARY KEY (access_lvl)
        )
        ENGINE=MyISAM';
mysql_query($sql, $db) or die(mysql_error($db));

$sql = 'INSERT IGNORE INTO frm_access_levels
            (access_lvl, access_name)
        VALUES
            (1, "U�ivatel"),
            (2, "Moder�tor"),
            (3, "Spr�vce")';
mysql_query($sql, $db) or die(mysql_error($db));

$sql = 'CREATE TABLE IF NOT EXISTS frm_admin (
            id       INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
            title    VARCHAR(100)     NOT NULL DEFAULT "",
            value    VARCHAR(255)     NOT NULL DEFAULT "",
            constant VARCHAR(100)     NOT NULL DEFAULT "",

            PRIMARY KEY (id)
        )
        ENGINE=MyISAM';
mysql_query($sql, $db) or die(mysql_error($db));

$sql = 'INSERT IGNORE INTO frm_admin
            (id, title, value, constant)
        VALUES
            (NULL, "Nadpis str�nek", "F�ra pro fanou�ky komiks�", "title"),
            (NULL, "Popis serveru", "M�sto, kde m��ete diskutovat o sv�ch ' .
            'obl�ben�ch komiksech, filmech apod.", "description"),
            (NULL, "Napi�te spr�vci", "admin@priklad.cz", "admin_email"),
            (NULL, "Autorsk� pr�va", "&copy; Web pro fanou�ky komiks�. ' .
            'V�echna pr�va vyhrazena.", "copyright"),
            (NULL, "Z�hlav� str�nek", "F�ra pro fanou�ky komiks�", "titlebar"),
            (NULL, "Limit str�nkov�n�", "10", "pageLimit"),
            (NULL, "Rozsah str�nek", "7", "pageRange")';
mysql_query($sql, $db) or die(mysql_error($db));

$sql = 'CREATE TABLE IF NOT EXISTS frm_bbcode (
            id          INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
            template    VARCHAR(255)     NOT NULL DEFAULT "",
            replacement VARCHAR(255)     NOT NULL DEFAULT "",

            PRIMARY KEY (id)
        )
        ENGINE=MyISAM';
mysql_query($sql, $db) or die(mysql_error($db));


$sql = 'CREATE TABLE IF NOT EXISTS frm_forum (
            id              INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
            forum_name      VARCHAR(100)     NOT NULL DEFAULT "",
            forum_desc      VARCHAR(255)     NOT NULL DEFAULT "",
            forum_moderator INTEGER UNSIGNED NOT NULL DEFAULT 0,

            PRIMARY KEY (id)
        )
        ENGINE=MyISAM';
mysql_query($sql, $db) or die(mysql_error($db));

$sql = 'INSERT IGNORE INTO frm_forum
            (id, forum_name, forum_desc, forum_moderator)
        VALUES
            (NULL, "Nov� f�rum", "To je v�choz� f�rum vytvo�en� p�i ' .
            'instalaci datab�ze. Po dokon�en� instalace zm��te ' .
            'jeho n�zev a popis.", 1)';
mysql_query($sql, $db) or die(mysql_error($db));

$sql = 'CREATE TABLE IF NOT EXISTS frm_post_count (
            user_id    INTEGER UNSIGNED NOT NULL DEFAULT 0,
            post_count INTEGER UNSIGNED NOT NULL DEFAULT 0,

            PRIMARY KEY (user_id)
        )
        ENGINE=MyISAM';
mysql_query($sql, $db) or die(mysql_error($db));

$sql = 'INSERT INTO frm_post_count VALUES (1, 1)';
mysql_query($sql, $db) or die(mysql_error($db));

$sql = 'CREATE TABLE IF NOT EXISTS frm_posts (
            id           INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
            topic_id     INTEGER UNSIGNED NOT NULL DEFAULT 0,
            forum_id     INTEGER UNSIGNED NOT NULL DEFAULT 0,
            author_id    INTEGER UNSIGNED NOT NULL DEFAULT 0,
            update_id    INTEGER UNSIGNED NOT NULL DEFAULT 0,
            date_posted  DATETIME         NOT NULL DEFAULT "0000-00-00 00:00:00",
            date_updated DATETIME,
            subject     VARCHAR(100)     NOT NULL DEFAULT "",
            body        MEDIUMTEXT,

            PRIMARY KEY (id),
            INDEX (forum_id, topic_id, author_id, date_posted),
            FULLTEXT INDEX (subject, body)
        )
        ENGINE=MyISAM';
mysql_query($sql, $db) or die(mysql_error($db));

$sql = 'INSERT IGNORE INTO frm_posts
            (id, topic_id, forum_id, author_id, update_id, date_posted,
            date_updated, subject, body)
        VALUES
            (1, 0, 1, 1, 0, "' . date('Y-m-d H:i:s') . '", 0, "V�tejte",
            "V�tejte na sv�m nov�m diskusn�m serveru. Po dokon�en� instalace ' .
            'nezapome�te zm�nit heslo spr�vce. Bavte se dob�e!")';
mysql_query($sql, $db) or die(mysql_error($db));


$sql = 'CREATE TABLE IF NOT EXISTS frm_users (
            id          INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
            email       VARCHAR(100)     NOT NULL UNIQUE,
            password    CHAR(41)         NOT NULL,
            name        VARCHAR(100)     NOT NULL,
            access_lvl  TINYINT UNSIGNED NOT NULL DEFAULT 1,
            signature   VARCHAR(255),
            date_joined DATETIME         NOT NULL,
            last_login  DATETIME,

            PRIMARY KEY (id)
        )
        ENGINE=MyISAM';
mysql_query($sql, $db) or die(mysql_error($db));

$sql = 'INSERT IGNORE INTO frm_users
            (id, name, email, password, access_lvl, signature,
            date_joined, last_login)
        VALUES
            (1, "Spr�vce", "admin@priklad.cz", "heslo",
            3, "", "' . date('Y-m-d H:i:s') . '", NULL)';
mysql_query($sql, $db) or die(mysql_error($db));
?>

<html>
  <head>
    <title>Tabulky diskusn�ho serveru byly vytvo�eny</title>
  </head>
  <body>
    <h1>Diskusn� f�ra pro fanou�ky komiks�</h1>
    <p>Byly vytvo�eny n�sleduj�c� tabulky:</p>
    <ul>
      <li>frm_admin</li>
      <li>frm_access_levels</li>
      <li>frm_admin</li>
      <li>frm_bbcode</li>
      <li>frm_form</li>
      <li>frm_post_count</li>
      <li>frm_posts</li>
      <li>frm_users</li>
    </ul>
    <p><a href="frm_login.php">P�ihl�sit se</a> do syst�mu.</p>
  </body>
</html>
