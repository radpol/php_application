<?php
// vezme identifik�tor re�is�ra a vr�t� jeho cel� jm�no
function na�ti_re�is�ra($id_re�is�ra) {                  
    global $db;
                   
    $dotaz = 'SELECT people_fullname 
              FROM people
              WHERE people_id = ' . $id_re�is�ra;
    $v�sledky = mysql_query($dotaz, $db) or die(mysql_error($db));
                   
    $��dek = mysql_fetch_assoc($v�sledky);
    extract($��dek);
                   
    return $people_fullname;
}
                   
// vezme identifik�tor hlavn�ho akt�ra a vr�t� jeho cel� jm�no
function na�ti_hlakt�ra($id_hlakt�ra) {                   
    global $db;
                   
    $dotaz = 'SELECT people_fullname
              FROM people 
              WHERE people_id = ' . $id_hlakt�ra;
    $v�sledky = mysql_query($dotaz, $db) or die(mysql_error($db));
                   
    $��dek = mysql_fetch_assoc($v�sledky);
    extract($��dek);
                   
    return $people_fullname;
}
                   
// vezme identifik�tor ��nru a vr�t� jeho smyslupln� textov� popis
function na�ti_��nr($id_��nru) {                  
    global $db;
                   
    $dotaz = 'SELECT movietype_label
              FROM movietype
              WHERE movietype_id = ' . $id_��nru;
    $v�sledky = mysql_query($dotaz, $db) or die(mysql_error($db));
                   
    $��dek = mysql_fetch_assoc($v�sledky);
    extract($��dek);
                   
    return $movietype_label;
}

// p�ipoj se k MySQL
$db = mysql_connect('localhost', 'uzivatel', 'heslo') or
    die('Nemohu se p�ipojit. Zkontrolujte p�ipojovac� parametry.');
                   
// zajisti, abychom pou��vali spr�vnou datab�zi
mysql_select_db('moviesite', $db) or die(mysql_error($db));

// na�ti informace
$dotaz = 'SELECT movie_id, movie_name, movie_year, movie_director, 
                 movie_leadactor, movie_type
          FROM movie
          ORDER BY movie_name ASC,
                   movie_year DESC';
$v�sledky = mysql_query($dotaz, $db) or die(mysql_error($db));
                   
// zjisti po�et ��dk� ve v�sledku
$po�et_film� = mysql_num_rows($v�sledky);

$tabulka = <<<ENDHTML
<div style="text-align: center;">
  <h2>Datab�ze s recenzemi film�</h2>
  <table border="1" cellpadding="2" cellspacing="2"
         style="width: 70%; margin-left: auto; margin-right: auto;">
    <tr>
      <th>N�zev filmu</th>
      <th>Rok uveden� na pl�tna kin</th>
      <th>Re�is�r</th>
      <th>V hlavn� roli</th>
      <th>Kategorie</th>
    </tr>
ENDHTML;

// projdi v�sledky
while ($��dek = mysql_fetch_assoc($v�sledky)) {
  extract($��dek);
  $re�is�r = na�ti_re�is�ra($movie_director);
  $hlakt�r = na�ti_hlakt�ra($movie_leadactor);
  $��nr = na�ti_��nr($movie_type);

  $tabulka .= <<<ENDHTML
  <tr>
    <td>
      <a href="movie_details.php?movie_id=$movie_id"
           title="V�ce informac� o filmu $movie_name">
          $movie_name
      </a>
    </td>
    <td>$movie_year</td>
    <td>$re�is�r</td>
    <td>$hlakt�r</td>
    <td>$��nr</td>
  </tr>
ENDHTML;
}     

$tabulka .= <<<ENDHTML
  </table>
  <p>Po�et film�: $po�et_film�</p>
</div>
ENDHTML;

echo $tabulka;
?>
