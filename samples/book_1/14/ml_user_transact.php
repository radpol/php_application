<?php
require 'db.inc.php';
require 'class.SimpleMail.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
  die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');

mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : '';

switch ($action) {
  case 'P�ihl�sit':
    $email = (isset($_POST['email'])) ? $_POST['email'] : '';
    $query = 'SELECT
                  user_id
              FROM
                  ml_users
              WHERE
                  email="' . mysql_real_escape_string($email, $db) . '"';
    $result = mysql_query($query, $db) or die(mysql_error($db));

    if (mysql_num_rows($result) > 0) {
      $row = mysql_fetch_assoc($result);
      $user_id = $row['user_id'];
    } else {
      $first_name = (isset($_POST['first_name'])) ? $_POST['first_name'] : '';
      $last_name = (isset($_POST['last_name'])) ? $_POST['last_name'] : '';

      $query = 'INSERT INTO ml_users
                    (first_name, last_name, email)
                VALUES
                    ("' . mysql_real_escape_string($first_name, $db) . '", ' .
                    '"' . mysql_real_escape_string($last_name, $db) . '", ' .
                    '"' . mysql_real_escape_string($email, $db) . '")';
      mysql_query($query, $db);
      $user_id = mysql_insert_id($db);
    }
    mysql_free_result($result);

    $count = 0;
    foreach ($_POST['ml_id'] as $ml_id) {
      if (ctype_digit($ml_id)) {
        $query = 'INSERT INTO ml_subscriptions
                      (user_id, ml_id, pending)
                  VALUES
                      (' . $user_id . ', ' . $ml_id . ', TRUE)';
        mysql_query($query, $db);

        $query = 'SELECT listname FROM ml_lists WHERE ml_id = ' . $ml_id;
        $result = mysql_query($query, $db);

        $row = mysql_fetch_assoc($result);
        $listname = $row['listname'];

        $message = 'V�en� u�ivateli,' . "\n\n" .
          'Elektronicky s V�mi komunikujeme na z�klad� V�mi ' .
          'ud�len�ho souhlasu k odb�ru zpr�v pro distribu�n� seznam ' .
          $listname . ".\n\n" .
          'Jestli�e jste zpr�vu obdr�el(a) omylem, omlouv�me se. ' .
          'Chcete-li sv�j odb�r potvrdit, pokra�ujte na potvrzovac� ' .
          'str�nku uvedenou n�e.' . "\n\n" .
          'Pokud jste odb�r zpr�v vy��dali, potvr�te pros�m ' .
          'tuto skute�nost klepnut�m na tento odkaz: ' . "\n" .
          'http://www.priklad.cz/ml_user_transact.php?user_id=' .
          $user_id . '&ml_id=' . $ml_id . '&action=potvrzeni';

        $mail = new SimpleMail();
        $mail->setToAddress($email);
        $mail->setFromAddress('admin@priklad.cz');
        $mail->setSubject('��dost o potvrzen� odb�ru hromadn� po�ty');
        $mail->setTextBody($message);
        $mail->send();
        unset($mail);
        $count++;
      }
    }
    header('Location: ml_thanks.php?user_id=' . $user_id . '&ml_id=' .
      ($count == 1 ? $ml_id : 'n') . '&type=c');
    break;

  case 'potvrzeni':
    $user_id = (isset($_GET['user_id'])) ? $_GET['user_id'] : '';
    $ml_id = (isset($_GET['ml_id'])) ? $_GET['ml_id'] : '';

    if (!empty($user_id) && !empty($ml_id)) {
      $query = 'UPDATE ml_subscriptions
            SET
                pending = FALSE
            WHERE
                user_id = ' . $user_id . ' AND
                ml_id = ' . $ml_id;
      mysql_query($query, $db) or die(mysql_error($db));

      $query = 'SELECT
                listname
            FROM
                ml_lists
            WHERE
                ml_id = ' . $ml_id;
      $result = mysql_query($query, $db);

      $row = mysql_fetch_assoc($result);
      $listname = $row['listname'];
      mysql_free_result($result);

      $query = 'SELECT
                first_name, email
            FROM
                ml_users
            WHERE
                user_id = ' . $user_id;
      $result = mysql_query($query, $db);

      $row = mysql_fetch_assoc($result);
      $first_name = $row['first_name'];
      $email = $row['email'];
      mysql_free_result($result);

      $message = 'V�en� u�ivateli,' . "\n\n" .
        'Zaregistrovali jsme V�s k odb�ru hromadn� po�ty ' .
        'pro seznam ' . $listname . ".  V�tejte!\n\n" .
        'Pokud jste tuto zpr�vu obdr�eli omylem, ' .
        'omlouv�me se. Zru�it odb�r zpr�v m��ete ' .
        'neprodlen� klepnut�m na n�sleduj�c� odkaz' . "\n" .
        'http://www.priklad.cz/ml_remove.php?user_id=' .
        $user_id . '&ml_id=' . $ml_id;

      $mail = new SimpleMail();
      $mail->setToAddress($email);
      $mail->setFromAddress('admin@priklad.cz');
      $mail->setSubject('Potvrzen� odb�ru hromadn� po�ty');
      $mail->setTextBody($message);
      $mail->send();

      header('Location: ml_thanks.php?user_id=' . $user_id . '&ml_id=' .
        $ml_id . '&type=s');
    } else {
      header('Location: ml_user.php');
    }
    break;
}
?>