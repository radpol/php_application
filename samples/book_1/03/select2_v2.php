<?php
$db = mysql_connect('localhost', 'uzivatel', 'heslo')
   or die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');
mysql_select_db('moviesite', $db) or die(mysql_error($db));

// vyber n�zev a ��nr film� vyroben�ch od roku 1990
$dotaz = 'SELECT movie_name, movietype_label 
          FROM movie 
            LEFT JOIN movietype ON movie_type = movietype_id
          WHERE movie.movie_year > 1990 
          ORDER BY movie_type';
$v�sledky = mysql_query($dotaz, $db) or die(mysql_error($db));

// zobraz v�sledky
echo '<table border="1">';
while ($��dek = mysql_fetch_assoc($v�sledky)) {
  echo '<tr>';
  foreach($��dek as $hodnota) {
    echo ' <td> ' . $hodnota . ' </td> ';
  }
  echo '</tr>';
}
echo '</table>';
?>
