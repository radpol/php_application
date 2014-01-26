<?php
// Platnost soubor� cookie vypr�� za 30 dn�(vyj�d�eno v sekund�ch)
$expire = time() + (60 * 60 * 24 * 30);

setcookie('username', 'testovaci_uzivatel', $expire);
setcookie('remember_me', 'ano', $expire);

header('Refresh: 5; URL=cookies_test.php');
?>
<html>
  <head>
    <title>Test nastaven� soubor� cookie</title>
  </head>
  <body>
    <h1>Nastaven� soubor� cookie</h1>
    <p>Za 5 sekund budete p�esm�rov�ni na hlavn� str�nku.</p>
    <p>Nebudete-li p�esm�rov�ni automaticky,
    <a href="cookies_test.php">klepn�te sem</a>.</p>
  </body>
</html>