<?php
  var_dump(1.0 == 1);
  // Podm�nka je pravdiv�, proto�e re�ln� ��slo
  // 1.0 se rovn� cel�mu ��slu 1.
  // Vyp�e se bool(true)
 
  echo '<br>';
  // Zajist�, aby se dal�� v�pis vypsal
  // na dal�� ��dku.
 
  var_dump(1.0 === 1);
  // Podm�nka je nepravdiv�, proto�e nejsou shodn�
  // typy. ��slo 1.0 pat�� do typu re�ln�ch ��sel
  // a ��slo 1 pat�� do typu cel�ch ��sel.
?>
