<?php
  var_dump('30' == '+30');
  // Podm�nka je pravdiv�, proto�e PHP porovn�
  // �et�zce jako ��sla, vyp�e se tedy bool(true)
 
  echo '<br>';
  // Zajist�, aby se dal�� v�pis vypsal
  // na dal�� ��dku.
 
  var_dump('30x' == '+30x');
  // Podm�nka nen� pravdiv�, proto�e PHP porovn�
  // �et�zce jako texty, vyp�e se tedy bool(false)
?>
