<html>
  <head>
    <title>D�kujeme</title>
  </head>
  <body>
    <?php
    require 'db.inc.php';

    $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
      die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');

    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

    $user_id = (isset($_GET['user_id'])) ? $_GET['user_id'] : '';
    $ml_id = (isset($_GET['ml_id'])) ? $_GET['ml_id'] : '';
    $type = (isset($_GET['type'])) ? $_GET['type'] : '';

    if (empty($user_id)) {
      die('Nen� definov�n identifik�tor u�ivatele.');
    }
    $query = 'SELECT first_name, last_name, email
              FROM ml_users WHERE user_id = ' . $user_id;
    $result = mysql_query($query, $db) or die(mysql_error());

    if (mysql_num_rows($result) > 0) {
      $row = mysql_fetch_assoc($result);
      $full_name = $row['first_name'] . ' ' . $row['last_name'];
      $email = $row['email'];
    } else {
      die('Identifik�tor u�ivatele nenalezen.');
    }
    mysql_free_result($result);

    if (empty($ml_id)) {
      die('Nen� definov�n identifik�tor distribu�n�ho seznamu.');
    }
    if (ctype_digit($ml_id)) {
      $query = 'SELECT listname FROM ml_lists WHERE ml_id = ' . $ml_id;
      $result = mysql_query($query, $db) or die(mysql_error());

      if (mysql_num_rows($result)) {
        $row = mysql_fetch_assoc($result);
        $listname = $row['listname'];
      } else {
        die ('Identifik�tor distribu�n�ho seznamu nenalezen.');
      }
      mysql_free_result($result);
    }
    if ($type == 'c') {
      echo '<h1>Pod�kov�n� u�ivateli: ' . $full_name . '</h1>';
      if (ctype_digit($ml_id)) {
        echo '<p>Potvrzen� o za�azen� do distribu�n�ho seznamu ' . $listname .
          ' bylo odesl�no na adresu ' . $email . '.</p>';
      }
      else
      {
        echo '<p>Potvrzen� o za�azen� do n�kolika distribu�n�ch seznam�' .
          ' bylo odesl�no na adresu ' . $email . '.</p>';
      }
    } else {
      echo '<h1>Pod�kov�n� u�ivateli: ' . $full_name . '</h1>';
      echo '<p>D�kujeme za p�ihl�en� do distribu�n�ho seznamu ' .
        $listname . '.</p>';
    }
    ?>
  </body>
</html>