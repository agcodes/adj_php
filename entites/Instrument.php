<?php
class Instrument {
	private $idInstrument;
	private $nomInstrument;
	private $idMembre;

	function __construct($idInstrument, $nomInstrument) {
		$this->idInstrument = $idInstrument;
		$this->nomInstrument = $nomInstrument;
	}

	function getIdInstrument(){
		return $this->idInstrument;
	}

	function getNomInstrument(){
		return $this->nomInstrument;
	}

	function setIdMembre($idMembre){
		$this->idMembre = $idMembre;
	}

	function getIdMembre(){
		return $this->idMembre;
	}
}