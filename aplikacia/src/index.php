<?php
if (isset ( $_POST ["policko"] )) { //v poli $_POST ci sa nasiel zaznam na index policko
	//include_once 'autoloader.php';  // look autoloader
	include_once 'Validation.php';  // look autoloader
	//include_once 'User.php';  // look autoloader
	
	
	$validate = new Validation ();
	$result = $validate->validEmailAdress ( $_POST ['policko'] );
	var_dump($result);
	
	//$user = new User();
	
	
	//if true redirect
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
</head>
<body>

	<form method="post" action="index.php">
		<p>Zadaj mail:</p>
		<input type="text" name="policko"> <input type="submit" name="submit"
			value="odosli"><br>
	</form>
</body>
</html>