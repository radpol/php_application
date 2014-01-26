<html>
<head></head>
<body>
	<?php
	session_start();
	$_SESSION["mail"] = $_POST["policko"];
	$mail = $_SESSION["mail"];
	echo "Zadali ste tuto adresu: ",$mail ,'<br>';
	$nasielSom1Zavinac = false;
	$nasielSomBodku = false;
	$jeNiecoZaBodkou = false;
	for ($i = 0; $i < StrLen($mail); $i++) {
		if ($mail[$i] == '@' && $i>0) {
			if (!$nasielSom1Zavinac){
			$nasielSom1Zavinac = true;
			} else {
				$nasielSom1Zavinac = false;
			}
		}
		if ($nasielSom1Zavinac && $mail[$i] == '.') {
			$nasielSomBodku = true;
		}
		if ($nasielSom1Zavinac && $nasielSomBodku && $mail[$i] != '.') {
			$jeNiecoZaBodkou = true;
		}
	}
	if ($nasielSom1Zavinac && $nasielSomBodku && $jeNiecoZaBodkou) {
		echo "Zadali ste spravnu mailovu adresu";
	}else {
		echo "Zadali ste nespravnu mailovu adresu";
	}
	echo '<br>';

	?>
	<a href="index.html">Navrat</a>
</body>
</html>



