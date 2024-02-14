<?php
class Membre extends Personne {
	private $arrayGroupes;
	private $arrayAdresses;
	private $arrayInstruments;
	private $arraySpecialites;
	private $dateNaissance;

	function __construct($id) {
		parent::setId($id);
	}

	public function setDateNaissance($dateNaissance){
		$this->dateNaissance = $dateNaissance;
	}

	public function getDateNaissance(){
		return $this->dateNaissance;
	}

	public function setArrayGroupes($arrayGroupes){
		$this->arrayGroupes = $arrayGroupes;
	}

	public function getArrayGroupes(){
		return $this->arrayGroupes;
	}

	public function setArraySpecialites($arraySpecialites){
		$this->arraySpecialites = $arraySpecialites;
	}

	public function getArraySpecialites(){
		return $this->arraySpecialites;
	}

	public function setArrayInstruments($arrayInstruments){
		$this->arrayInstruments = $arrayInstruments;
	}

	public function getArrayInstruments(){
		return $this->arrayInstruments;
	}
}