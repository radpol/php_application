<?php
  $pole = array(1 => 20);
  // Vytvo�en� pole, kter� obsahuje jedno ��slo, a to dvac�tka.
  // Dvac�tka m� index 1.
 
  $pole[10] = 100;
  // Proto�e v poli neexistuje prvek s indexem 10, tak se vytvo��
  // a ulo�� se do n�j ��slo 100.
 
  // Te� u� jsou v poli dva prvky.
  // Index 1 obsahuje 20 a index 10 obsahuje 100.
 
  var_dump($pole);
  // Vyp�e pole.
?>
