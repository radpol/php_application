<html>
  <head>
    <title>Filmov� web � <?php echo $_GET['oblfilm']; ?></title>
  </head>
  <body>
    <?php
      // odstra�te tento ��dek: define('OBLFILM','�ivot Briana');
      echo 'M�m obl�ben�m filmem je ';
      echo $_GET['oblfilm'];
      echo '<br />';
      $hodnocen� = 5;
      echo 'Tento film hodnot�m zn�mkou: ';
      echo $hodnocen�;
    ?>
  </body>
</html>
