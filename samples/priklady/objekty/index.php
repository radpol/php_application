<html>
<head>
</head>
<body>
<?php
include_once 'Utvar.php';
include_once 'Stvoruholnik.php';
include_once 'HtmlTabulka.php';
$utvar = new Utvar("*", "0", 10, 20);
echo $utvar->vykresli();
echo '<br>';
$stvoruholnik = new Stvoruholnik('*', '0', 20, 5);
echo $stvoruholnik->vykresli();
echo '<br>';
$tabulka = new HtmlTabulka();
$tabulka->nastavParametre(5, 10,5);
$htmlKod = $tabulka->vykresli();
echo $htmlKod;

?>
</body>
</html>

