<?php
class AccessDaoGroupeM extends Dao {

	/**
	 * Trouver un groupe
	 * @param object objet Groupe
	 */
	public function findOne($object){

	}

	/**
	 * Trouver tous les groupes
	 */
	public function findAll(){

	}

	public function findAllWithFK($object){
		if ($object instanceof Region) {
			// requête sql
			$reqsql = "SELECT g.id_groupe, ng.nom_groupe as nomactuel, to_char(ng.date_deb, 'DD/MM/YYYY HH24:MI') as datedeb "
			. "FROM  " . $this->schema . "groupes g "
			. "LEFT JOIN  " . $this->schema . "personnes p on p.id_personne = g.id_personne "
			. "LEFT JOIN  " . $this->schema . "noms_groupe ng on g.id_groupe = ng.id_groupe_ "
			. "INNER JOIN  " . $this->schema . "represente_regions rr on rr.id_groupe = g.id_groupe "
			. "LEFT JOIN  " . $this->schema . "civilites c on p.id_civilite = c.id_civilite "
			. "WHERE rr.id_region = ? "
			. "ORDER BY g.id_groupe";

			// paramètres de la requête
			$param = array($object->getIdRegion());

			// exécution de la requête paramétrée avec retour des résultats
			$groupes = $this->prepare_param($reqsql, $param);

			// lecture des résultats groupes
			foreach($groupes as $element){
				$arrGroupes[] = new Groupe($element['ID_GROUPE'], $element['NOMACTUEL'], $element['DATEDEB'], 0);
			}
			return $arrGroupes;
		}
	}

	/**
	 * Insérer un groupe
	 * @param object objet Groupe
	 */
	public function insertOne($object){
	}

	/**
	 * Supprimer un groupe
	 * @param object objet Groupe
	 */
	public function deleteOne($object){
	}

	/**
	 * Modifier un groupe
	 * @param object objet Groupe
	 */
	public function updateOne($object, $object2){
	}
}