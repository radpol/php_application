<html>
  <head>
    <title>Naj�t obl�ben� film!</title>
  </head>
  <body>
    <?php
      // p�idejte n�sleduj�c� ��dek
      $obl�ben�film = urlencode('�ivot Briana');

      // upravte n�sleduj�c� ��dek
      echo "<a href=\"moviesite.php?oblfilm=$obl�ben�film\">";
      echo 'Dal�� informace o m�m obl�ben�m filmu!';
      echo '</a>';
    ?>
  </body>
</html>
