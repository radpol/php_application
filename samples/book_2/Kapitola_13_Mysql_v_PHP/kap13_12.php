<html>
<head>
<title>Kniha n�v�t�v</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
</head>
<body>
<?php 


// -- P�ipojen� k datab�zi a spr�vn� nastaven� �e�tiny --

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


// -- Vlo� nov� z�pis, pokud byl odesl�n formul��em --

// Test, jestli p�i�la data z formul��e.
if (isset($_POST['zprava']))
{
  // Vytvo�en� SQL p��kazu typu INSERT.
  $sql_prikaz = 
    "INSERT INTO kniha_navstev(datum,jmeno,email,zapis) "
    ."VALUES(NOW(),'"
    .mysqli_real_escape_string($db_spojeni,$_POST['jmeno'])
    ."','"
    .mysqli_real_escape_string($db_spojeni,$_POST['email'])
    ."','"
    .mysqli_real_escape_string($db_spojeni,$_POST['zprava'])
    ."')"
    ;

  // Zasl�n� SQL p��kazu do datab�ze.
  $objekt_vysledku = mysqli_query($db_spojeni, $sql_prikaz);
 
  if (!$objekt_vysledku)
  {
    echo 'Posl�n� SQL p��kazu se nepoda�ilo, sorry';
    echo '<br />';
    echo 'Popis chyby: ', mysqli_error($db_spojeni);
    exit();
  }
  echo 'Nov� z�pis do knihy n�v�t�v p�id�n.<br />';
}


// -- Vypi� v�echny z�pisy v knize n�v�t�v --

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
echo '<hr />';


// -- Odpojen� od datab�ze --

// Zav�en� objektu v�sledku, proto�e u� ho nebudeme pou��vat.
mysqli_free_result($objekt_vysledku);
 
// Odpojen� od datab�ze.
if ($db_spojeni)
  mysqli_close($db_spojeni);


// -- Formul�� pro vkl�d�n� nov�ch z�pis� --
?>
<form name="kniha" action="" method="post">
<b>Jm�no:</b><br />
<input name="jmeno" size="40"><br />
<br />
<b>Mail:</b><br />
<input name="email" size="40"><br />
<br />
<b>Zpr�va:</b><br />
<textarea name="zprava" rows="5" cols="30"></textarea><br />
<br />
<input type="submit" value="Odeslat zpr�vu">
</form>

</body>
</html>

