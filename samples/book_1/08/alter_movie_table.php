<?php
$db = mysql_connect('localhost', 'uzivatel', 'heslo') or
die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');
mysql_select_db('moviesite', $db) or die(mysql_error($db));

// Upravte tabulku movie, abyste do n� mohli ukl�dat hodnocen�
// a datum uveden� do kin.
$query = 'ALTER TABLE movie ADD COLUMN (
    movie_release INTEGER UNSIGNED DEFAULT 0,
    movie_rating  TINYINT UNSIGNED DEFAULT 5)';
mysql_query($query, $db) or die(mysql_error($db));

echo 'Tabulka film� byla �sp�n� aktualizov�na!';
?>