<?php
$db = mysql_connect('localhost', 'uzivatel', 'heslo') or
die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');
mysql_select_db('moviesite', $db) or die(mysql_error($db));
                   
// uprav tabulku movie tak, aby obsahovala nav�c d�lku, 
// n�klady a v�nosy filmu
$dotaz = 'ALTER TABLE movie ADD COLUMN (
  movie_running_time TINYINT UNSIGNED NULL,
  movie_cost         DECIMAL(4,1)     NULL,
  movie_takings      DECIMAL(4,1)     NULL)';
mysql_query($dotaz, $db) or die (mysql_error($db));
                   
// vlo� nov� data pro ka�d� film do tabulky movie
$dotaz = 'UPDATE movie 
           SET movie_running_time = 101,
               movie_cost = 81,
               movie_takings = 242.6
           WHERE
               movie_id = 1';
mysql_query($dotaz, $db) or die(mysql_error($db));
                   
$dotaz = 'UPDATE movie 
           SET movie_running_time = 89,
               movie_cost = 10,
               movie_takings = 10.8
           WHERE
               movie_id = 2';
mysql_query($dotaz, $db) or die(mysql_error($db));
                   
$dotaz = 'UPDATE movie 
           SET movie_running_time = 134,
               movie_cost = NULL,
               movie_takings = 33.2
           WHERE
               movie_id = 3';
mysql_query($dotaz, $db) or die(mysql_error($db));
                   
echo 'Datab�ze film� byla �sp�n� aktualizov�na!';
?>
