<?php
function handler($typ, $zpr�va, $soubor, $��dek) {
  switch ($typ) {
    case E_ERROR:
        echo '<h1>Z�va�n� chyba</h1>';
        echo '<p>V souboru ' . $soubor . ' na ��dku ' .
             $��dek . ' do�lo ke kritick� chyb�.<br/>' . $zpr�va . '.</p>';
        die();
        break;

    case E_WARNING:
        echo '<h1>Varov�n�</h1>';
        echo '<p>V souboru ' . $soubor . ' na ��dku ' . $��dek .
             ' do�lo k m�n� z�va�n� chyb�.<br/>' . $zpr�va . '.';
        break;

    case E_NOTICE:
        // Chyby tohoto typu nebudeme zobrazovat.
        break;
  }
}

// Nastavte obsluhu chyby.
set_error_handler('handler');

// �et�zec bude obsahovat chybn� napsan� slovo "Press" .
$�et�zec = "Knihy nakladatelstv� Computer Perss jsou skv�l�!";

/*
 * Pokuste se k nahrazen� chybn�ho pod�et�zce pou��t funkci
 * str_replace(). Tento pokus vy�st� v chybu typu E_WARNING.
 * D�vodem je u�it� nespr�vn�ho po�tu argument� funkce.
 */
str_replace( "Perss", "Press" );
?>