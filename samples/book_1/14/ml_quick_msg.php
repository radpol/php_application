<?php
require 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
  die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');

mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));
?>
<html>
  <head>
    <title>Rychl� zpr�va</title>
    <style type="text/css">
      td { vertical-align: top; }
    </style>
  </head>
  <body>
    <h1>Rychl� zpr�va</h1>
    <form method="post" action="ml_admin_transact.php">
      <table>
        <tr>
          <td><label for="ml_id">Distribu�n� seznam:</label></td>
          <td><select name="ml_id" id="ml_id">
              <option value="all">V�echny</option>
              <?php
              $query = 'SELECT ml_id, listname FROM ml_lists ORDER BY listname';
              $result = mysql_query($query, $db) or die(mysql_error($db));

              while ($row = mysql_fetch_array($result)) {
                echo '<option value="' . $row['ml_id'] . '">' .
                  $row['listname'] . '</option>';
              }
              mysql_free_result($result);
              ?>
          </select></td>
        </tr><tr>
          <td><label for="subject">P�edm�t:</label></td>
          <td><input type="text" name="subject" id="subject"/></td>
        </tr><tr>
          <td><label for="message">Zpr�va:</label></td>
          <td><textarea name="message" id="message" rows="10"
                        cols="60"></textarea></td>
        </tr><tr>
          <td> </td>
          <td><input type="submit" name="action" value="Odeslat zpr�vu"/></td>
        </tr><tr>
      </table>
    </form>
    <p><a href="ml_admin.php">Zp�t na spr�vu distribu�n�ch seznam�.</a></p>
  </body>
</html>