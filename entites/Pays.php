<?php
class Pays {
	private $idPays;
	private $nomPays;

	function __construct($idPays, $nomPays) {
		$this->idPays = $idPays;
		$this->nomPays = $nomPays;
	}

	function getIdPays(){
		return $this->idPays;
	}

	function getNomPays(){
		return $this->nomPays;
	}
}