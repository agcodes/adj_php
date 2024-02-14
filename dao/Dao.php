<?php
abstract class Dao extends ConnectDao implements DaoI {
	function Dao(){
		$this->bdd = $this->getBdd();
	}

	/**
	 * Trouver un tuple dans une table sous forme d'objet
	 * @param object tuple à trouver
	 */
	abstract public function findOne($object);

	/**
	 * Trouver tous les tuples d'une table sous forme d'objet
	 */
	abstract public function findAll();


	/**
	 * Trouver tous les tuples d'une table sous forme d'objet contenant une valeur de clé étrangère donnée
	 */
	abstract public function findAllWithFK($object);

	/**
	 * Insérer un tuples dans une table
	 * @param object objet à insérer
	 */
	abstract public function insertOne($object);

	/**
	 * Supprimer un objet dans une table
	 * @param object objet à supprimer
	 */
	abstract public function deleteOne($object);

	/**
	 * Modifier un objet dans une table
	 * @param object objet à modifier
	 * @param object2 nouvel objet
	 */
	abstract public function updateOne($object, $object2);

	/**
	 * Modifier un objet dans une table
	 * @param object objet à modifier
	 * @param object2 nouvel objet
	 */
	public function testDate($date){
		if ($date != null AND $date != ""){
			return $date;
		}
		else {
			return null;
		}
	}

	/**
	 *
	 * @return reqDate instruction sql
	 */
	public function reqDate($date, $param){
		if ($date != null AND $date != ""){
			$reqDate= "to_date(:" . $param . ", 'yyyy-mm-dd')";
		}
		else {
			$reqDate = ":" . $param;
		}
		return $reqDate;
	}

	/**
	 * execute une requête
	 * @return results (tableau de résultats)
	 */
	public function prepare_gen($reqSQL) {
		$champs = array() ;
		$req = $this->bdd->prepare($reqSQL) ;
		if ($req->execute() == false){
			$this->throwException($reqSQL);
		}
		$result = $req->fetchAll();
		$req->closeCursor();
		return $result;
	}

	/**
	 * execute une requête select
	 * @params paramètres sous forme d'array
	 * @return results (tableau de résultats)
	 */
	public function prepare_param($reqSQL, $params) {
		$champs = array() ;
		$req = $this->bdd->prepare($reqSQL) ;
		if ($req->execute($params) == false){
			$this->throwException($reqSQL);
		}
		$result = $req->fetchAll();
		$req->closeCursor();
		return $result;
	}

	/**
	 * execute une requête update/delete/insert
	 * @return result (0 = échec - 1 = succès)
	 */
	public function prepare_modif($reqSQL, $params){
		$req = $this->bdd->prepare($reqSQL);
		$result = $req->execute($params);
		$req->closeCursor();
		if ($result == 0){
			$this->throwException($reqSQL);
		}
		return $result;
	}

	/**
	 * selection du maximum d'une table
	 * @param table table
	 * @param attribut attribut dont le maximum est recherché
	 */
	public function selectMax($table, $attribut){
		$max = 0;
		$result = array() ;
		$req = $this->getBdd()->prepare('select max(' . $attribut . ') as maxi from ' . $table);
		if ($req->execute()){
			for ($i = 0; $data = $req ->fetch(); $i++) {
				if (isset($data['MAXI'])){
					$max = $data['MAXI'];
					break;
				}
			}
			$req->closeCursor();
		}
		else  {
			$this->throwException("");
		}
		return $max;
	}

	/**
	 * commencer une transaction
	 */
	public function beginTransaction_(){
		$this->bdd->beginTransaction();
	}

	/**
	 * terminer une transaction
	 */
	public function endTransaction_(){
		$this->bdd->commit();
	}

	/**
	 * exception
	 */
	private function throwException($reqSQL){
		throw new Exception("Erreur lors de l'exécution de la requête " . $reqSQL . " </br>" . serialize($this->bdd->errorInfo()));
	}
}