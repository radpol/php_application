<html>
  <head>
    <title>Odhl�en� odb�ru hromadn� po�ty</title>
  </head>
  <body>
    <h1>Odhl�en� odb�ru hromadn� po�ty</h1>
    <?php
    require 'db.inc.php';

    $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
      die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');

    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

    $user_id = (isset($_GET['user_id']) &&
      ctype_digit($_GET['user_id'])) ? $_GET['user_id'] : -1;

    $ml_id = (isset($_GET['ml_id']) &&
      ctype_digit($_GET['ml_id'])) ? $_GET['ml_id'] : -1;

    if (empty($user_id) || empty($ml_id)) {
      die('Nespr�vn� parametry.');
    }
    $query = 'DELETE FROM ml_subscriptions WHERE user_id = ' . $user_id .
      ' AND ml_id = ' . $ml_id;
    mysql_query($query, $db) or die(mysql_error());

    $query = 'SELECT listname FROM ml_lists WHERE ml_id = ' . $ml_id;
    $result = mysql_query($query, $db) or die(mysql_error($db));
    if (mysql_num_rows($result) == 0) {
      die('Nezn�m� seznam.');
    }
    $row = mysql_fetch_array($result);
    $listname = $row['listname'];
    mysql_free_result($result);

    echo '<p>Byli jste odebr�ni z distribu�n�ho seznamu ' . $listname . '</p>';
    echo '<p><a href="ml_user.php?user_id=' . $user_id . '">N�vrat ' .
      'na str�nku pro p�ihl�en� k odb�ru hromadn� po�ty.</a></p>';
    ?>
  </body>
</html>