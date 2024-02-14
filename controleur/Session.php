<?php
include_once 'Cookie.php';
global $managerCook;

// Les fonctions PHP création de session doivent êtres appelés avant page HTML
class Session {
	private $test;
	// Constructeur
	function Session() {

	}

	/**
	 * Créer variable de session
	 */
	function create($nom, $valeur) {
		$this->nom = $nom;
		$_SESSION[$nom] = $valeur ; //. " " . session_id();
		$this->id = session_id();
	}

	/**
	 * Lire variable de session
	 */
	function getSession($nom) {
		if (isset($_SESSION[$nom])){
			return $_SESSION[$nom];
		}
		else {
			return "";
		}
	}

	// Delete
	function delSession($nom) {
		$this->nom = null;
		unset ($_SESSION[$nom]);
		session_destroy ();
		// Détruit aussi cookie session
		$cm = new Cookie();
		$cm->deleteCook($nom);
	}

	/**
	 * Serialisation variable session
	 */
	function serialise($nom) {
		if (isset($_SESSION[$nom])) {
			$tabCook = preg_split ( "/[\s,]+/", $_SESSION[$nom] );
			return $tabCook;
		}
		else {
			return null;
		}
	}

}