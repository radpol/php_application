<?php
  $pole = array(10,20);
  // Vytvo�en� pole, ve kter�m budou ulo�eny dv� ��sla: des�tka
  // a dvac�tka.
  // Des�tka m� index nula a dvac�tka m� index jedna.
 
  var_dump( $pole[1] );
  // Vyp�e: 20
 
  // Bylo vyps�no ��slo 20, proto�e z�pis $pole[1] znamen�, �e
  // pracujete s ��slem, kter� bylo v poli ulo�eno pod indexem
  // jedna. A to je v tomto p��pad� pr�v� ��slo 20.
?>
