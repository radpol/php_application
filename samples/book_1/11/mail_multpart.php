<?php
require 'class.SimpleMail.php';

$message = new SimpleMail();

$message->setToAddress('p��jemce@priklad.cz');
$message->setFromAddress('odes�latel@priklad.cz');
$message->setCCAddress('p��tel@priklad.cz');
$message->setBCCAddress('tajn�@priklad.cz');
$message->setSubject('Test v�ced�ln� zpr�vy');
$message->setTextBody('Toto je ��st zpr�vy jako prost� text!');
$message->setHTMLBody('<html><p>To je ��st zpr�vy ve form�tu <b>HTML</b>!
  </p></html>');

if ($message->send()) {
  echo 'Zpr�va byla �sp�n� odesl�na!';
} else {
  echo 'Odesl�n� zpr�vy se nezda�ilo!';
}
?>