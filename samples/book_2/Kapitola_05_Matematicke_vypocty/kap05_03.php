<?php
  $x = 3;
 
  $y = $x++;
  // Dojde ke zv�t�en� $x o jedni�ku (tedy v $x bude 4), ale
  // v�sledkem v�razu $x++ je star� hodnota $x, tak�e do
  // prom�nn� $y se p�i�ad� hodnota prom�nn� $x je�t� p�ed
  // p�i�ten�m jedni�ky (tedy v $y bude 3).
 
  echo '$x = ', $x, '<br>';
  // Vyp�e: $x = 4
  echo '$y = ', $y, '<br>';
  // Vyp�e: $y = 3
?>
