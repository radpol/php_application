<html>
<head>
<title>Odesl�n� zpr�vy</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
</head>
<body>
<?php
  $zprava = $_POST['zprava'];
  $email = 'vase.adresa@neco.cz';
  $vysledek = mail($email, 'Mail z WWW', $zprava);
  if ($vysledek)
    echo 'Zpr�va byla �sp�n� odesl�na';
  else
    echo 'Zpr�va nebyla odesl�na, nastala chyba';
?>
</body>
</html>
