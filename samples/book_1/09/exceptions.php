<?php
// $x = null;
// $x = 500;
$x = 1000;

try {
  if (is_null($x)) {
    throw new Exception( 'Prom�nn� nem��e b�t pr�zdn�!' );
  }
  if ($x < 1000) {
    throw new Exception( 'Hodnota prom�nn� nesm� b�t men�� ne� 1000!' );
  }

  echo 'Hodnota pro�la procesem ov��ov�n�!';
}
catch (Exception $e) {
  echo 'Ov��en� selhalo. ' . $e->getMessage();
}
?>