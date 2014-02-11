<?php
class Stvoruholnik extends Utvar {
	
	public function vykresli() {
		$vysledok = "";
		for($i = 0; $i < $this->vyska; $i ++) {
			for($j = 0; $j < $this->sirka; $j ++) {
				if ($this->jeNaOkraji($i, $j)) {
					$vysledok = $vysledok . $this->okraj;
				} else {
					$vysledok = $vysledok.$this->vypln;
				}
				//$vysledok = $vysledok . $this->okraj;
			}
			$vysledok = $vysledok . '<br>';
		}
		return $vysledok;
		
	}
	
}