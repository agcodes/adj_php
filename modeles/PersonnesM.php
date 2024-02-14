<?php
class PersonnesM  {
	private $unePersonne;
	private $idPersonne;
	private $modelePersonnes;

	function __construct($idPersonne) {
		$this->idPersonne = $idPersonne;
		$this->daoPersonnes = DaoFactory::getDAOPersonne();
	}

	// ajouter une personne dans table personnnes
	public function ajoutPersonne($params){
// 		$reqsql = "INSERT INTO personnes VALUES (null, :id_civilite, :nom, :prenom)";
// 		$this->control->prepare_modif($reqsql, $params);
// 		$max = $this->control->selectMax("PERSONNES", "ID_PERSONNE");
// 		echo $max . " max<br/>";
		return $max;
	}

	public function ajoutContactsMembre($params){
		$result = null;
// 		$reqsql = "";
// 		$result = $this->control->prepare_modif($reqsql, $params);
		return $result;
	}

	public function ajoutAdressesMembre($params){
		$result = null;
// 		$reqsql = "";
// 		$result = $this->control->prepare_modif($reqsql, $params);
		return $result;
	}

	public function rechPersonnesNom($nom){
		$unePersonne = new Personne(0);
		$unePersonne->setNom($nom);
		return $this->daoPersonnes->findAllWithFK($unePersonne);
	}

	public function modifiePersonne($prenom, $nom, $civilite){
		$personne = new Personne($this->idPersonne);
		$personne->setNom($nom);
		$personne->setPrenom($prenom);
		return $this->daoPersonnes->updateOne($personne);
	}

	public function rechCivilites(){
		$civilites = null;
// 		$reqsql = "SELECT * FROM civilites";
// 		$civilites = $this->control->prepare_param($reqsql, null);
		return $civilites;
	}
}