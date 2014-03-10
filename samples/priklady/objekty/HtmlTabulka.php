<?php
class HtmlTabulka {
	
	private $pocetRiadkov;
	private $pocetStlpcov;
	
	private final $TABULKA_ZAC = "<table>";
	private final $TABULKA_KON = "</table>";
	private final $RIADOK_ZAC = "<tr>";
	private final $RIADOK_KON = "</tr>";
	private final $BUNKA_ZAC = "<td>";
	private final $BUNKA_KON = "</td>";
	
	private function vytvorBunku($obsahBunky) {
		return $this->BUNKA_ZAC + $obsahBunky + $this->BUNKA_KON;
	}

	private function vytvorTabulku($obsah) {
		$vysledok = $this->TABULKA_ZAC;
		for ($i = 0; $i < $this->pocetRiadkov; $i++) {
			$riadok = "";
			for ($j = 0; $j < $this->pocetStlpcov; $j++) {
				$riadok += $this->vytvorBunku("*"); 
			}
			$vysledok += $this->vytvorRiadok($riadok);
		}
		$vysledok += $this->BUNKA_KON;
		return $vysledok;
	}
	
	private function vytvorRiadok($riadok) {
		return $this->RIADOK_ZAC + $riadok + $this->RIADOK_KON;
	}
	
	public function nastavParametre($pocetRiadkov, $pocetStlpcov) {
		$this->pocetRiadkov = $pocetRiadkov;
		$this->pocetStlpcov = $pocetStlpcov;
	}
	
	public function vykresli() {
		return $this->vytvorTabulku("");
	}

}
