<?php
  $pole = array(1,2,3,4,5);
  // Vytvo�en� pole, ve kter�m budou ulo�eno p�t ��sel.
  // Jedni�ka m� index nula, dvojka m� index jedna, trojka m� index 
  // dva, �ty�ka m� index t�i a p�tka m� index �ty�i.
 
  $pole[3] = 10;
  // Zm�na prvku v poli, kter� m� index t�i. Na tomto indexu byla
  // p�vodn� �ty�ka, te� jsme tam ulo�ili nam�sto n� des�tku.
 
  // Pole te� obsahuje ��sla: 1,2,3,10,5.
 
  var_dump($pole);
  // Vyp�e: ???
  // Vyps�n� cel�ho pole.
?>
