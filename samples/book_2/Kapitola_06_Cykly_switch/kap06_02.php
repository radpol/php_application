<?php
  $i = 1;
  // Za�neme vypisovat ��sla od jedn�.
 
  while ($i <= 10)
  {
    if ($i > 2)
      break;
    // Jestli�e prom�nn� $i obsahuje ��slo v�t��, ne� 2, pak
    // se vykon� p��kaz break a cyklus se p�ed�asn� ukon��.
 
    echo $i,' ';
    // Vypi� ��slo ulo�en� v prom�nn� $i a pak vypi� mezeru,
    // aby ��sla nebyla nalepen� hned na sob�.
 
    ++$i;
    // Inkrementace prom�nn� $i, tedy zv�t�en� ��sla o jedni�ku.
  }
?>
