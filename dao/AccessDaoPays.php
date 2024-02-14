<?php
class AccessDaoPays extends Dao {

	/**
	 * Trouver un pays
	 * @param object objet Pays
	 */
	public function findOne($object){

	}

	/**
	 * Trouver tous les pays
	 */
	public function findAll(){
		// requête sql de sélection envoyée à méthode de la classe mère
		$pays = $this->prepare_gen("select * from  " . $this->schema . "pays order by nom_pays");
		foreach($pays as $element){
			$objPays = new Pays($element['ID_PAYS'], $element['NOM_PAYS']);
			$arrPays[] = $objPays;
		}
		return $arrPays;
	}

	public function findAllWithFK($object){

	}

	/**
	 * Insérer un pays
	 * @param object objet Pays
	 */
	public function insertOne($object){
	}

	/**
	 * Supprimer un pays
	 * @param object objet Pays
	 */
	public function deleteOne($object){
	}

	public function updateOne($object, $object2 = null){
	}
}