<html>
<head>
<title>Odesl�n� v�ce p��jemc�m</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
</head>
<body>
<?php
  $email = 'prvni.adresa@neco.cz,druha.adresa@neco.cz';
  $vysledek = mail($email, 'P�edm�t mailu',  
    "��dek 1\n��dek 2\n��dek 3");
  if ($vysledek)
    echo 'Mail �sp�n� odesl�n';
  else
    echo 'Mail nebyl odesl�n, nastala chyba';
?>
</body>
</html>
