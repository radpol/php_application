<?php
require 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
  die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');

mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$user_id = (isset($_GET['user_id']) && 
  ctype_digit($_GET['user_id'])) ? $_GET['user_id'] : '';

$first_name = '';
$last_name = '';
$email = '';
$ml_ids = array();
if (!empty($user_id)) {
  $query = 'SELECT
                first_name, last_name, email
            FROM
                ml_users
            WHERE
                user_id = ' . $user_id;
  $result = mysql_query($query, $db) or die(mysql_error($db));
  if (mysql_num_rows($result) > 0) {
    $row = mysql_fetch_assoc($result);
    extract($row);
  }
  mysql_free_result($result);

  $query = 'SELECT ml_id FROM ml_subscriptions WHERE user_id = ' . $user_id;
  $result = mysql_query($query, $db) or die(mysql_error($db));
  while ($row = mysql_fetch_assoc($result)) {
    $ml_ids[] = $row['ml_id'];
  }
  mysql_free_result($result);
}
?>
<html>
  <head>
    <title>P�ihl�en� do distribu�n�ho seznamu</title>
  </head>
  <body>
    <h1>P�ihl�en� do distribu�n�ho seznamu:</h1>
    <form method="post" action="ml_user_transact.php">
      <table>
        <tr>
          <td><label for="email">Elektronick� adresa:</label></td>
          <td><input type="text" name="email" id="email"
                     value="<?php echo $email; ?>"/>
          </td>
        </tr>
      </table>
      <p>Nejste �lenem, uve�te pros�m jm�no a p��jmen�:</p>
      <table>
        <tr>
          <td><label for="first_name">Jm�no:</label></td>
          <td><input type="text" name="first_name" id="first_name"
                     value="<?php echo $first_name; ?>"/></td>
        </tr><tr>
          <td><label for="last_name">P��jmen�:</label></td>
          <td><input type="text" name="last_name" id="last_name"
                     value="<?php echo $last_name; ?>"/></td>
        </tr>
      </table>
      <p>Vyberte, do kter�ho distribu�n�ho seznamu chcete b�t za�azeni:</p>
      <p>
        <select name="ml_id[]" multiple="multiple">
          <?php
          $query = 'SELECT
                        ml_id, listname
                    FROM
                        ml_lists
                    ORDER BY
                        listname ASC';
          $result = mysql_query($query, $db) or die(mysql_error($db));

          print_r($ml_ids);
          while ($row = mysql_fetch_array($result)) {
            if (in_array($row['ml_id'], $ml_ids)) {
              echo '<option value="' . $row['ml_id'] . '" selected="selected">';
            } else {
              echo '<option value="' . $row['ml_id'] . '">';
            }
            echo $row['listname'] . '</option>';
          }
          mysql_free_result($result);
          ?>
        </select>
      </p>
      <p><input type="submit" name="action" value="P�ihl�sit" /></p>
    </form>
  </body>
</html>