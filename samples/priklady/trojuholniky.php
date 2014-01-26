<html>
<head>
<title>Trojuholniky</title>
</head>
<body>
	<?php
	
	for ($riadok = 1; $riadok < 10; $riadok++) {
		echo  '<br>';
		for ($i = 1; $i <= $riadok ; $i++) {
			echo '*';
		}
	}
	
	for ($riadok1 = 10; $riadok1>=1; $riadok1--) {
		echo '<br>';
		for ($p = 1; $p <= $riadok1; $p++) {
			echo '*';
		}
	}
	echo '<br>';
	for ($riadok = 1; $riadok < 10; $riadok++) {
		echo  '<br>';
		for ($i = 1; $i <= $riadok ; $i++) {
			echo '*';
		}
	}
	
	?>
</body>
</html>