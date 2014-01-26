<?php
session_start();

// ov��, zda je u�ivatel p�ihl�en pomoc� platn�ho hesla.
if ( $_SESSION['authuser'] != 1 ) {
  echo "Bohu�el nem�te dostate�n� opr�vn�n� k prohl�en� t�to str�nky!";
  exit();
}
?>

<html>
  <head>
    <title>
      <?php
      if (isset($_GET['oblfilm'])) {
        echo ' - ';
        echo $_GET['oblfilm'];
      }
      ?>
    </title>
  </head>
  <body>
    <?php include 'header.php'; ?>
    <?php
    $oblfilmy = array( '�ivot Briana',
                       'Pianista',
                       'Kr�l ryb��',
                       'Svat� gr�l',
                       'Matrix',
                       'Termin�tor 2',
                       'Hv�zdn� v�lky',
                       'Bl�zk� setk�n� t�et�ho druhu',
                       '�estn�ct sv�cn�',
                       'P�n Prsten�: Spole�enstvo prstenu');

    if (isset( $_GET['oblfilm'])) {
      echo 'V�tejte na na�em webu . ';
      echo 'P�ihl�en� u�ivatel: ' . $_SESSION[ 'username' ];
      echo '<br/>';
      echo 'M�m obl�ben�m filmem je ';
      echo $_REQUESTGET[ 'oblfilm' ];
      echo ' .<br/>';
      $hodnocen� = 5;
      echo 'Tento film hodnot�m zn�mkou: ';
      echo $hodnocen�;
    } else {
      echo 'M�ch ' . $_POST['pocet'] . ' nejobl�ben�j��ch film�';

      if (isset( $_POST['seradit'])) {
        sort($oblfilmy);
        echo ' (se�azen�ch podle abecedy) ';
      }
      echo ': <br />';

      $cfilmu = 0;
      echo '<ol>';
      while ($cfilmu < $_POST['pocet']) {
        echo '<li>';
        echo $oblfilmy[$cfilmu];
        echo '</li>';
        $cfilmu = $cfilmu + 1;
      }
      echo '</ol>';
    }
    ?>
  </body>
</html>
