<html>
 <head>
<title>Za��n�me s v�vojem v PHP6, Apache a MySQL - Chybov� str�nka</title>
 </head>
 <body>
<?php
switch ($_SERVER['QUERY_STRING']) {
  case 400:
    echo '<h1>Chybn� po�adavek</h1>';
    echo '<h2>K�d chyby 400</h2>';
    echo '<p>Hledan� str�nka mohla b�t odebr�na, p�ejmenov�na ' .
         'nebo je do�asn� nedostupn�.</p>';
    break;
     
  case 401:
    echo '<h1>P�ihl�en� selhalo</h1>';
    echo '<h2>K�d chyby 401</h2>';
    echo '<p>Zadan� pov��en� neoprav�uj� k prohl�en� tohoto ' .
         'adres��e nebo str�nky.</p>';
    break;
  
  case 403:
    echo '<h1>P��stup zak�z�n</h1>';
    echo '<h2>K�d chyby 403</h2>';
    echo '<p>Zadan� pov��en� neoprav�uj� k prohl�en� tohoto ' .
         'adres��e nebo str�nky.</p>';
    break;
     
  case 404:
    echo '<h1>Soubor nebyl nalezen</h1>';
    echo '<h2>K�d chyby 404</h2>';
    echo '<p>Hledan� str�nka mohla b�t odebr�na, p�ejmenov�na ' .
         'nebo je do�asn� nedostupn�.</p>';
    break;

  case 500:
    echo '<h1>Vnit�n� chyba serveru</h1>';
    echo '<h2>K�d chyby 500</h2>';
    echo '<p>Na str�nce, ke kter� se pokou��te p�ipojit, do�lo ' .
         'k probl�m�m a nelze ji zobrazit.</p>';
    break;
     
  default:
    echo '<h1>Informace o chyb�</h1>';
    echo '<p>To je vlastn� chybov� str�nka...</p>';
}

echo '<p>Pokud p�edpokl�d�te, �e byste m�li m�t mo�nost' .
     'zobrazit dan� adres�� nebo str�nku, obra�te se na ' .
     '<a href="mailto:sysadmin@priklad.cz">spr�vce webov�ho serveru</a>.</p>';

$now = (isset($_SERVER['REQUEST_TIME'])) ? $_SERVER['REQUEST_TIME'] : time();
$page = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : 'nezn�m�';

$msg = wordwrap('Kdy� se n�v�t�vn�k pokusil zobrazit str�nku ' . $page .
  ' dne ' . date('F d, Y', $now) . ' v ' . date('H:i:sa T', $now) . 
  ' do�lo k chyb� ' . $_SERVER['QUERY_STRING'] . '.');

mail('admin@priklad.cz', 'Chyba webov� str�nky', $msg);
?>
 </body>
</html>