<?php
require 'class.SimpleMail.php';

$message = new SimpleMail();

if ($message->send('p��jemce@priklad.cz', 'Test rychl� zpr�vy',
    'Toto je rychl� test metody SimpleMail->send().')) {
  echo 'Zpr�va byla �sp�n� odesl�na!';
} else {
  echo 'Odesl�n� zpr�vy se nezda�ilo!';
}
?>