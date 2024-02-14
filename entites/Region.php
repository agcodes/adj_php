<?php
class Region {
	private $idRegion;
	private $nomRegion;
	private $idPays;

	function __construct($idRegion, $nomRegion, $idPays) {
		$this->idRegion = $idRegion;
		$this->nomRegion = $nomRegion;
		$this->idPays = $idPays;
	}

	function getIdRegion(){
		return $this->idRegion;
	}

	function getIdPays(){
		return $this->idPays;
	}

	function getNomRegion(){
		return $this->nomRegion;
	}
}