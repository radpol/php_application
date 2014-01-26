<?php
// funkce pro vygenerov�n� hodnocen�
function vygeneruj_hodnocen�($rating) {
    $hodnocen�_filmu = '';
    for ($i = 0; $i < $rating; $i++) {
        $hodnocen�_filmu .= '<img src="star.gif" alt="star"/>';
    }
    return $hodnocen�_filmu;
}

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
                  
// funkce pro v�po�et, zda film byl film ziskov�, 
// ztr�tov� nebo zda z�stal na nule
function spo��tej_rozd�l($v�nosy, $n�klady) {                   
    $rozd�l = $v�nosy - $n�klady;
                   
    if ($rozd�l < 0) {     
        $barva = 'red';
        $rozd�l = abs($rozd�l) . ' mil. dolar�';
    } elseif ($rozd�l > 0) {
        $barva = 'green';
        $rozd�l = $rozd�l . ' mil. dolar�';
    } else {
        $barva = 'blue';
        $rozd�l = '�stal na nule';
    }
                   
    return '<span style="color:'.$barva.';">'.$rozd�l.'</span>';
}
                   
// p�ipoj se k MySQL
$db = mysql_connect('localhost', 'uzivatel', 'heslo') or
    die('Nemohu se p�ipojit. Zkontrolujte p�ipojovac� parametry.');
mysql_select_db('moviesite', $db) or die(mysql_error($db));
                   
// na�ti �daje
$dotaz = '
 SELECT movie_name, movie_year, movie_director, movie_leadactor,
        movie_type, movie_running_time, movie_cost, movie_takings
 FROM movie
 WHERE movie_id = ' . $_GET['movie_id'];
$v�sledky = mysql_query($dotaz, $db) or die(mysql_error($db));
                   
$��dek = mysql_fetch_assoc($v�sledky);
$film_n�zev         = $��dek['movie_name'];
$film_re�is�r       = na�ti_re�is�ra($��dek['movie_director']);
$film_hlaket�r      = na�ti_hlakt�ra($��dek['movie_leadactor']);
$film_rok           = $��dek['movie_year'];
$movie_running_time = $��dek['movie_running_time'] . ' minut';
$film_v�nosy        = $��dek['movie_takings'] . ' mil. dolar�';
$film_n�klady       = $��dek['movie_cost'] . ' mil. dolar�';
$film_bilance       = spo��tej_rozd�l($��dek['movie_takings'],
                          $��dek['movie_cost']);
                   
// zobraz informace
echo <<<ENDHTML
<html>
 <head>
  <title>Podrobn� �daje o filmu: $film_n�zev</title>
 </head>
 <body>
  <div style="text-align: center;">
   <h2>$film_n�zev</h2>
   <h3><em>Podrobnosti</em></h3>
   <table cellpadding="2" cellspacing="2"
    style="width: 70%; margin-left: auto; margin-right: auto;">
    <tr>
     <td><strong>N�zev</strong></strong></td>
     <td>$film_n�zev</td>
     <td><strong>Rok uveden�</strong></strong></td>
     <td>$film_rok</td>
    </tr><tr>
     <td><strong>Re�ie</strong></td>
     <td>$film_re�is�r</td>
     <td><strong>N�klady</strong></td>
     <td>$$film_n�klady<td/>
    </tr><tr>
     <td><strong>V hlavn� roli</strong></td>
     <td>$film_hlaket�r</td>
     <td><strong>V�nosy</strong></td>
     <td>$$film_v�nosy<td/>
    </tr><tr>
     <td><strong>D�lka</strong></td>
     <td>$movie_running_time</td>
     <td><strong>Bilance</strong></td>
     <td>$film_bilance<td/>
    </tr>
   </table>
ENDHTML;

// na�ti recenze pro tento film
$dotaz = '
  SELECT review_movie_id, review_date, reviewer_name, 
         review_comment,review_rating
   FROM reviews
   WHERE review_movie_id = ' . $_GET['movie_id'] . '
   ORDER BY review_date DESC';
                   
$v�sledky = mysql_query($dotaz, $db) or die(mysql_error($db));
                   
// zobraz recenze
echo <<< ENDHTML
   <h3><em>Recenze</em></h3>
   <table cellpadding="2" cellspacing="2"
    style="width: 90%; margin-left: auto; margin-right: auto;">
    <tr>
     <th style="width: 7em;">Datum</th>
     <th style="width: 10em;">Recenzent</th>
     <th>Koment��e</th>
     <th style="width: 5em;">Hodnocen�</th>
    </tr>
ENDHTML;
                   
while ($��dek = mysql_fetch_assoc($v�sledky)) {
    $datum = $��dek['review_date'];
    $jm�no = $��dek['reviewer_name'];
    $koment�� = $��dek['review_comment'];
    $hodnocen� = vygeneruj_hodnocen�($��dek['review_rating']);                  

    echo <<<ENDHTML
    <tr>
      <td style="vertical-align:top; text-align: center;">$datum</td>
      <td style="vertical-align:top;">$jm�no</td>
      <td style="vertical-align:top;">$koment��</td>
      <td style="vertical-align:top;">$hodnocen�</td>
    </tr>
ENDHTML;
}
                   
echo <<<ENDHTML
  </div>
 </body>
</html>     
ENDHTML;
?>
