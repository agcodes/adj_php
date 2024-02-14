<?php
class Groupe {
	private $idPersonne;
	private $arrRegions;
	private $personne;
	private $nomGroupe;
	private $dateDeb;

	function __construct($idGroupe, $nomGroupe, $dateDeb, $idPersonne) {
		$this->idGroupe = $idGroupe;
		$this->nomGroupe = $nomGroupe;
		$this->dateDeb = $dateDeb;
		$this->idPersonne = $idPersonne;




	}

	public function setIdGroupe($idGroupe) {
		$this->idGroupe = $idGroupe;
	}

	public function getIdGroupe() {
		return $this->idGroupe;
	}

	public function setIdPersonne($idPersonne) {
		$this->idPersonne = $idPersonne;
	}

	public function getIdPersonne() {
		return $this->idPersonne;
	}

	public function setPersonne($Personne){
		$this->Personne = $Personne;
	}

	public function getPersonne(){
		return $this->Personne;
	}

	public function setNomGroupe($nomGroupe){
		$this->nomGroupe = $nomGroupe;
	}

	public function getNomGroupe(){
		return $this->nomGroupe;
	}

	public function getArrPersonne(){
		return $this->arrPersonne;
	}

	public function setArrRegions($arrRegions){
		$this->arrRegions = $arrRegions;
	}

	public function getArrRegions(){
		return $this->arrRegions;
	}
}