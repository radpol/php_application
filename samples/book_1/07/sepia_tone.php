<?php
// Upravte cestu tak, aby odpov�dala va�emu um�st�n�.
$dir ='C:/Program Files/Apache Software Foundation/Apache2.2/htdocs/images';

$image = imagecreatefromjpeg($dir . '/1.jpg');

// Odeberte informace o barv�: vytvo�te �ernob�l� obr�zek.
imagefilter($image, IMG_FILTER_GRAYSCALE);

// Pou�ijte nahn�dl� odst�n.
imagefilter($image, IMG_FILTER_COLORIZE, 0xFF, 0xB9, 0x80, 30);

// Zobrazte obr�zek.
header('Content-Type: image/jpeg');
imagejpeg($image, '', 100);
?>
