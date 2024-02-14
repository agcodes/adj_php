<?php
interface DaoI {
	function Dao();

	/**
	 * Trouver un tuple dans une table sous forme d'objet
	 * @param object tuple à trouver
	 */
	public function findOne($object);

	/**
	 * Trouver tous les tuples d'une table sous forme d'objet
	 */
	public function findAll();

	/**
	 * Insérer un tuples dans une table
	 * @param object objet à insérer
	 */
	public function insertOne($object);

	/**
	 * Supprimer un objet dans une table
	 * @param object objet à supprimer
	 */
	public function deleteOne($object);

	/**
	 * Modifier un objet dans une table
	 * @param object objet à modifier
	 * @param object2 nouvel objet
	 */
	public function updateOne($object, $object2);

	/**
	 * Trouver tous les tuples d'une table sous forme d'objet contenant une valeur de clé étrangère donnée
	 */
	public function findAllWithFK($object);

	/**
	 * execute une requête
	 * @return results (tableau de résultats)
	 */
	public function prepare_gen($reqSQL);

	/**
	 * execute une requête select
	 * @params paramètres sous forme d'array
	 * @return results (tableau de résultats)
	 */
	public function prepare_param($reqSQL, $params);

	/**
	 * execute une requête update/delete/insert
	 * @return result (0 = échec - 1 = succès)
	 */
	public function prepare_modif($reqSQL, $params);

	/**
	 * selection du maximum d'une table
	 * @param table table
	 * @param attribut attribut dont le maximum est recherché
	 */
	public function selectMax($table, $attribut);

	/**
	 * commencer une transaction
	 */
	public function beginTransaction_();

	/**
	 * terminer une transaction
	 */
	public function endTransaction_();


}