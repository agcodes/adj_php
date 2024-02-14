<?php
require_once 'Controleur.php';
require_once 'Requete.php';
require_once 'Cookie.php';
require_once 'Session.php';

/*
 * Classe de routage des requetes entrantes.
 *
 * Inspirée du framework PHP de Nathan Davison
 * (https://github.com/ndavison/Nathan-MVC)
 *
 * @version 1.0
 * @author Baptiste Pesquet
 */
class Routeur {
	/**
	* Méthode principale appelée par le contrôleur frontal
	* Examine la requête et exécute l'action appropriée
	*/
	public function routerRequete() {
		try {
			 // Fusion des paramètres GET et POST de la requête
			$requete = new Requete(array_merge($_GET, $_POST));
			// objet session vide
			$session = new Session();
			// les URL entrantes sont du type index.php?controleur=XXX&action=YYY
			// création de l'objet contrôleur
			$controleur = $this->getControleur($requete, $session);
			// éxécute la méthode de la classe contrôleur
			$controleur->executerAction($this->getAction($requete)); //
		}
			catch (Exception $e) {
			$this->gererErreur($e);
		}
	}

	/**
	* Instancie le controleur approprié en fonction de la requete reçue
	* @param Requete $requete Requete reçue
	* @return Instance d'un controleur
	* @throws Exception Si la création du controleur échoue
	*/
	private function getControleur(Requete $requete, Session $session) {
		$controleur = "ControleurAccueil";  // Contrôleur par défaut
		if ($requete->existeParametre('controleur')) {
			$controleur = $requete->getParametre('controleur');
			$controleur = "Controleur" . ucfirst(strtolower($controleur)); // Première lettre en majuscules
		}
		// Création du nom du fichier du contrôleur
		$classeControleur = $controleur;
		$fichierControleur = "controleur/page/" . $classeControleur . ".php";
		if (file_exists($fichierControleur)) {
			// Instanciation du contrôleur adapté à la requête
			require($fichierControleur);
			$controleur = new $classeControleur(); // nouvel objet contrôleur
			$controleur->setRequete($requete); // requête
			$controleur->setSession($session); // requête
			return $controleur;
		}
		else {
			throw new Exception("Le fichier " . $fichierControleur . " est introuvable ");
		}
	}

    /**
     * Détermine l'action à exécuter en fonction de la requete reçue
     *
     * @param Requete $requete
     * @return string Action à exécuter
     */
	private function getAction(Requete $requete) {
		$action = "index";  // Action par défaut
		if ($requete->existeParametre('action')) {
			$action = $requete->getParametre('action');
		}
		return $action;
	}

    /**
     * Gère une erreur d'exécution (exception)
     *
     * @param Exception $exception Exception qui s'est produite
     */
	private function gererErreur(Exception $exception) {
		$vue = new Vue('erreur');
		$vue->generer(array('msgErreur' => $exception->getMessage()));
	}
}