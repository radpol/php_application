<html>
<head>
<title>Kontrola e-mailov� adresy</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250" />
</head>
<body>
<?php
$mail = $_POST['mail'];
if (ereg('^[^@]@[^@]+[.][a-zA-Z]+$', $mail))
  echo 'E-mailov� adresa je zad�na spr�vn�';
else
  echo 'E-mailov� adresa nen� zad�na spr�vn�';
?>
<br /><br />
<a href="3.php">Zkontrolovat dal�� mail</a>
</body>
