<html>
  <head>
    <title>M�me p�estupn� rok?</title>
  </head>
  <body>
    <?php
    date_default_timezone_set('Europe/Prague');
    $p�estupn�rok = date('L');
    if ($p�estupn�rok == 1) {
      echo 'Hur�! Letos je p�estupn� rok!';
    }
    else {
      echo 'Litujeme, letos nen� p�estupn� rok.';
    }
    ?>
  </body>
</html>
