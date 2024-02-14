<?php
class ControleurMembres extends Controleur {
	public function __construct() {
		$this->filtreAcces = true;
	}

	// gestion des membres
	public function index(){
		$vue = true;
		// requête suppression d'un membre du groupe via AJAX (renvoie résultat)
		if ($this->requete->existeParametre('select-membre')){ // membre sélectionnée
			$idMembre = $this->requete->getParametre("select-membre"); // id membre
			$idGroupe = $this->requete->getParametre("select-groupe"); // id groupe
			$vue = false;
			if ($idMembre > 0 AND $idGroupe > 0){
				$dateDebut = $this->requete->valideDate($this->requete->getParametre("datedebut")); // test validité
				$dateFin = $this->requete->valideDate($this->requete->getParametre("datefin")); // test validité
				if ($dateDebut != "" OR $dateFin != ""){
					$modeleMembre = new MembresM(); // modèle membre
					echo $modeleMembre->modifieComposeGroupe($idGroupe, $idMembre, $dateDebut, $dateFin); // méthode modèle suppression
				}
				else {
					echo "3";
				}
			}
			else {
				echo "0";
			}
		}
		// requête ajout d'un membre dans le groupe via AJAX (renvoie résultat)
		elseif ($this->requete->existeParametre('select-personne')){ // personne sélectionnée
			$idMembre = $this->requete->getParametre("select-personne"); // id personne
			$idGroupe = $this->requete->getParametre("select-groupe"); // id groupe
			$vue = false;
			if ($idMembre > 0 AND $idGroupe > 0){
				$modeleMembre = new MembresM(); // modèle membre
				$dateDebut = $this->requete->getParametre("date-debut"); // id groupe
				echo $modeleMembre->ajoutComposeGroupe($idGroupe, $idMembre, $dateDebut);
			}
			else {
				echo "0";
			}
		}
		elseif ($vue == true){
			$modele = new PaysRegionM();
			$pays = $modele->rechPays();
			$regions = $modele->rechRegions();
			if (is_array($regions) AND empty($regions) == false){
				$this->genererVue(array('pays' => $pays, 'regions' => $regions));
			}
			else {
				throw new Exception("Erreur lors de la recherche des régions");
			}
		}
	}


	// crée la vue liste des membres par groupes XML
	public function membres_groupe(){
		$idGroupe = $this->requete->getParametre("groupe");
		if ($idGroupe > 0){
			$modeleMembres = new MembresM(0);
			$cg = $modeleMembres->rechMembresGroupe($idGroupe); // recherche des membres du groupe
			if (is_array($cg)){
				$this->genererPage(array('cg' => $cg), "vues/Membres/XMLmembres_groupe.php");
			}
		}
	}

	// A VOIR******************************************************************************
	// gestion d'un membre
	public function membre(){
		$unMembre = null;
		$idMembre = $this->requete->getParametre("id"); // GET id

		$info = "";

		// FICHE MEMBRE
		$modele = new MembresM($idMembre);
		if ($idMembre > 0) { // visualisation d'un membre
			// construction du membre
			$modele->rechMembre();
			$unMembre = $modele->getMembre();
		}

		if ($this->session->getSession("acces") == 1) {
			// GESTION MEMBRE
			if ($this->requete->existeParametre('id-membre')){ // POST id-membre envoyé => post à traiter
				$idMembre = $this->requete->getParametre("id-membre");
				$modeleMembre = new MembresM($idMembre);
				if ($idMembre != 0){ // modification du membre
					$unMembre = $modeleMembre->modifieMembre($unMembre, $this->requete->getParametre("prenom-membre"),
					$this->requete->getParametre("nom-membre"),
					$this->requete->getParametre("civilite"),
					$this->requete->valideDate($this->requete->getParametre("date-naissance")),
					$this->requete->getParametre("specialites"),
					$this->requete->getParametre("instruments"));

					if ($unMembre == null){
						$info = "Membre non modifié";
					}
					else {
						echo $unMembre->getNom() . "<br/>";
						$info = "Membre modifié";

						$modele->rechMembre();
						$unMembre = $modele->getMembre();
					}
				}
			}
		}
		else  {
			echo $this->session->getSession("acces") . "<br/>";
		}
		if ($unMembre == null){
			$this->genererVue(array('info' => "aucun membre à afficher"));
		}
		else {
			$this->genererVue(array('info' => $info, 'unMembre' => $unMembre));
		}
	}

	public function specialites(){
		if ($this->requete->existeParametre('spes')){ // POST spécialité envoyé => post à traiter
			$specialites = explode("/", $this->requete->getParametre("spes"));
			print_r($specialites);

		}
		echo "test à moi";
	}
}