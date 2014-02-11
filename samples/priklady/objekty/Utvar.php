<?php
class Utvar {
	
	protected  $okraj;
	protected  $vypln;
	protected  $sirka;
	protected  $vyska;
	
	protected  function jeNaOkraji($x,$y){
		$somNaOkraji = FALSE;
		if ($x == $this->vyska-1 || $y == $this->sirka-1 || $x == 0 || $y == 0) {
			$somNaOkraji = TRUE;
		}
		return $somNaOkraji;
		
	}
	
	function Utvar($okraj,$vypln,$sirka,$vyska) {
		$this->okraj = $okraj;
		$this->sirka = $sirka;
		$this->vypln = $vypln;
		$this->vyska = $vyska;
	}
	public function vykresli() {
		$vysledok = "<table><tr><td>Okraj</td><td>".$this->okraj.'</td></tr>';
	    $vysledok = $vysledok . "<tr><td>Vypln</td><td>".$this->vypln.'</td></tr>';
		$vysledok = $vysledok . "<tr><td>Sirka</td><td>".$this->sirka.'</td></tr>';
	    $vysledok = $vysledok . "<tr><td>Vyska</td><td>".$this->vyska.'</td></tr></table>';
		
		return $vysledok;
		}
}