<?php
class ControleurAccueil extends Controleur {
	public function __construct() {

	}

	public function index(){
		// page accueil
		$this->genererVue(null);
	}

	public function plan(){
		// page plan
		$this->genererVue(null);
	}

	public function connexion(){
		$info = "";

		if ($this->requete->existeParametre("pseudo") AND $this->requete->existeParametre("mdp")){
			$pseudop = $this->requete->getParametreN("pseudo"); // retour pseudo nettoyé
			$mdpt = $this->requete->getParametreN("mdp"); // retour pseudo mdp

			if ($pseudop != "" AND $mdpt != ""){
				if (strlen($pseudop) <= 20 AND strlen($mdpt) <= 20){
					$modeleUtilisateur = new UtilisateurM();
					$access = 0;
					$access += $modeleUtilisateur->connexionUtilisateur($pseudop, $mdpt);
					if ($access == 0){
						$info = "Identifiants incorrects.";
						$this->session->delSession("login");
					}
					else {
						//$this->session->delSession("login");
						$this->session->create("login", $pseudop);
						$this->session->create("acces", $access);
						$info = "Bienvenue " . $this->session->getSession("login") . " - " . $this->session->getSession("acces");
					}
				}
				else {
					$info = "Respecter la taille maximale des champs (20 caractères).";
				}
			}
			else {
				$info = "Veuillez saisir un nom et un mot de passe.";
			}
		}
		else {
			$info = "Veuillez saisir un nom d'utilisateur et un mot de passe.";
		}


		$this->genererVue(array('info' => $info));
	}

	public function deconnexion() {
		$this->session->delSession("login");
		$info = "Connectez-vous.";
		$this->genererVue(array('info' => $info), "connexion");
	}

}
