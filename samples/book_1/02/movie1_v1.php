<?php
session_start();
$_SESSION['username'] = $_POST['user'];
$_SESSION['userpass'] = $_POST['pass'];
$_SESSION['authuser'] = 0;

// ov�� u�ivatelsk� jm�no a heslo 
if ( ( $_SESSION['username'] == 'Petr' ) and
  ($_SESSION['userpass'] == '12345' ) )  {
  $_SESSION['authuser'] = 1;
} else {
  echo "Bohu�el nem�te dostate�n� opr�vn�n� k prohl�en� t�to str�nky!";
  exit();
}
?>
<html>
  <head>
    <title>Naj�t obl�ben� film!</title>
  </head>
  <body>
    <?php include "header.php"; ?>
    <?php
    $obl�ben�film = urlencode('�ivot Briana');
    echo "<a href=\"moviesite.php?oblfilm=$obl�ben�film\">";
    echo 'Dal�� informace o m�m obl�ben�m filmu!';
    echo '</a>';
    ?>
    <br />
    <br />
    Nebo vyberte, kolik film� byste cht�li vid�t:
    <br />
    <form method="post" action="moviesite.php">
      <p>Zadejte po�et film� (maxim�ln� 10):
        <input type="text" name="pocet" maxlength="2" size="2">
        <br/>
        Toto pol��ko zakrtn�te, chcete-li zobrazit set��d�n� seznam:
        <input type="checkbox" name="seradit">
      </p>
      <input type="submit" name="Submit" value="Odeslat">
    </form>
  </body>
</html>
