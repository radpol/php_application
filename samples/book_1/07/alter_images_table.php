<?php
$db = mysql_connect('localhost', 'uzivatel', 'heslo') or
die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');
mysql_select_db('moviesite', $db) or die(mysql_error($db));

// �prava struktury tabulky "images".
$query = 'ALTER TABLE images DROP COLUMN image_filename';

mysql_query($query, $db) or die (mysql_error($db));

echo 'Tabulka obr�zk� byla �sp�n� aktualizov�na.';
?>