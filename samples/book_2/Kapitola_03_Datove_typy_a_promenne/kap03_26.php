<?php
  $a = 1;
  // Prom�nn� $a te� obsahuje jako hodnotu ��slo 1
 
  echo $a;
  // Vyp�e hodnotu prom�nn� $a 
  // Vyp�e: 1
 
  unset($a);
  // Pomoc� konstrukce unset zru��me prom�nnou $a.
  // Od t�to chv�le tedy prom�nn� $a u� neexistuje.
 
  echo $a;
  // Te� bychom m�li vypsat hodnotu prom�nn� $a. Proto�e v�ak
  // prom�nn� $a u� neexistuje, pokou��me se pou��t neexistuj�c�
  // prom�nnou.
  // Pokud je PHP nastaveno tak, aby nepolykalo chyby, vyp�e
  // chybu:
  // Notice: Undefined variable: a in c:\inet_srv\http\doc_root\a.php
  // on line 13
?>
