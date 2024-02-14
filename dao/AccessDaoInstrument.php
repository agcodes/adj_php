<?php
class AccessDaoInstrument extends Dao {

	/**
	 * Trouver un instrument
	 * @param object objet Instrument
	 */
	public function findOne($object){

	}

	/**
	 * Trouver tous les instruments
	 */
	public function findAll(){
		// requête sql
		$instruments = $this->prepare_gen("select * from  " . $this->schema . "instruments order by nom_instrument");

		// lecture des résultats
		foreach($instruments as $element){
			$objInstrument = new Instrument($element['ID_INSTRUMENT'], $element['NOM_INSTRUMENT']);
			$arrInstruments[] = $objInstrument;
		}
		return $arrInstruments;
	}

	public function findAllWithFK($object){

	}

	/**
	 * Insérer un instrument
	 * @param object objet Instrument
	 */
	public function insertOne($object){
	}

	/**
	 * Supprimer un instrument
	 * @param object objet Instrument
	 */
	public function deleteOne($object){
	}

	/**
	 * Modifier un instrument
	 * @param object objet Instrument
	 */
	public function updateOne($object, $object2){
	}
}