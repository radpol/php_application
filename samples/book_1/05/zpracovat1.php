<html>
  <head>
    <title>Uve�te jm�no</title>
  </head>
  <body>
    <?php
    echo '<h1>Zdrav�me u�ivatele ' . $_POST['jmeno'] . '!</h1>';
    ?>
    <pre>
<strong>DEBUG:</strong>
<?php
print_r($_POST);
?>
    </pre>
  </body>
</html>
