<?php
$db = mysql_connect('localhost', 'uzivatel', 'heslo') or
die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');
mysql_select_db('moviesite', $db) or die(mysql_error($db));

// Upravte cestu tak, aby odpov�dala va�emu um�st�n�.
$dir ='C:/Program Files/Apache Software Foundation/Apache2.2/htdocs/obrazky';

// Nejprve se ujist�te, �e p�enos prob�hl v po��dku.
if ($_FILES['uploadfile']['error'] != UPLOAD_ERR_OK) {
  switch ($_FILES['uploadfile']['error']) {
    case UPLOAD_ERR_INI_SIZE:
      die('Velikost p�en�en�ho souboru p�es�hla hodnotu ' .
                'upload_max_filesize definovanou v souboru php.ini.');
      break;
    case UPLOAD_ERR_FORM_SIZE:
      die('Velikost p�en�en�ho souboru p�es�hla hodnotu MAX_FILE_SIZE ' .
                'ur�enou ve formul��i HTML.');
      break;
    case UPLOAD_ERR_PARTIAL:
      die('Soubor byl p�enesen jen ��ste�n�.');
      break;
    case UPLOAD_ERR_NO_FILE:
      die('Nebyl p�enesen ��dn� soubor.');
      break;
    case UPLOAD_ERR_NO_TMP_DIR:
      die('Server nem� k dispozici do�asn� adres��.');
      break;

    case UPLOAD_ERR_CANT_WRITE:
      die('Serveru se nepoda�ilo ulo�it p�enesen� soubor na disk.');
      break;
    case UPLOAD_ERR_EXTENSION:
      die('P�enos souboru zastaven dopl�kem PHP.');
      break;
  }
}

// Zji�t�n� informac� o p�enesen�m souboru.
$image_caption = $_POST['caption'];
$image_username = $_POST['username'];
$image_date = date('Y-m-d');
list($width, $height, $type, $attr) =
  getimagesize($_FILES['uploadfile']['tmp_name']);

// Zkontrolujte, zda podporujete form�t p�enesen�ho souboru.

// Odstra�te n�sleduj�c� ��dky
switch ($type) {
  case IMAGETYPE_GIF:
    $image = imagecreatefromgif($_FILES['uploadfile']['tmp_name']) or
    die('Form�t p�enesen�ho souboru nen� podporov�n.');
    $ext = '.gif';
    break;
  case IMAGETYPE_JPEG:
    $image = imagecreatefromjpeg($_FILES['uploadfile']['tmp_name']) or
    die('Form�t p�enesen�ho souboru nen� podporov�n.');
    $ext = '.jpg';
    break;
  case IMAGETYPE_PNG:
    $image = imagecreatefrompng($_FILES['uploadfile']['tmp_name']) or
    die('Form�t p�enesen�ho souboru nen� podporov�n.');
    $ext = '.png';
    break;
  default:
    die('Form�t p�enesen�ho souboru nen� podporov�n.');
  }
  // Konec odstran�n�ch ��dk�.

  $error = 'Form�t p�enesen�ho souboru nen� podporov�n.';
  switch ($type) {
    case IMAGETYPE_GIF:
      $image = imagecreatefromgif($_FILES['uploadfile']['tmp_name']) or
      die($error);
      break;
    case IMAGETYPE_JPEG:
      $image = imagecreatefromjpeg($_FILES['uploadfile']['tmp_name']) or
      die($error);
      break;
    case IMAGETYPE_PNG:
      $image = imagecreatefrompng($_FILES['uploadfile']['tmp_name']) or
      die($error);
      break;
    default:
      die($error);
    }

    // Ulo�te informace do tabulky.
    $query = 'INSERT INTO images (image_caption, image_username, image_date)
              VALUES ("' . $image_caption . '", "' . $image_username . '", "'
             . $image_date . '")';
    $result = mysql_query($query, $db) or die (mysql_error($db));

    // Na�ten� identifik�toru obr�zk� generovan�ho datab�z� MySQL automaticky
    // p�i vlo�en� nov�ho z�znamu.
    $last_id = mysql_insert_id();

    // Odstra�te n�sleduj�c� ��dky

    // Jeliko� je tento ID jedine�n�, lze jej pou��t jako n�zev souboru.
    // Budete pak m�t jistotu, �e existuj�c� obr�zek nebude p�eps�n.
    $imagename = $last_id . $ext;


    // N�zev c�lov�ho souboru zn�me a� nyn�,
    // proto je t�eba tabulku aktualizovat.
    $query = 'UPDATE images
              SET image_filename = "' . $imagename . '"
              WHERE image_id = ' . $last_id;
    $result = mysql_query($query, $db) or die (mysql_error($db));

    switch ($type) {
      case IMAGETYPE_GIF:
        imagegif($image, $dir . '/' . $imagename);
        break;
      case IMAGETYPE_JPEG:
        imagejpeg($image, $dir . '/' . $imagename, 100);
        break;
      case IMAGETYPE_PNG:
        imagepng($image, $dir . '/' . $imagename);
        break;
    }
    // Konec odstran�n�ch ��dk�.

    // Ulo�te obr�zek na c�lov� m�sto.
    $imagename = $last_id . '.jpg';
    imagejpeg($image, $dir . '/' . $imagename);
    imagedestroy($image);
    ?>
<html>
  <head>
    <title>Zde je v� obr�zek!</title>
  </head>
  <body>
    <h1>Tak�e, jak� to je, b�t slavn�?</h1>
    <p>Zde je obr�zek, kter� jste pr�v� odeslali na n� server:</p>
    <img src="obrazky/<?php echo $imagename; ?>" style="float:left;">
    <table>
      <tr><td>Obr�zek je ulo�en jako: </td>
      <!-- Odstra�te tento ��dek:
    <tr><td>Typ obr�zku: </td><td><?php echo $ext; ?></td></tr>
    -->
      <tr><td>V��ka: </td><td><?php echo $height; ?></td></tr>
      <tr><td>���ka: </td><td><?php echo $width; ?></td></tr>
      <tr><td>Datum ulo�en�: </td><td><?php echo $image_date; ?></td></tr>
    </table>
  </body>
</html>
