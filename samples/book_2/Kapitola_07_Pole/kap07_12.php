<?php
  $pole = array(1 => 100, 2 => 150);
  // Vytvo�en� pole, kter� obsahuje dv� ��sla: sto a dv�st�.
  // Index 1 m� ulo�enou stovku a index 2 m� ulo�enou dvoustovku.
 
  foreach ($pole as $index => $prvek)
    echo 'Nalezen index: ',$index,', prvek: ',$prvek,'<br>';
  // Toto je konstrukce foreach, kter� proch�z� pole $pole a ka�d� prvek
  // vyp�e jeho index a vlastn� prvek.
?>
