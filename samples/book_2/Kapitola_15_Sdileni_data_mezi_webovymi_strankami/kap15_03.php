<?php
  session_start();
?>
<html>
<head>
<title>Uk�zka pr�ce se session</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
</head>
<body>
<?php
  if (isset($_SESSION['cislo']))
    echo 'Session u� obsahuje prom�nnou cislo = ', $_SESSION['cislo'];
  else
  {
    $_SESSION['cislo'] = 333;
    echo 'Do session byla ulo�ena nov� prom�nn� cislo';
  }
?>
</body>
</html>
