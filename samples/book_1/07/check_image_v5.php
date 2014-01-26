<?php
// p�ipojen� k datab�zi MySQL
$db = mysql_connect('localhost', 'uzivatel', 'heslo') or
  die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');
mysql_select_db('moviesite', $db) or die(mysql_error($db));

// Upravte cestu tak, aby odpov�dala va�emu um�st�n�.
$dir ='C:/Program Files/Apache Software Foundation/Apache2.2/htdocs/obrazky';

// Upravte cestu tak, aby odpov�dala va�emu um�st�n�.
$thumbdir = $dir . '/miniatury';

// Upravte cestu tak, aby odpov�dala va�emu um�st�n�.
putenv('GDFONTPATH=C:/Windows/Fonts');
$font = 'C:/Windows/Fonts/arial.ttf';

// Obsluha p�en�en�ch soubor�.
if ($_POST['submit'] == 'Odeslat') {

  // Nejprve se ujist�te, �e p�enos prob�hl v po��dku.
  if ($_FILES['uploadfile']['error'] != UPLOAD_ERR_OK)
  {
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
  $image_date = @date('Y-m-d');
  list($width, $height, $type, $attr) =
  getimagesize($_FILES['uploadfile']['tmp_name']);

  // Zkontrolujte, zda podporujete form�t p�enesen�ho souboru.
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

    // Ulo�en� obr�zku na kone�n� m�sto.
    $image_id = $last_id;
    imagejpeg($image, $dir . '/' . $image_id  . '.jpg');
    imagedestroy($image);

  } else {
    // Zji�t�n� informac� o obr�zku.
    $query = 'SELECT
                  image_id, image_caption, image_username, image_date
              FROM
                  images
              WHERE
                  image_id = ' . $_POST['id'];
    $result = mysql_query($query, $db) or die (mysql_error($db));
    extract(mysql_fetch_assoc($result));

    list($width, $height, $type, $attr) = getimagesize($dir . '/' . $image_id .
        '.jpg');
  }

  if ($_POST['submit'] == 'Ulo�it') {
    // Ov��te platnost obr�zku.
    if (isset($_POST['id']) && ctype_digit($_POST['id']) &&
      file_exists($dir . '/' . $_POST['id'] . '.jpg')) {
      $image = imagecreatefromjpeg($dir . '/' . $_POST['id'] . '.jpg');
    } else {
      die('Zad�n neplatn� obr�zek.');
    }

    // Aplikace filtru.
    $effect = (isset($_POST['effect'])) ? $_POST['effect'] : -1;
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

    // Po�aduje-li to u�ivatel, p�idejte popisek.
    if (isset($_POST['emb_caption'])) {
      imagettftext($image, 12, 0, 20, 20, 0, $font, $image_caption);
    }

    // Po�aduje-li to u�ivatel, p�idejte vodoznak s logem.
    if (isset($_POST['emb_logo'])) {
      // Zjist�te sou�adnice x a y k vyst�ed�n� vodoznaku.
      list($wmk_width, $wmk_height) = getimagesize('obrazky/logo.png');
      $x = ($width - $wmk_width) / 2;
      $y = ($height - $wmk_height) / 2;

      $wmk = imagecreatefrompng('obrazky/logo.png');
      imagecopymerge($image, $wmk, $x, $y, 0, 0, $wmk_width, $wmk_height, 20);
      imagedestroy($wmk);
    }

    // Ulo�te obr�zek po aplikaci filtru.
    imagejpeg($image, $dir . '/' . $_POST['id'] . '.jpg', 100);

    // Nastavte rozm�ry miniatury.
    $thumb_width = $width * 0.10;
    $thumb_height = $height * 0.10;

    // Vytvo�te miniaturu.
    $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
    imagecopyresampled($thumb, $image, 0, 0, 0, 0, $thumb_width, $thumb_height,
      $width, $height);
    imagejpeg($thumb, $dir . '/' . $_POST['id'] . '.jpg', 100);
    imagedestroy($thumb);
    ?>
<html>
  <head>
    <title>Zde je v� obr�zek!</title>
  </head>
  <body>
    <h1>Obr�zek byl �sp�n� ulo�en!</h1>
    <img src="obrazky/<?php echo $_POST['id']; ?>.jpg" />
  </body>
</html>
<?php
} else {
?>
<html>
  <head>
    <title>Zde je v� obr�zek!</title>
  </head>
  <body>
    <h1>Tak�e, jak� to je, b�t slavn�?</h1>
    <p>Zde je obr�zek, kter� jste pr�v� odeslali na n� server:</p>
    <?php
    if ($_POST['submit'] == 'Odeslat') {
      $imagename = 'obrazky/' . $image_id  . '.jpg';
    } else {
      $imagename = 'image_effect.php?id=' . $image_id  . '&e=' .
      $_POST['effect'];

      if (isset($_POST['emb_caption'])) {
        $imagename .= '&capt=' . urlencode($image_caption);
      }

      if (isset($_POST['emb_logo'])) {
        $imagename .= '&logo=1';
      }
    }
    ?>
    <img src="<?php echo $imagename; ?>" style="float:left;">
    <table>
      <tr><td>Obr�zek je ulo�en jako: </td>
        <td><?php echo $image_id  . '.jpg'; ?></td></tr>
      <tr><td>V��ka: </td><td><?php echo $height; ?></td></tr>
      <tr><td>���ka: </td><td><?php echo $width; ?></td></tr>
      <tr><td>Datum ulo�en�: </td><td><?php echo $image_date; ?></td></tr>
    </table>
    <p>Obr�zek m��ete upravit n�kolika zp�soby. Pozn�mka: Po ulo�en� se zm�ny
    <em>stanou nevratn�</em>.</p>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <div>
        <input type="hidden" name="id" value="<?php echo $image_id;?>"/>
        Filtr: <select name="effect">
          <option value="-1">��dn�</option>
          <?php
          echo '<option value="' . IMG_FILTER_GRAYSCALE . '"';
          if (isset($_POST['effect']) && $_POST['effect'] ==
            IMG_FILTER_GRAYSCALE) {
            echo ' selected="selected"';
          }
          echo '>�ernob�l�</option>';

          echo '<option value="' . IMG_FILTER_GAUSSIAN_BLUR . '"';
          if (isset($_POST['effect']) && $_POST['effect'] ==
            IMG_FILTER_GAUSSIAN_BLUR) {
            echo ' selected="selected"';
          }
          echo '>Rozmazat</option>';

          echo '<option value="' . IMG_FILTER_EMBOSS . '"';
          if (isset($_POST['effect']) && $_POST['effect'] ==
            IMG_FILTER_EMBOSS) {
            echo ' selected="selected"';
          }
          echo '>Reli�f</option>';

          echo '<option value="' . IMG_FILTER_NEGATE . '"';
          if (isset($_POST['effect']) && $_POST['effect'] ==
            IMG_FILTER_NEGATE) {
            echo ' selected="selected"';
          }
          echo '>Negativ</option>';
          ?>
        </select>
        <br/><br/>
        <?php
        echo '<input type="checkbox" name="emb_caption"';
        if (isset($_POST['emb_caption'])) {
          echo ' checked="checked"';
        }
        echo '>Vlo�it do obr�zku popisek?';
        echo '<br/><br/><input type="checkbox" name="emb_logo"';
        if (isset($_POST['emb_logo'])) {
          echo ' checked="checked"';
        }
        echo '>Vlo�it do obr�zku vodoznak loga?';
        ?>
        <br/><br/>
        <input type="submit" value="N�hled" name="submit" />
        <input type="submit" value="Ulo�it" name="submit" />
      </div>
    </form>
  </body>
</html>
<?php
}
?>