<?php
session_unset();
?>
<html>
  <head>
    <title>P�ihlaste se, pros�m!</title>
  </head>

  <body>
    <?php include "header.php"; ?>
    <form method="post" action="movie1.php">
      <p>Zadejte jm�no:
        <input type="text" name="user">
      </p>
      <p>Zadejte heslo:
        <input type="password" name="pass">
      </p>
      <p>
        <input type="submit" name="Submit" value="Odeslat">
      </p>
    </form>
  </body>
</html>
