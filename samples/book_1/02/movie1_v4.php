<?php
  session_start();
  $_SESSION['username'] = "Petr12345";
  $_SESSION['authuser'] = 1;
?>
<html>
  <head>
    <title>Naj�t obl�ben� film!</title>
  </head>
  <body>
    <?php
      $obl�ben�film = urlencode( '�ivot Briana' );
      echo "<a href=\"moviesite.php?oblfilm=$obl�ben�film\">";
      echo 'Dal�� informace o m�m obl�ben�m filmu!';
      echo '</a>';
    ?>
  </body>
</html>
