<html>
<head>
<title>Informace o figu�e</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
</head>
<body>
<?php
 
$vaha = $_POST['vaha'];
$vyska = $_POST['vyska'];
 
$vyska_v_metrech = $vyska / 100.0;

$BMI = $vaha / ($vyska_v_metrech * $vyska_v_metrech);
 
echo 'Va�e BMI = ', $BMI;
echo '<br /><br />';
 
if ($BMI < 15)
  echo 'Jste podvy�iven�/�';
else if ($BMI < 18.5)
  echo 'M�te podv�hu';
else if ($BMI < 25)
  echo 'M�te ide�ln� postavu';
else if ($BMI < 30)
  echo 'M�te nad�hu';
else if ($BMI < 40)
  echo 'Jste ob�zn�';
else
  echo 'Jste nadm�rn� ob�zn�';
 
?>
</body>
</html>
