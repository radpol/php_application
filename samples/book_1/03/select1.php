<?php
$db = mysql_connect('localhost', 'uzivatel', 'heslo')
   or die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');
mysql_select_db('moviesite', $db) or die(mysql_error($db));

// vyber n�zev a ��nr film� vyroben�ch od roku 1990
$dotaz = 'SELECT movie_name, movie_type 
         FROM movie 
         WHERE movie_year > 1990 
         ORDER BY movie_type';
$v�sledky = mysql_query($dotaz, $db) or die(mysql_error($db));

// zobraz v�sledky
while ($��dek = mysql_fetch_array($v�sledky)) {
  foreach ($��dek as $hodnota) {
    echo $hodnota . ' ';
  }
  echo '<br/>';
}
?>
