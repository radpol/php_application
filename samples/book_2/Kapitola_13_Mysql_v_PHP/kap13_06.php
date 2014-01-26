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
$objekt_vysledku = mysqli_query($db_spojeni, 'SELECT * FROM osoby');
 
if (!$objekt_vysledku)
{
  echo 'Posl�n� SQL p��kazu se nepoda�ilo, sorry';
  echo '<br />';
  echo 'Popis chyby: ', mysqli_error($db_spojeni);
  exit();
}
 
// Zobrazen� v�ech vr�cen�ch dat.
echo '<pre>';
while ($radek = mysqli_fetch_array($objekt_vysledku))
  var_dump($radek);
echo '</pre>';
 
// Zav�en� objektu v�sledku, proto�e u� ho nebudeme pou��vat.
mysqli_free_result($objekt_vysledku);
 
// Odpojen� od datab�ze.
if ($db_spojeni)
  mysqli_close($db_spojeni);
 
?>
</body>
</html>

