<?php
include 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or 
  die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

// Aktualizujte tabulku u�ivatel�.
$query = 'ALTER TABLE site_user
    ADD COLUMN admin_level TINYINT UNSIGNED NOT NULL DEFAULT 0 AFTER password';
mysql_query($query, $db) or die (mysql_error($db));

// Dejte jednomu z testovac�ch ��t� opr�vn�n� spr�vce.
$query = 'UPDATE site_user SET admin_level = 1 WHERE username = "jan"';
mysql_query($query, $db) or die (mysql_error($db));

echo 'P��kaz �sp�n� vykon�n!';
?>