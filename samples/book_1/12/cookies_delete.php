<?php
// Platnost soubor� cookie vypr�ela v minulosti.
$expire = time() - 1000;

setcookie('username', null, $expire);
setcookie('remember_me', null, $expire);

header('Refresh: 5; URL=cookies_test.php');
?>
<html>
  <head>
    <title>Test odstran�n� soubor� cookie</title>
  </head>
  <body>
    <h1>Maz�n� soubor� cookie</h1>
    <p>Za 5 sekund budete p�esm�rov�ni na hlavn� str�nku.</p>
    <p>Nebudete-li p�esm�rov�ni automaticky,
    <a href="cookies_test.php">klepn�te sem</a>.</p>
  </body>
</html>