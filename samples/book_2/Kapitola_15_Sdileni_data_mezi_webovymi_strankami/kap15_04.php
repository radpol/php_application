<?php
  session_start();
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
</head>
<body>
<?php
  // Jestli�e p�ijde jm�no u�ivatele z formul��e, pou�ij ho.
  if (isset($_POST['jmeno']))
    $_SESSION['jmeno'] = $_POST['jmeno'];

  // Jestli�e nen� jm�no u�ivatele v session, zobraz formul��.
  if (!isset($_SESSION['jmeno']))
  {
    echo '<form action="" method="post">';
    echo '<b>Napi� svoje jm�no, pros�m:</b>';
    echo '<input type="text" name="jmeno" size="20"><br />';
    echo '<input type="submit" value="Ode�li jm�no">';
    echo '</form>';
  }

  // Jestli�e je jm�no u�ivatele v session, zobraz ho.
  if (isset($_SESSION['jmeno']))
    echo '<b>Jmenuje� se ', $_SESSION['jmeno'], '</b>';
?>
</form>
</body>
</html>

