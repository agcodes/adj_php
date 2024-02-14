<?php
class ControleurPersonnes extends Controleur {
	public function index(){
		$this->genererVue(null);
	}

	// crée la vue liste des membres par groupes XML pour AJAX
	public function liste(){
		$nom = ucfirst($this->requete->getParametre("nom"));
		if ($nom != ""){
			$prenom = $this->requete->getParametre("prenom");
			$modelePersonnes = new PersonnesM(0); // modèle personne
			$personnes = $modelePersonnes->rechPersonnesNom($nom); // recherche des personnes
			if (is_array($personnes) AND empty($personnes) == false){
				$this->genererPage(array('personnes' => $personnes), "vues/Personnes/XMLpersonnes.php");
			}
			else {
				echo "Aucune personne trouvée";
			}
		}
		else {
			echo "Paramètre nom absent";
		}
	}
}