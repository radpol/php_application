<?php
include 'auth.inc.php';
include 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or 
  die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));
?>
<html>
  <head>
    <title>Osobn� �daje</title>
  </head>
  <body>
    <h1>V�tejte na sv�ch osobn�ch str�nk�ch.</h1>
    <p>Zde m��ete upravit sv� osobn� �daje nebo vymazat sv�j ��et.</p>
    <p>Na t�to str�nce si m��ete prohl�dnout, co jste o sob� uvedli.</p>
    <p><a href="main.php">Klepn�te sem</a> pro n�vrat na hlavn� str�nku.</p>
    <?php
    $query = 'SELECT
                  username, first_name, last_name, city, state, email, hobbies
              FROM
                  site_user u JOIN
                  site_user_info i ON u.user_id = i.user_id
              WHERE
                  username = "' .
                  mysql_real_escape_string($_SESSION['username'], $db) . '"';
    $result = mysql_query($query, $db) or die(mysql_error($db));

    $row = mysql_fetch_array($result);
    extract($row);
    mysql_free_result($result);
    mysql_close($db);
    ?>
    <ul>
      <li>Jm�no: <?php echo $first_name; ?></li>
      <li>P��jmen�: <?php echo $last_name; ?></li>
      <li>M�sto: <?php echo $city; ?></li>
      <li>Zem�: <?php echo $state; ?></li>
      <li>E-mail: <?php echo $email; ?></li>
      <li>Z�jmy: <?php echo $hobbies; ?></li>
    </ul>
    <p><a href="update_account.php">Upravit</a> |
    <a href="delete_account.php">Zru�it ��et</a></p>
  </body>
</html>