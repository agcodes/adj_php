<?php
/**
 * Classe abstraite Controleur
 */
abstract class Controleur {
	protected $action; // action
	private $nomVue; // vue
	protected $requete; // requete entrante
	protected $session;
	protected $filtreAcces;

	/**
	 * Requete entrante
	 * @param Requete $requete Requête entrante
	 */
	public function setRequete(Requete $requete){
		$this->requete = $requete;
	}

	public function setSession(Session $session){
		$this->session = $session;
		if ($this->filtreAcces == true){ // défini dans le constructeur du contrôleur
			if ($this->session->getSession("acces") <= 0) {
				$this->filtrerAcces(0);
			}

		}
	}

	/**
	 * Redirection vers page erreur si accès réservé ()
	 */
	public function filtrerAcces($access){
		throw new Exception("Accès réservé aux personnes connectées");
	}

	/**
	 * Exécute action de la classe contrôleur
	 * @param $action
	 */
	public function executerAction($action){
		if (method_exists($this, $action)) {
			$this->action = $action;
			$this->{$this->action}(); // exécute méthode
		}
		else {
			$classeControleur = get_class($this);
			throw new Exception("Action '$action' inconnue");
		}
	}

	/**
	 * Génération de la vue
	 * @param $donneesVue
	 */
	protected function genererVue($donneesVue = array(), $action = ""){
		if ($action != ""){
			$this->action = $action; // changement de l'action pour définir un autre fichier vue
		}
		// Nom du fichier vue a partir du nom du controleur actuel
		$classeControleur = get_class($this);
		$controleur = str_replace("Controleur", "", $classeControleur);
		// Instanciation et generation de la vue
		$vue = new Vue($this->action, $this->session, $controleur);
		$vue->generer($donneesVue);
	}

	/**
	 * Méthode alternative de génération de vue
	 * @param $donneesVue
	 * @param $page
	 */
	protected function genererPage($donneesVue = array(), $page){
		// Détermination du nom du fichier vue à partir du nom du contrôleur actuel
		$classeControleur = get_class($this);
		$controleur = str_replace("Controleur", "", $classeControleur);
		// Instanciation et génération de la vue
		$vue = new Vue($this->action, $this->session, $controleur);
		$vue->genererPage($donneesVue, $page);
	}
}