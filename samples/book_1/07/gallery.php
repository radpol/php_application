<?php
// p�ipojen� k datab�zi MySQL
$db = mysql_connect('localhost', 'uzivatel', 'heslo') or
die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');
mysql_select_db('moviesite', $db) or die(mysql_error($db));

// Upravte cestu tak, aby odpov�dala um�st�n� obr�zk�.
$dir ='obrazky';

// Upravte cestu tak, aby odpov�dala um�st�n� miniatur.
$thumbdir = $dir . '/miniatury';
?>
<html>
  <head>
    <title>V�tejte v na�� fotogal�rii</title>
    <style type="text/css">
      th { background-color: #999;}
      .odd_row { background-color: #EEE; }
      .even_row { background-color: #FFF; }
    </style>
  </head>
  <body>
    <p>Chcete-li vid�t obr�zek v pln� velikosti, klepn�te na miniaturu.</p>
    <table style="width:100%;">
      <tr>
        <th>Obr�zek</th>
        <th>Popisek</th>
        <th>Ulo�il</th>
        <th>Datum ulo�en�</th>
      </tr>
      <?php
      // Na�ten� miniatur
      $result = mysql_query('SELECT * FROM images') or die(mysql_error());

      $odd = true;
      while ($rows = mysql_fetch_array($result)) {
        echo ($odd == true) ? '<tr class="odd_row">' : '<tr class="even_row">';
        $odd = !$odd;
        extract($rows);
        echo '<td><a href="' . $dir . '/' . $image_id . '.jpg">';
        echo '<img src="' . $thumbdir . '/' . $image_id . '.jpg">';
        echo '</a></td>';
        echo '<td>' . $image_caption . '</td>';
        echo '<td>' . $image_username . '</td>';
        echo '<td>' . $image_date . '</td>';
        echo '</tr>';
      }
      ?>
    </table>
  </body>
</html>