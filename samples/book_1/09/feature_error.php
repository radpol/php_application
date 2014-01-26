<?php
// Nejprve vytvo��me vlastn� rutinu pro o�et�en� chyb.
function handler($typ, $zpr�va, $soubor, $��dek) {

    $msg = 'P�i zpracov�n� str�nky do�lo k chyb�m.' . "\n\n";
    $msg .= 'Typ chyby: ' . $typ . "\n";
    $msg .= 'Chybov� zpr�va: ' . $zpr�va . "\n";
    $msg .= 'N�zev souboru: ' . $soubor . "\n";
    $msg .= '��slo ��dku: ' . $��dek . "\n";
    $msg = wordwrap($msg, 75);

    switch($typ) {
    case E_ERROR:
        mail('admin@priklad.cz', 'Z�va�n� chyba webov� prezentace', $msg);
        die();
        break;
          
    case E_WARNING:
        mail('admin@priklad.cz', 'M�n� z�va�n� chyba webov� prezentace', $msg);
        break;
    }
}

/*
 * Po nastaven� oznamov�n� chyb na nulu bude o varov�n�ch a chyb�ch
 * informov�n pouze spr�vce.
 */
error_reporting(0);

// Nastavte funkci pro o�et�en� chyb.
set_error_handler('handler');

/*
 * Sem vlo�te zbytek k�du str�nky. Tento k�d zde nebudeme uv�d�t.
 * Spokoj�me se s odesl�n�m e-mailu spr�vci. Nezapome�te, �e z�va�n� chyby
 * zastav� b�h skriptu i nyn�, ov�em informace o nich se zobraz� jen spr�vci.
 */
?>