<?php
// modèle pays régions
class PaysRegionM {
	// recherche des pays
	public function rechPays(){
		$daoPays = DaoFactory::getDAOPays();
		return  $daoPays->findAll();
	}

	// recherche des régions
	public function rechRegions(){
		$daoRegions = DaoFactory::getDAORegion();
		return  $daoRegions->findAll();
	}
}