<?php
require 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
  die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');

mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$user_id = (isset($_GET['user_id']) && 
  ctype_digit($_GET['user_id'])) ? $_GET['user_id'] : '';

if (empty($user_id)) {
  $name = '';
  $email = '';
  $access_level = '';
} else {
  $sql = 'SELECT
              name, email, access_level
          FROM
              cms_users
          WHERE
              user_id=' . $user_id;
  $result = mysql_query($sql, $db) or die(mysql_error($db));
  $row = mysql_fetch_array($result);
  extract($row);
  mysql_free_result($result);
}

include 'cms_header.inc.php';

if (empty($user_id)) {
  echo '<h1>Vytvo�it ��et</h1>';
} else {
  echo '<h1>Upravit ��et</h1>';
}
?>
<form method="post" action="cms_transact_user.php">
  <table>
    <tr>
      <td><label for="name">Jm�no a p��jmen�:</label></td>
      <td><input type="text" id="name" name="name" maxlength="100"
                 value="<?php echo htmlspecialchars($name); ?>"/></td>
    </tr><tr>
      <td><label for="email">Elektronick� adresa:</label></td>
      <td><input type="text" id="email" name="email" maxlength="100"
                 value="<?php echo htmlspecialchars($email); ?>"/></td>
    </tr>
    <?php

    if (isset($_SESSION['access_level']) && $_SESSION['access_level'] == 3)
    {
      echo '<tr><td>�rove� p��stupu</td><td>';

      $sql = 'SELECT
                  access_level, access_name
              FROM
                  cms_access_levels
              ORDER BY
                  access_level DESC';
      $result = mysql_query($sql, $db) or die(mysql_error($db));

      while ($row = mysql_fetch_array($result)) {
        echo '<input type="radio" id="acl_' . $row['access_level'] .
          '" name="access_level" value="' . $row['access_level'] . '"';

        if ($row['access_level'] == $access_level) {
          echo ' checked="checked"';
        }
        echo '/> <label for="acl_' . $row['access_level'] . '">' .
        $row['access_name'] . '</label><br/>';
      }
      mysql_free_result($result);
      echo '</td></tr>';
    }

    if (empty($user_id)) {
      ?>
    <tr>
      <td><label for="password_1">Heslo:</label></td>
      <td><input type="password" id="password_1" name="password_1"
                 maxlength="50"/>
      </td>
    </tr><tr>
      <td><label for="password_2">Heslo (je�t� jednou):</label></td>
      <td><input type="password" id="password_2" name="password_2"
                 maxlength="50"/>
      </td>
    </tr><tr>
      <td> </td>
      <td>
        <input type="submit" name="action" value="Vytvo�it ��et"/>
      </td>
    </tr>
    <?php
  } else {
    ?>
    <tr>
      <td> </td>
      <td>
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>"/>
        <input type="submit" name="action" value="Upravit ��et"/>
      </td>
    </tr>
    <?php
  }
  ?>
  </table>
</form>
<?php
include 'cms_footer.inc.php';
?>