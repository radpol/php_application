<?php 
 
// P�ipojen� k datab�zi.
$db_spojeni = mysqli_connect
  ('localhost', 'root', 'lokomotiva', 'test', 3306);
 
// Otestov�n�, zda se p�ipojen� poda�ilo.
if (!$db_spojeni)
  die('P�ipojen� se nepoda�ilo');
 
// Zasl�n� SQL p��kazu do datab�ze.
$objekt_vysledku = mysqli_query($db_spojeni, 'SELECT * FROM osoby');
 
// Otestov�n�, zda se zasl�n� SQL p��kazu poda�ilo.
if (!$objekt_vysledku)
  die('Chyba zasl�n� SQL p��kazu')
 
// Z�sk�n� prvn�ho ��dku, tedy osoby.
$prvni_radek = mysqli_fetch_array($objekt_vysledku);
 
// Zobrazen� prvn�ho ��dku dat.
var_dump($prvni_radek);
 
?>

