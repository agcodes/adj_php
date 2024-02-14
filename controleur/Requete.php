<?php
/*
 * Classe modélisant une requete HTTP entrante
*
*/
class Requete {
	/** Tableau des paramètres de la requête */
	private $parametres;
	/**
	 * Constructeur
	 *
	 * @param array $parametres Paramètres de la requête
	 */
	public function __construct($parametres) {
		$this->parametres = $parametres;
		$this->nettoyage();
	}

	private function nettoyage(){
		if (is_array($this->parametres)){
			foreach ($this->parametres as $cle => $param){
				if (is_array($this->parametres[$cle]) == false){
					$this->parametres[$cle] = htmlspecialchars($this->parametres[$cle], ENT_QUOTES);

					$this->parametres[$cle] = trim ($this->parametres[$cle]); // enlève espaces
				}
			}
		}
	}

	/**
	 * Renvoie vrai si le paramètre existe dans la requete
	 *
	 * @param string $nom Nom du paramètre
	 * @return bool Vrai si le paramètre existe et sa valeur n'est pas vide
	 */
	public function existeParametre($nom) {
		return (isset($this->parametres[$nom]) && $this->parametres[$nom] != "");
	}

	/**
	 * Renvoie la valeur du paramètre demandé
	 *
	 * @param string $nom Nom d paramètre
	 * @return string Valeur du paramètre
	 */
	public function getParametre($nom) {
		if ($this->existeParametre($nom)) {
			return $this->parametres[$nom];
		}
		else {
			return "";
		}
	}

	public function nettoyageAlphaNum($string){
		// autorise chiffres, lettres, accents, espaces, tirets, apostrophes
		$string2 = preg_replace("/[^_0-9a-zA-ZÀ-ÖØ-öø-ÿœŒ&\s\-\']/i",'', $string);
		return $string2;
	}

	public function getParametreN($nom){
		$valeur2 = "";
		if ($this->existeParametre($nom)){
			if ($this->getParametre($nom) != ""){
				$valeur1 = "";
				$valeur1 .= $this->getParametre($nom);
				$valeur2 = $this->nettoyageAlphaNum($valeur1);
			}
		}
		return $valeur2;
	}

	function valideDate($value){
		$date_ = str_replace("-", "/", $value);
		if (preg_match( '`^\d{4}/\d{2}/\d{2}$`', $date_ )){ // format yyyy/mm/dd
			list($year, $month, $day) = split('[/.-]', $date_); // Valide une date grégorienne
			if (checkdate ($month,$day,$year)){
				if ($year > 1900){
					return $value;
				}
			}
		}
		elseif (preg_match( '`^\d{2}/\d{2}/\d{4}$`', $date_ )){ // format dd/mm/yyyy
			list($day, $month, $year) = split('[/.-]', $date_); // Valide une date grégorienne
			if (checkdate ($month, $day, $year)){
				if ($year > 1900){
					return $year . "-" . $month . "-" . $day; // formatage
				}
			}
		}
		return "";
	}



}