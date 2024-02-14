<?php
class AccessDaoSpecialite extends Dao {

	/**
	 * Trouver une spécialité
	 * @param object objet Specialite
	 */
	public function findOne($id){

	}

	/**
	 * Trouver tous les spécialités
	 */
	public function findAll(){
		// requête sql
		$Specialites = $this->prepare_gen("select * from  " . $this->schema . "specialites order by lib_specialite");
		foreach($Specialites as $element){
			$objSpecialite = new Specialite($element['ID_SPECIALITE'], $element['LIB_SPECIALITE']);
			$arrSpecialites[] = $objSpecialite;
		}
		return $arrSpecialites;
	}

	public function findAllWithFK($object){

	}

	/**
	 * Insérer une spécialité
	 * @param object objet Specialite
	 */
	public function insertOne($object){
	}

	/**
	 * Supprimer une spécialité
	 * @param object objet Specialite
	 */
	public function deleteOne($object){
	}

	public function updateOne($object, $object2){
	}
}
