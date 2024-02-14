<?php
class ComposeGroupe {
	private $idGroupe;
	private $idMembre;
	private $dateDebut;
	private $dateFin;
	private $idFonction;
	private $membre; // objet
	private $groupe; // objet

	function __construct($groupe, $membre) {
		$this->groupe = $groupe;
		$this->membre = $membre;
		$this->dateDebut = null;
		$this->dateFin = null;
	}

	public function setIdMembre($idMembre){
		$this->idMembre = $idMembre;
	}

	public function getIdMembre(){
		return $this->idMembre;
	}

	public function setId($idGroupe){
		$this->idGroupe = $idGroupe;
	}

	public function setDateDebut($dateDebut){
		$this->dateDebut = $dateDebut;
	}

	public function getDateDebut(){
		return $this->dateDebut;
	}

	public function setDateFin($dateFin){
		$this->dateFin = $dateFin;
	}

	public function getDateFin(){
		return $this->dateFin;
	}

	public function getIdGroupe(){
		return $this->idGroupe;
	}

	public function getIdFonction(){
		return $this->idFonction;
	}
	public function setIdFonction($idFonction){
		 $this->idFonction = $idFonction;
	}

	public function setMembre($membre){
		$this->membre = $membre;
	}

	public function getMembre(){
		return $this->membre;
	}

	public function setGroupe($groupe){
		$this->groupe = $groupe;
	}

	public function getGroupe(){
		return $this->groupe;
	}
}