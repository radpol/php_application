<html>
<head>
<title>Odesl�n� mail�</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
</head>
<body>
<?php
  $email = 'vase.adresa@neco.cz';
  $vysledek = mail($email, 'P�edm�t mailu', 'Text mailu');
  if ($vysledek)
    echo 'Mail �sp�n� odesl�n';
  else
    echo 'Mail nebyl odesl�n, nastala chyba';
?>
</body>
</html>