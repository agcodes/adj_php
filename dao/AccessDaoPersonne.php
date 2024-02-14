<?php
class AccessDaoPersonne extends Dao {

	/**
	 * Trouver une personne
	 * @param object objet Personne
	 */
	public function findOne($object){
		$unePersonne = null ; // init
		if ($object > 0){
			// requête sql
			$reqsql = "SELECT p.id_personne, p.nom, p.prenom, p.id_civilite
			FROM " . $this->schema . "personnes p
			WHERE p.id_personne = :id_personne";
			$result = $this->prepare_param($reqsql, array('id_personne' => $object));
			// lecture résultat
			if (is_array($result)){
				if (is_array($result)){
					foreach($result as $element){
						$unePersonne = new Personne($element['ID_PERSONNE']); // nouvel objet membre
						$unePersonne->setNom($element['NOM']);
						$unePersonne->setPrenom($element['PRENOM']);
						$unePersonne->setIdCivilite($element['ID_CIVILITE']);
						break; // on ne recherche qu'une personne
					}
				}
			}
		}
		return $unePersonne; // retourne objet ou null
	}

	/**
	 * Trouver toutes les personnes
	 */
	public function findAll(){

	}

	public function findAllWithFK($object){
		if ($object instanceof Personne) {
			if ($object->getNom() != ""){
				// requête sql
				$reqsql = "SELECT id_personne, nom, prenom FROM  " . $this->schema . "personnes "
				. "WHERE nom like '%" . $object->getNom() . "%'";
				$arr = array();
				$results = $this->prepare_param($reqsql, null);
				foreach($results as $element){
					$unePersonne = new Personne($element['ID_PERSONNE']);
					$unePersonne->setNom($element['NOM']);
					$unePersonne->setPrenom($element['PRENOM']);
					$arr[] = $unePersonne;
				}
				return $arr;
			}
		}
	}

	/**
	 * Insérer une personne
	 * @param object objet Personne
	 */
	public function insertOne($object){
		// requête sql
		$reqsql = "INSERT INTO  " . $this->schema . "personnes VALUES (:id_personne, :id_civilite, :nom, :prenom)";
		$params = array(
			'id_personne' => $object->getId(),
			'id_civilite' => $object->getIdCivilite(),
			'nom' => $object->getNom(),
			'prenom' => $object->getPrenom()
		);
		$result = $this->prepare_modif($reqsql, $params);
		return $this->selectMax("personnes", "id_personne");
	}

	/**
	 * Supprimer une personne
	 * @param object objet Personne
	 */
	public function deleteOne($object){

	}

	public function updateOne($object, $object2){
		$result  = 0;
		if ($object2 instanceof Personne){
			if ($object2->getId() > 0){
				$params = array();
				// requête sql
				$reqsql = "UPDATE personnes set id_personne = :id_personne " ;
				$params["id_personne"] = $object2->getId();
				if ($object2->getIdCivilite() > 0){
					$reqsql .= ", id_civilite = :id_civilite ";
					$params["id_civilite"] = $object2->getIdCivilite();
				}

				if ($object2->getNom() != ""){
					$reqsql .= ", nom = :nom ";
					$params["nom"] = $object2->getNom();
				}

				if ($object2->getPrenom() != ""){
					$reqsql .= ", prenom = :prenom ";
					$params["prenom"] = $object2->getPrenom();
				}
				$reqsql .= " WHERE id_personne = :id_personne ";
				$result = $this->prepare_modif($reqsql, $params);
			}
		}
		return $result;
	}

	protected function rechContactsPersonne($id){
		// requête sql
		$reqsql = "SELECT c.id_contact, c.contact, tc.lib_type_contact
		FROM  " . $this->schema . "contacts c
		INNER JOIN  " . $this->schema . "types_contact tc on tc.id_type_contact = c.id_type_contact
		INNER JOIN  " . $this->schema . "a_pour_contact apc on c.id_contact = apc.id_contact
		INNER JOIN  " . $this->schema . "personnes p on p.id_personne = apc.id_personne
		WHERE p.id_personne = :id_personne
		ORDER BY tc.id_type_contact";
		$results = $this->prepare_param($reqsql, array('id_personne' => $id));
		return $results;
	}

	protected function rechAdresses($id){
		// requête sql
		$reqsql = "SELECT a.id_adresse, a.numero_voie, a.nom_voie, a.complement_adresse
		FROM  " . $this->schema . "adresses a
		INNER JOIN  " . $this->schema . "habite h on h.id_adresse = a.id_adresse
		INNER JOIN  " . $this->schema . "personnes p on p.id_personne = h.id_personne
		WHERE p.id_personne = :id_personne";
		$results = $this->prepare_param($reqsql, array('id_personne' => $id));
		return $results;
	}
}