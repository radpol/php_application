<html>
<head>
<title>Zasl�n� SQL p��kazu do datab�ze</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
</head>
<body>
<?php 
 
// P�ipojen� k datab�zi.
$db_spojeni = mysqli_connect
  ('localhost', 'root', 'lokomotiva', 'test', 3306);
 
// Otestov�n�, zda se p�ipojen� poda�ilo.
if ($db_spojeni)
  echo 'P�ipojen� se poda�ilo';
else
{
  echo 'P�ipojen� se nepoda�ilo, sorry';
  echo '<br />';
  echo 'Popis chyby: ', mysqli_connect_error();
  exit();
}
 
// Zasl�n� SQL p��kazu do datab�ze.
mysqli_query($db_spojeni, 'SELECT * FROM osoby');
echo 'Pr�v� byl zasl�n SQL p��kaz do datab�ze';
 
// Odpojen� od datab�ze.
if ($db_spojeni)
  mysqli_close($db_spojeni);
 
?>
</body>
</html>

