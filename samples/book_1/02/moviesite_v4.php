<?php
  session_start();

  // ov��, zda je u�ivatel p�ihl�en pomoc� platn�ho hesla.
  if ($_SESSION['authuser'] != 1) {
    echo "Bohu�el nem�te dostate�n� opr�vn�n� k prohl�en� t�to str�nky!";
    exit();
  }
?>
<html>
  <head>
    <title>Filmov� web � <?php echo $_REQUEST[ 'oblfilm' ]; ?></title>
  </head>
  <body>
    <?php
      echo 'V�tejte na na�em webu. ';
      echo 'P�ihl�en� u�ivatel: '. $_SESSION[ 'username' ];
      echo '<br />';
      echo 'M�m obl�ben�m filmem je ';
      echo $_REQUEST[ 'oblfilm' ];
      echo ' .<br />';
      $hodnocen� = 5;
      echo 'Tento film hodnot�m zn�mkou: ';
      echo $hodnocen�;
    ?>
  </body>
</html>
