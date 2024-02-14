<?php
class AccessDaoRegion extends Dao {

	/**
	 * Trouver une région
	 * @param object objet Region
	 */
	public function findOne($id){

	}

	/**
	 * Trouver tous les régions
	 */
	public function findAll(){
		// Instructions.
		$arrRegions = null;
		// requête sql envoyé à méthode de classe dao
		$regions = $this->prepare_gen("select r.id_region, r.nom_region, r.id_pays, count(rr.id_region) as nbgroupes
		from  " . $this->schema . "regions r inner join  " . $this->schema . "represente_regions rr "
		. " on rr.id_region = r.id_region group by r.id_region, r.nom_region, r.id_pays");
		foreach($regions as $element){
			$objRegion = new Region($element['ID_REGION'], $element['NOM_REGION'], $element['ID_PAYS']);
			$arrRegions[] = $objRegion;
		}
		return $arrRegions;
	}

	public function findAllWithFK($object){

	}

	/**
	 * Insérer une région
	 * @param object objet Region
	 */
	public function insertOne($object){
	}

	/**
	 * Supprimer une région
	 * @param object objet Region
	 */
	public function deleteOne($object){
	}

	public function updateOne($object, $object2){
	}
}