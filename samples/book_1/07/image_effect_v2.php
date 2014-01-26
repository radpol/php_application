<?php
// Upravte cestu tak, aby odpov�dala va�emu um�st�n�.
$dir ='C:/Program Files/Apache Software Foundation/Apache2.2/htdocs/obrazky';

// Zm��te cestu tak, aby odpov�dala um�st�n� soubor� p�sem ve va�em syst�mu.
// P��padn� vyberte jin� p�smo.
putenv('GDFONTPATH=C:/Windows/Fonts');
$font = 'C:/Windows/Fonts/arial.ttf';

// Ov��te, �e obr�zek je platn�.
if (isset($_GET['id']) && ctype_digit($_GET['id']) && file_exists($dir . '/' .
    $_GET['id'] . '.jpg')) {
    $image = imagecreatefromjpeg($dir . '/' . $_GET['id'] . '.jpg');
} else {
  die('Zad�n neplatn� obr�zek.');
}

// Pou�ijte filtr.
$effect = (isset($_GET['e'])) ? $_GET['e'] : -1;
switch ($effect) {
case IMG_FILTER_NEGATE:
    imagefilter($image, IMG_FILTER_NEGATE); 
    break;
case IMG_FILTER_GRAYSCALE:
    imagefilter($image, IMG_FILTER_GRAYSCALE); 
    break;
case IMG_FILTER_EMBOSS:
    imagefilter($image, IMG_FILTER_EMBOSS); 
    break;
case IMG_FILTER_GAUSSIAN_BLUR:
    imagefilter($image, IMG_FILTER_GAUSSIAN_BLUR);
    break;
}

// Na vy��d�n� p�idejte popisek.
if (isset($_GET['capt'])) {
    imagettftext($image, 12, 0, 20, 20, 0, $font, $_GET['capt']);
}

// Zobrazen� obr�zku.
header('Content-Type: image/jpeg');
imagejpeg($image, '', 100);
?>