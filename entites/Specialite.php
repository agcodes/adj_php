<?php
class Specialite {
	private $idSpecialite;
	private $nomSpecialite;
	private $idMembre;

	function __construct($idSpecialite, $nomSpecialite) {
		$this->idSpecialite = $idSpecialite;
		$this->nomSpecialite = $nomSpecialite;
	}

	function getIdSpecialite(){
		return $this->idSpecialite;
	}

	function getNomSpecialite(){
		return $this->nomSpecialite;
	}

	function setNomSpecialite($nomSpecialite){
		$this->nomSpecialite = $nomSpecialite;
	}

	function setIdMembre($idMembre){
		$this->idMembre = $idMembre;
	}

	public function __toString(){
		return $this->idSpecialite;
	}



	function getIdMembre(){
		return $this->idMembre;
	}
}