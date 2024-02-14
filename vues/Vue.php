<?php
class Vue {
	// Nom du fichier associé à la vue
	private $fichier;

	private $session;
	// Titre de la vue (défini dans le fichier vue)
	private $titre;

	public function __construct($action, $session = null, $controleur = "") {
		// Détermination du nom du fichier vue à partir de l'action et du constructeur
		// La convention de nommage des fichiers vues est : Vue/<$controleur>/<$action>.php
		$fichier = "vues/";
		if ($controleur != "") {
			$fichier = $fichier . $controleur . "/";
		}
		$this->fichier = $fichier . $action . ".php";
		$this->setSession($session);

	}

	public function setSession($session){
		if ($session instanceof Session){
			$this->session = $session;
		}
		else {
			$this->session = new Session();
		}
	}

	// Génère et affiche la vue
	public function generer($donnees) {
		if (is_array($donnees)){
			$donnees['session'] = $this->session;
		}
		// Génération de la partie spécifique de la vue
		$contenu = $this->genererFichier($this->fichier, $donnees);
		// Génération du gabarit commun utilisant la partie spécifique
		$vue = $this->genererFichier('vues/gabarit.php', array(
			'titre' => $this->titre,
			'session' => $this->session,
			'contenu' => $contenu)
		);
		// Renvoi de la vue au navigateur
		echo $vue;
	}

	public function genererPage($donnees, $page) {
		$vue = $this->genererFichier($page, $donnees);
		echo $vue;
		exit;
	}

	// Génère un fichier vue et renvoie le résultat produit
	private function genererFichier($fichier, $donnees) {
		if (file_exists($fichier)) {
			// Rend les éléments du tableau $donnees accessibles dans la vue
			if ($donnees != null){extract($donnees);}
			// Démarrage de la temporisation de sortie
			ob_start();
			require $fichier;
			// Arrêt de la temporisation et renvoi du tampon de sortie
			return ob_get_clean();
		}
		else {
			throw new Exception("Le fichier '$fichier' est introuvable");
		}
	}
}