<?php
require 'db.inc.php';
require 'class.SimpleMail.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');

mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$action = (isset($_POST['action'])) ? $_POST['action'] : '';

switch ($action) {
  case 'P�idat distribu�n� seznam':
    $listname = isset($_POST['listname']) ? $_POST['listname'] : '';
    $query = 'INSERT INTO ml_lists
                  (listname)
              VALUES
                  ("' . mysql_real_escape_string($listname, $db) . '")';
    mysql_query($query, $db) or die(mysql_error($db));
    break;

  case 'Vymazat distribu�n� seznam':
    $ml_id = isset($_POST['ml_id']) ? $_POST['ml_id'] : '';
    if (ctype_digit($ml_id)) {
      $query = 'DELETE FROM ml_lists WHERE ml_id=' . $ml_id;
      mysql_query($query, $db) or die(mysql_error($db));

      $query = 'DELETE FROM ml_subscriptions WHERE ml_id=' . $ml_id;
      mysql_query($query, $db) or die(mysql_error($db));
    }
    break;

  case 'Odeslat zpr�vu':
    $ml_id = isset($_POST['ml_id']) ? $_POST['ml_id'] : '';
    $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';

    if ($ml_id == 'all') {
      $listname = 'Hlavn�';
    } else if (ctype_digit($ml_id)) {
      $query = 'SELECT
              listname
          FROM
              ml_lists
          WHERE
              ml_id=' . $ml_id;
      $result = mysql_query($query, $db) or die(mysql_error($db));
      $row = mysql_fetch_assoc($result);
      $listname = $row['listname'];
      mysql_free_result($result);
    } else {
      break;
    }

    $query = 'SELECT DISTINCT
                usr.email, usr.first_name, usr.user_id
              FROM ml_users usr
                INNER JOIN ml_subscriptions mls
                ON usr.user_id = mls.user_id
              WHERE mls.pending = FALSE';
    if ($_POST['ml_id'] != 'all') {
      $query .= " AND mls.ml_id=" . $ml_id;
    }

    $result = mysql_query($query, $db) or die(mysql_error($db));
    if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result)) {
        if (is_numeric($_POST['ml_id'])) {
          $footer = "Tuto zpr�vu jste obdr�eli, proto�e jste �lenem " .
            "distribu�n�ho seznamu " . $listname .
            ". Pokud jste obdr�eli tuto zpr�vu omylem, " .
            "nebo pokud chcete zru�it �lenstv� v tomto " .
            "distribu�n�m seznamu, nav�tivte pros�m n�sleduj�c� " .
            "adresu URL:\n" .
            "http://www.priklad.cz/ml_remove.php?user_id=" .
            $row['user_id'] . "&ml_id=". $_POST['ml_id'];
        } else {
          $footer = "Tuto zpr�vu dost�v�te, proto�e jste se k jej�mu " .
            "odb�ru p�ihl�sili registrac� v jednom nebo v n�kolika " .
            "distribu�n�ch seznamech. Chcete-li odb�r zm�nit, " .
            "nav�tivte n�sleduj�c� adresu URL:\n" .
            "http://www.priklad.cz/ml_user.php?user_id=" . $row['user_id'];
        }
        $message .= "\n\n--------------\n";
        $message .= $footer;

        $mail = new SimpleMail();
        $mail->setToAddress($row['email']);
        $mail->setFromAddress('admin@priklad.cz');
        $mail->setSubject(stripslashes($subject));
        $mail->setTextBody($message);
        $mail->send();
      }
    }
    mysql_free_result($result);
    break;
}
header('Location: ml_admin.php');
?>
