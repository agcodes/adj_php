<?php
// modèle groupe
class GroupesM {

	private $daoGroupe;

	function GroupesM() {
		$this->daoGroupe = DaoFactory::getDAOGroupeM();
	}

	// recherche des groupes représentant une région
	public function rechGroupesRegion($idRegion){
		return $this->daoGroupe->findAllWithFK(new Region($idRegion, 0, 0));
	}
}