<html>
<head>
<title>polia</title>
</head>
<body>
	<?php
	echo "stvorec hviezdicky, 0, diagonala 1<br>";
	$x = 10; $y = 10;
	for ($dlzka = 1; $dlzka <= $y; ++$dlzka){
		echo '<br>';
		for ($sirka = 1; $sirka <= $x; ++$sirka){
			// 			echo '*';
			if ($dlzka == 1 || $sirka == 1 || $sirka == $x || $dlzka == $y) {
				echo '*';
			} else {
				// 				echo '0';
				if ($dlzka == $sirka) {
					echo '1';
				} else {
					echo '0';
				}
			}

		}
	}
	echo 'matica 1..100, kazde 2he bold, italic<br>';
	$i = 1;
	while ($i <= 100){
		if ($i % 2 == 0) {
			echo '<b><i>';
		}
		if ($i <= 9) {
			echo '0';
		}
		echo $i,', ';
		if ($i % 2 == 0) {
			echo  '</i></b>';
		}

		if ($i % 10 == 0) {
		echo '<br>';
	}
	++$i;

	?>
</body>
</html>
