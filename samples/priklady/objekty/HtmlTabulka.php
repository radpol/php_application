<?php
class HtmlTabulka {
	
	private $pocetRiadkov;
	private $pocetStlpcov;
	private $hrubkaRamu;
	
	private  $TAG_TABULKA = "table";
	private  $TAG_RIADOK = "tr";
	private  $TAG_BUNKA = "td";
	private  $ATTRIBUT_OKRAJ = "border";
	
	private function vytvorTag($menoTagu, $atributTagu, $jeKoncovy){
		$result = '<';
		if ($jeKoncovy) {
			$result .= '/';
		}
		$result .= $menoTagu . $atributTagu . '>';
		return  $result;
		
	}
	
	
	
	private function vytvorBunku($obsahBunky) {
		return $this->vytvorTag($this->TAG_BUNKA, '', false) . $obsahBunky . $this->vytvorTag($this->TAG_BUNKA, '', false);
	}

	private function vytvorTabulku($obsah) {
		$vysledok = $this->vytvorTag($this->TAG_TABULKA," " . $this->ATTRIBUT_OKRAJ."=".$this->hrubkaRamu, false);
		for ($i = 0; $i < $this->pocetRiadkov; $i++) {
			$riadok = "";
			for ($j = 0; $j < $this->pocetStlpcov; $j++) {
				$riadok .= $this->vytvorBunku("*"); 
			}
			$vysledok .= $this->vytvorRiadok($riadok);
		}
		$vysledok .= $this->vytvorTag($this->TAG_TABULKA, "", true);
		return $vysledok;
	}
	
	private function vytvorRiadok($riadok) {
		return $this->vytvorTag($this->TAG_RIADOK, "", false) . $riadok . $this->vytvorTag($this->TAG_RIADOK, "", true);
	}
	
	public function nastavParametre($pocetRiadkov, $pocetStlpcov, $hrubkaRamu) {
		$this->pocetRiadkov = $pocetRiadkov;
		$this->pocetStlpcov = $pocetStlpcov;
		$this->hrubkaRamu = $hrubkaRamu;
	}
	
	public function vykresli() {
		return $this->vytvorTabulku("");
	}

}
