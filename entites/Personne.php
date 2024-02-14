<?php
class Personne {
	private $id;
	private $nom;
	private $prenom;
	private $idCivilite;
	private $arrayContacts;
	private $arrayAdresses;

	function __construct($id) {
		$this->id = $id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function setNom($nom){
		$this->nom = $nom;
	}

	public function setPrenom($prenom){
		$this->prenom = $prenom;
	}

	public function getId(){
		return $this->id;
	}

	public function getIdCivilite(){
		return $this->idCivilite;
	}

	public function setIdCivilite($idCivilite){
		$this->idCivilite = $idCivilite;
	}

	public function getNom(){
		return $this->nom;
	}

	public function getPrenom(){
		return $this->prenom;
	}

	public function setArrayContacts($arrayContacts){
		$this->arrayContacts = $arrayContacts;
	}

	public function getArrayContacts(){
		return $this->arrayContacts;
	}

	public function setArrayAdresses($arrayAdresses){
		$this->arrayAdresses = $arrayAdresses;
	}

	public function getArrayAdresses(){
		return $this->arrayAdresses;
	}
}