<?php
$to_address = $_POST['to_address'];
$from_address = $_POST['from_address'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$headers = array();

$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=windows-1250';
$headers[] = 'Content-Transfer-Encoding: 7bit';
$headers[] = 'From: ' . $from_address;
?>
<html>
  <head>
    <title>Zpr�va byla odesl�na!</title>
  </head>
  <body>
    <?php
    $success = mail($to_address, $subject, $message, join("\r\n", $headers));
    if ($success) {
      echo '<h1>Gratulujeme!</h1>';
      echo '<p>Byla odesl�na n�sleduj�c� zpr�va: <br/><br/>';
      echo '<b>Komu:</b> ' . $to_address . '<br/>';
      echo '<b>Od:</b> ' . $from_address . '<br/>';
      echo '<b>P�edm�t:</b> ' . $subject . '<br/>';
      echo '<b>Zpr�va:</b></p>';
      echo nl2br($message);
    } else {
      echo '<p><strong>P�i odes�l�n� zpr�vy do�lo k chyb�.</strong></p>';
    }
    ?>
  </body>
</html>
