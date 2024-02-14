<?php
class ControleurGroupes extends Controleur {
	public function __construct() {
		$this->modele = new GroupesM();
	}

	// crée la vue liste des groupes par régions XML
	public function groupesregions(){
		$idRegion = $this->requete->getParametre("region");
		if ($idRegion > 0){
			$groupes = $this->modele->rechGroupesRegion($idRegion); // recherche des groupes
			$this->genererPage(array('groupes' => $groupes), "vues/Groupes/XMLgroupes.php");
		}
	}
}