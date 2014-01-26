<html>
<head>
<title>V�pis z�pis�</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
</head>
<body>
<?php 
 
// P�ipojen� k datab�zi.
$db_spojeni = mysqli_connect
  ('localhost', 'root', 'lokomotiva', 'test', 3306);
 
// Otestov�n�, zda se p�ipojen� poda�ilo.
if (!$db_spojeni)
{
  echo 'P�ipojen� se nepoda�ilo, sorry';
  echo '<br />';
  echo 'Popis chyby: ', mysqli_connect_error();
  exit();
}

// Spr�vn� nastaven� �e�tiny.
$objekt_vysledku = mysqli_query($db_spojeni, "SET NAMES 'cp1250'");
if (!$objekt_vysledku)
{
  echo 'Posl�n� SQL p��kazu se nepoda�ilo, sorry';
  echo '<br />';
  echo 'Popis chyby: ', mysqli_error($db_spojeni);
  exit();
}

// Zasl�n� SQL p��kazu do datab�ze.
$objekt_vysledku = mysqli_query($db_spojeni, 
  'SELECT * FROM kniha_navstev ORDER BY datum DESC');
if (!$objekt_vysledku)
{
  echo 'Posl�n� SQL p��kazu se nepoda�ilo, sorry';
  echo '<br />';
  echo 'Popis chyby: ', mysqli_error($db_spojeni);
  exit();
}

// Zobrazen� v�ech vr�cen�ch dat.
while ($radek = mysqli_fetch_array($objekt_vysledku))
{
  echo '<hr />';
  echo 'Datum a �as: ',$radek['datum'],'<br />';
  echo 'Napsal: ',$radek['jmeno'],' (',$radek['email'],')<br />';
  echo 'Z�pis: ',$radek['zapis'],'<br />';
  echo '<br />';
}
 
// Zav�en� objektu v�sledku, proto�e u� ho nebudeme pou��vat.
mysqli_free_result($objekt_vysledku);
 
// Odpojen� od datab�ze.
if ($db_spojeni)
  mysqli_close($db_spojeni);
 
?>
</body>
</html>

