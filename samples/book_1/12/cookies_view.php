<html>
  <head>
    <title>Testovac� str�nka pro n�hled soubor� cookie</title>
  </head>
  <body>
    <h1>Tyto soubory cookie byly nastaveny</h1>
    <?php
    if (!empty($_COOKIE)) {
      echo '<pre>';
      print_r($_COOKIE);
      echo '</pre>';
    } else {
      echo '<p>Nejsou nastaveny ��dn� soubory cookie.</p>';
    }
    ?>
    <p><a href="cookies_test.php">Zp�t na hlavn� str�nku</a></p>
  </body>
</html>