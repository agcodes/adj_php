<?php
class Cookie {
	public function Cookie() {
	}

	/**
	 * Création nouveau cookie ou update cookie existant
	 */
	function writeCook($nom, $valeur, $time, $secureJS) {
		setcookie ($nom, $valeur, $time, null, null, false, $secureJS);
	}

	/**
	 * Lire un cookie
	 */
	function readCook($nom) {
		if (isset ($_COOKIE[$nom])) {
			return $_COOKIE[$nom];
		} else {
			return null;
		}
	}

	/**
	 * Retourner la valeur déserialisée de cook sous forme de tab
	 */
	function readCookTab($nom) {
		if (isset ($_COOKIE[$nom])) {
			$tabCook = preg_split("/[\s,]+/", $_COOKIE[$nom]);
			return $tabCook ;
		} else {
			return null;
		}
	}

	/**
	 * Supprimer un cookie
	 */
	function deleteCook($nom) {
		setcookie ($nom, "", time () - 60, null, null, false, false);
	}
}