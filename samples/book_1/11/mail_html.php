<?php
require 'class.SimpleMail.php';

$message = new SimpleMail();

$message->setSendText(false);
$message->setToAddress('p��jemce@priklad.cz');
$message->setSubject('Testov�n� zpr�v ve form�tu HTML');
$message->setHTMLBody('<html><p>Toto je test pomoc� <b>jazyka HTML</b>!
  </p></html>');

if ($message->send()) {
  echo 'Zpr�va byla �sp�n� odesl�na!';
} else {
  echo 'Odesl�n� zpr�vy se nezda�ilo!';
}
?>