<html>
<head>
<title>Nastaven� odes�latele mailu</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
</head>
<body>
<?php
  $email = 'vase.adresa@neco.cz';
  $hlavicky  = "From:janosik@neco.cz\n";
  $vysledek = mail($email, 'P�edm�t mailu',  "Text mailu", $hlavicky);
  if ($vysledek)
    echo 'Mail �sp�n� odesl�n';
  else
    echo 'Mail nebyl odesl�n, nastala chyba';
?>
</body>
</html>
