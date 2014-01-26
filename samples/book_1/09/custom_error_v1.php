<?php
// Nejprve vytvo��me vlastn� rutinu pro o�et�en� chyb.
function handler( $typ, $zpr�va, $soubor, $��dek ) {
  echo "<h1>Informace o chyb�</h1>";
  echo "B�hem zpracov�n� t�to str�nky do�lo k chyb�. Informujte ";
  echo "<a href=\"mailto:admin@dom�na.cz\">spr�vce</a>.<br><br>";
  echo "<b>Zji�t�n� informace</b><br><br>";
  echo "<b>Typ chyby:</b> $typ<br>";
  echo "<b>Chybov� hl�en�:</b> $zpr�va<br>";
  echo "<b>Soubor s chybou:</b> $soubor<br>";
  echo "<b>K chyb� do�lo na ��dku:</b> $��dek";
}

// Aktivace rutiny pro o�et�en� chyb.
set_error_handler( "handler" );
// �et�zec bude obsahovat chybn� napsan� slovo "Press" .
$�et�zec = "Knihy nakladatelstv� Computer Perss jsou skv�l�!";

/*
 * Pokuste se k nahrazen� chybn�ho pod�et�zce pou��t funkci
 * str_replace(). Tento pokus vy�st� v chybu typu E_WARNING.
 * D�vodem je u�it� nespr�vn�ho po�tu argument� funkce.
 */
str_replace( "Perss", "Press" );

?>
