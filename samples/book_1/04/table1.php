<?php
// p�ipoj se k MySQL
$db = mysql_connect('localhost', 'uzivatel', 'heslo') or
    die('Nemohu se p�ipojit. Zkontrolujte p�ipojovac� parametry.');
                   
// zajisti, abychom pou��vali spr�vnou datab�zi
mysql_select_db('moviesite', $db) or die(mysql_error($db));

// na�ti informace
$dotaz = 'SELECT movie_name, movie_year, movie_director, 
                 movie_leadactor, movie_type
          FROM movie
          ORDER BY movie_name ASC,
                   movie_year DESC';
$v�sledky = mysql_query($dotaz, $db) or die(mysql_error($db));
                   
// zjisti po�et ��dk� ve v�sledku
$po�et_film� = mysql_num_rows($v�sledky);
?>
<div style="text-align: center;">
  <h2>Datab�ze s recenzemi film�</h2>
  <table border="1" cellpadding="2" cellspacing="2"
         style="width: 70%; margin-left: auto; margin-right: auto;">
    <tr>
      <th>N�zev filmu</th>
      <th>Rok uveden� na pl�tna kin</th>
      <th>Re�is�r</th>
      <th>V hlavn� roli</th>
      <th>Kategorie</th>
    </tr>
    <?php
    // projdi v�sledky
    while ($row = mysql_fetch_assoc($v�sledky)) {
      extract($row);
      echo '<tr>';
      echo '<td>' . $movie_name . '</td>';
      echo '<td>' . $movie_year . '</td>';
      echo '<td>' . $movie_director . '</td>';
      echo '<td>' . $movie_leadactor . '</td>';
      echo '<td>' . $movie_type . '</td>';
      echo '</tr>';
    }     
    ?>
  </table>
  <p>Po�et film�: <?php echo $po�et_film�; ?></p>
</div>	
