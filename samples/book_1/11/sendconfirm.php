<?php
require 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or 
  die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$to_name = $_POST['to_name'];
$to_email = $_POST['to_email'];
$from_name = $_POST['from_name'];
$from_email = $_POST['from_email'];
$postcard = $_POST['postcard'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$query = 'SELECT description FROM pc_image WHERE image_url = "' .
  $postcard . '"';
$result = mysql_query($query, $db) or die(mysql_error());

$description = '';
if (mysql_num_rows($result))
{
  $row = mysql_fetch_assoc($result);
  $description = $row['description'];
}
mysql_free_result($result);

$token = md5(time());

$query = 'INSERT INTO pc_confirmation 
           (email_id, token, to_name, to_email, from_name, from_email,
            subject, postcard, message)
          VALUES
           (NULL, "' . $token . '",  "' . $to_name . '",  "' . $to_email . '",
            "' . $from_name . '",  "' . $from_email . '",   "' . $subject . '",
            "' . $postcard . '",  "' . $message . '")';
mysql_query($query, $db) or die(mysql_error());

$email_id = mysql_insert_id($db);

$headers = array();
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset="windows-1250"';
$headers[] = 'Content-Transfer-Encoding: 7bit';
$headers[] = 'From: no-reply@localhost';

$confirm_subject = 'Potvr�te pros�m pohlednici [' . $subject .']';

$confirm_message = '<html>';
$confirm_message .= '<p>Pozdravy u�ivateli ' . $from_name . '. Pomoc� ' .
  'n�sleduj�c�ho odkazu potvr�te odesl�n� pohlednice.</p>';
$confirm_message .= '<p><a href="http://localhost/php/11/confirm.php?id=' .
  $email_id . '&token=' . $token .'">Klepn�te sem pro potvrzen�</a></p>';
$confirm_message .= '<hr />';
$confirm_message .= '<img src="' . $postcard . '" alt="' . $description . 
    ' "/><br/>';
$confirm_message .= $message . '</html>';
?>
<html>
  <head>
    <title>Zpr�va byla odesl�na!</title>
  </head>
  <body>
    <?php
    $success = mail($from_email, $confirm_subject, $confirm_message,
      join("\r\n", $headers));

    if ($success) {
      echo '<h1>Nevy��zen� potvrzen�!</h1>';
      echo '<p>U�ivateli ' . $from_email . ' byla odesl�na ��dost ' .
       'o potvrzen�. Otev�ete zpr�vu a klepnut�m na p��slu�n� odkaz ' .
       'potvr�te �mysl odeslat pohlednici u�ivateli ' . $to_name . '.</p>';
    } else {
      echo '<p><strong>P�i odesl�n� potvrzen� do�lo k chyb�.</strong></p>';
    }
    ?>
  </body>
</html>