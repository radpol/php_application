<?php
require 'class.SimpleMail.php';

$message = new SimpleMail();

$message->setToAddress('p��jemce@priklad.cz');
$message->setSubject('Test textov� zpr�vy');
$message->setTextBody('Tato zpr�va byla odesl�na jako prost� text!');

if ($message->send()) {
  echo 'Zpr�va byla �sp�n� odesl�na!';
} else {
  echo 'Odesl�n� zpr�vy se nezda�ilo!';
}
?>