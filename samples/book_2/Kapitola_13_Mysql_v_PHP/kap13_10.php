<html>
<head>
<title>P�id�n� z�pisu</title>
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
  echo 'Nov� z�pis do knihy n�v�t�v p�id�n.';
}

// Odpojen� od datab�ze.
if ($db_spojeni)
  mysqli_close($db_spojeni);
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

