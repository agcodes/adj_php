<?php
class MembresM extends PersonnesM {
	private $unMembre;
	private $idMembre;
	private $dao;
	private $daoMembres;

	function __construct($idMembre = 0) {
		parent::__construct($idMembre);
		$this->idMembre = $idMembre;
		// objet membre
		$this->unMembre = new Membre($idMembre);
		// objet dao membre
		$this->daoMembres = DaoFactory::getDAOMembre();
	}

	// recherche des données membre
	public function rechMembre (){
		$this->unMembre = $this->daoMembres->findOne($this->unMembre);
	}

	public function supprMembre($idMembre){
		return $this->daoMembres->deleteOne($this->unMembre);
	}

	public function ajoutMembre($prenom, $nom, $civilite, $dateNaissance, $arraySpecialites, $arrayInstruments){
		$this->createObjMembre($prenom, $nom, $civilite, $dateNaissance, $arraySpecialites, $arrayInstruments);
		return $this->daoMembres->insertOne($this->unMembre);
	}

	public function modifieMembre($unMembre, $prenom, $nom, $civilite, $dateNaissance, $arraySpecialites, $arrayInstruments){
		$this->createObjMembre($prenom, $nom, $civilite, $dateNaissance, $arraySpecialites, $arrayInstruments);
		if ($this->daoMembres->updateOne($unMembre, $this->unMembre) == 1){
			return $this->unMembre;
		}
		else {
			return null;
		}
	}

	public function createObjMembre($prenom, $nom, $civilite, $dateNaissance, $arraySpecialites, $arrayInstruments){
		$this->unMembre->setNom($nom);
		$this->unMembre->setPrenom($prenom);
		$this->unMembre->setIdCivilite($civilite);
		$this->unMembre->setDateNaissance($dateNaissance);
		// serialization specialites
		if (is_array($arraySpecialites) AND count($arraySpecialites) > 0){
			$arrayObjSpecialites = array();
			foreach($arraySpecialites as $IdDpe){
				if ($IdDpe > 0){
					$arrayObjSpecialites[] = new Specialite($IdDpe, "");
				}
			}
			$this->unMembre->setArraySpecialites($arrayObjSpecialites);
		}

		// serialization instruments
		if (is_array($arrayInstruments) AND count($arrayInstruments) > 0){
			$arrayObjInstruments = array();
			foreach($arrayInstruments as $IdI){
				if ($IdI > 0){
					$arrayObjInstruments[] = new Instrument($IdI, "");
				}
			}
			$this->unMembre->setArrayInstruments($arrayObjInstruments);
		}
	}

	// COMPOSE GROUPE

	// recherche des membres d'un groupe
	public function rechMembresGroupe($idGroupe){
		$dao = new AccessDaoComposeGroupe();
		return $dao->findAllWithFK(new Groupe($idGroupe, 0, 0, 0));
	}

	// modifie compose groupe
	public function modifieComposeGroupe($idGroupe, $idMembre, $dateDebut, $dateFin){
		if ($idGroupe > 0 AND $idMembre > 0){
			$daoComposeGroupe = DaoFactory::getDAOComposeGroupe();
			$composeGroupe = new ComposeGroupe(new Groupe($idGroupe,"", "",""), new Membre($idMembre));
			$composeGroupe->setDateDebut($dateDebut);
			$composeGroupe->setDateFin($dateFin);
			return $daoComposeGroupe->updateOne($composeGroupe, null);
		}
	}

	public function ajoutComposeGroupe($idGroupe, $idMembre, $dateDebut = null){
		if ($idGroupe > 0 AND $idMembre > 0){
			$daoComposeGroupe = DaoFactory::getDAOComposeGroupe();
			$composeGroupe = new ComposeGroupe(new Groupe($idGroupe,"", "",""), new Membre($idMembre));
			$composeGroupe->setDateDebut($dateDebut);
			return $daoComposeGroupe->insertOne($composeGroupe);
		}
	}

	// getter
	public function getMembre(){
		return $this->unMembre;
	}

	// recherche tous les instruments possibles
	public function rechToutInstrument(){
		$daoInstrument = new AccessDaoInstrument();
		$instruments = $daoInstrument->findAll();
		$this->unMembre->setArrayInstruments($instruments);
	}

	// recherche toutes les spécialités possibles
	public function rechTouteSpecialite(){
		$daoSpecialite = new AccessDaoSpecialite();
		$specialites = $daoSpecialite->findAll();
		$this->unMembre->setArraySpecialites($specialites);
	}
}