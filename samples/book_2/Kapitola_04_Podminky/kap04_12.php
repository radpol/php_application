<?php
  var_dump(10 > 20);
  // Tato podm�nka je nepravdiv�.
  // Vyp�e: bool(false)
 
  echo '<br>';
  // Zajist�, aby se dal�� v�pis vypsal
  // na dal�� ��dku.
 
  var_dump(!(10 > 20));
  // Tato podm�nka je pravdiv�, proto�e je
  // je pou�ita operace negace, kter� oto�ila
  // pravdivost podm�nky.
  // Vyp�e: bool(true)
?>
