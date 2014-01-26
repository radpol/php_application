<?php
session_start();
?>
<html>
  <head>
    <title>Str�nka registrovan�ho u�ivatele</title>
  </head>
  <body>
    <h1>V�tejte na domovsk� str�nce!</h1>
    <?php
    if (isset($_SESSION['logged']) && $_SESSION['logged'] == 1) {
      ?>
      <p>P�ihl�en� u�ivatel: <b><?php
      echo $_SESSION['username'];?>.</b></p>
      <p>Nyn� m��ete <a href="user_personal.php">klepnout sem</a> a upravit sv�
      osobn� p�edvolby podle vlastn�ho uv�en�.</p>
      <?php
      if (isset($_SESSION['admin_level']) && $_SESSION['admin_level'] > 0) {
        echo '<p><a href="admin_area.php">Zde</a> najdete ' .
          'n�stoje pro spr�vu.</p>';
      }
    } else {
      ?>
      <p>Moment�ln� nejste p�ihl�eni do syst�mu. Po p�ihl�eni budete
      m�t p��stup k osobn�mu nastaven� a ke str�nk�m pro spr�vu.</p>
      <p>Pokud jste ji� registrov�ni, p�ihlaste se <a href="login.php">zde</a>.
        Chcete-li vytvo�it nov� u�ivatelsk� ��et, registrujte se
        <a href="register.php">zde</a>.</p>
      <?php
    }
  ?>
  </body>
</html>