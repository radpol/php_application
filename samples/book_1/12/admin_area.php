<?php
include 'auth.inc.php';

if ($_SESSION['admin_level'] < 1) {
  header('Refresh: 5; URL=user_personal.php');
  echo '<p><strong>Nem�te opr�vn�n� prohl�et tuto str�nku.</strong></p>';
  echo '<p>Za 5 sekund budete p�esm�rov�ni na hlavn� str�nku.</p>' .
    '<p>Nebudete-li p�esm�rov�ni automaticky, ' .
    '<a href="main.php">klepn�te sem</a>.</p>';
  die();
}

include 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or 
  die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));
?>
<html>
  <head>
    <title>Z�na pro spr�vu</title>
    <style type="text/css">
      th { background-color: #999;}
      .odd_row { background-color: #EEE; }
      .even_row { background-color: #FFF; }
    </style>
  </head>
  <body>
    <h1>V�tejte v z�n� pro spr�vu.</h1>
    <p>Zde m��ete prohl�et a upravovat z�znamy jin�ch u�ivatel�.</p>
    <p>Pro n�vrat na hlavn� str�nku <a href="main.php">klepn�te sem</a>.</p>
    <table style="width:70%">
      <tr><th>U�ivatelsk� jm�no</th><th>Jm�no:</th><th>P��jmen�:</th></tr>
      <?php
      $query = 'SELECT
                    u.user_id, username, first_name, last_name
                FROM
                    site_user u JOIN
                    site_user_info i ON u.user_id = i.user_id
                ORDER BY
                    username ASC';
      $result = mysql_query($query, $db) or die(mysql_error($db));

      $odd = true;
      while ($row = mysql_fetch_array($result)) {
        echo ($odd == true) ? '<tr class="odd_row">' : '<tr class="even_row">';
        $odd = !$odd;
        echo '<td><a href="update_user.php?id=' .  $row['user_id']. '">' .
        $row['username'] . '</a></td>';
        echo '<td>' . $row['first_name'] . '</td>';
        echo '<td>' . $row['last_name'] . '</td>';
        echo '</tr>';
      }
      mysql_free_result($result);
      mysql_close($db);
      ?>
    </table>
  </body>
</html>