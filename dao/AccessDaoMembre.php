<?php
class AccessDaoMembre extends AccessDaoPersonne {
	private $unMembre;

	/**
	 * Trouver un membre
	 * @param object objet Membre
	 * @param param 1 si objet métier
	 */
	public function findOne($object, $param = 1){
		$this->unMembre = null; // init
		if ($object instanceof Membre AND $object->getId() > 0){
			$idMembre = $object->getId();
			// requête sql recherche du membre
			$reqsql = "SELECT p.id_personne, p.nom, p.prenom, p.id_civilite, to_char(m.date_naissance, 'YYYY-MM-DD') as date_naissance
			FROM  " . $this->schema . "personnes p
			INNER JOIN  " . $this->schema . "membres m on m.id_personne = p.id_personne
			WHERE p.id_personne = :id_membre";

			// exécution de la requête paramétrée avec retour du résultat
			$result = $this->prepare_param($reqsql, array('id_membre' => $idMembre));

			if (is_array($result)){
				// lecture résultat
				foreach($result as $element){
					$this->unMembre = new Membre($element['ID_PERSONNE']); // nouvel objet membre
					$this->unMembre->setNom($element['NOM']);
					$this->unMembre->setPrenom($element['PRENOM']);
					$this->unMembre->setDateNaissance($element['DATE_NAISSANCE']);
					$this->unMembre->setIdCivilite($element['ID_CIVILITE']);
					break; // on ne recherche qu'un membre
				}
				// composition objet membre
				if ($param == 1 AND $this->unMembre != null){
					// recherche des groupes
					$daoComposeGroupe = new AccessDaoComposeGroupe();
					$this->unMembre->setArrayGroupes($daoComposeGroupe->findAllWithFK($this->unMembre));
					$this->findSpecialites($idMembre); // recherche des spécialités
					$this->findInstruments($idMembre); // recherche des instruments
				}
			}
		}
		else {
			echo "membre null";
		}
		return $this->unMembre; // retourne objet ou null
	}

	/**
	 * Trouver tous les membres
	 */
	public function findAll(){

	}

	public function findAllWithFK($object){
		if ($object instanceof Groupe) { // recherche des membres dans le groupe
			// requête sql
			$reqsql = "SELECT cg.id_groupe, p.id_personne, p.nom, p.prenom, to_char(cg.date_debut, 'YYYY-MM-DD') as date_naissance, to_char(m.date_naissance, 'YYYY-MM-DD') as date_naissance "
			. "FROM  " . $this->schema . "personnes p "
			. "INNER JOIN  " . $this->schema . "membres m on m.id_personne = p.id_personne "
			. "INNER JOIN  " . $this->schema . "compose_groupes cg on cg.id_personne = m.id_personne "
			. "WHERE cg.id_groupe = :idgroupe AND "
			. "cg.date_fin is null "
			. "ORDER BY p.nom, p.prenom, date_naissance";
			$param = array($object->getIdGroupe());
			// exécution de la requête paramétrée avec retour du résultat
			$membres = $this->prepare_param($reqsql, $param);
			// lecture des résultats
			if (is_array($membres)){
				$arrMembres = array();
				foreach($membres as $element){
					$membre = new Membre($element['ID_PERSONNE']);
					$membre->setNom($element['NOM']);
					$membre->setPrenom($element['PRENOM']);
					$membre->setDateNaissance($element['DATE_NAISSANCE']);
					$arrMembres[] = $membre; // ajout du membre
				}
				return $arrMembres;
			}
			else {
				return null;
			}
		}
	}

	/**
	 * Supprimer un membre
	 * @param object objet Groupe
	 */
	public function deleteOne($object){
		$result = 0;
		if ($object instanceof Membre AND $object->getId > 0 ){
			$reqsql = "DELETE  " . $this->schema . "compose_groupes where id_personne = :idmembre";
			$result = $this->control->prepare_modif($reqsql, array('idmembre' => $object->getId));

			$reqsql = "DELETE  " . $this->schema . "joue_instrument where id_personne = :idmembre";
			$result = $this->control->prepare_modif($reqsql, array('idmembre' => $object->getId));

			$reqsql = "DELETE  " . $this->schema . "a_pour_specialite where id_personne = :idmembre";
			$result = $this->control->prepare_modif($reqsql, array('idmembre' => $object->getId));

			$reqsql = "DELETE  " . $this->schema . "membres where id_personne = :idmembre";
			$result = $this->prepare_modif($reqsql, array('idmembre' => $object->getId));
		}
		return $result;
	}

	/**
	 * Insérer un membre
	 * @param object objet Groupe
	 */
	public function insertOne($object){
		$result = 0;
		if ($object instanceof Membre){
			$idMembre = $object->getId();
			if (parent::findOne($idMembre) == null){
				$idMembre = parent::insertOne($object);
			}
			else {
				echo "personne trouvée";
			}
			if ($idMembre > 0){
				if ($object->getDateNaissance() != null AND $object->getDateNaissance() != ""){
					$dateNaissance = $object->getDateNaissance();
					$reqDateNaissance = "to_date(:date_naissance, 'yyyy-mm-dd')";
				}
				else {
					$reqDateNaissance = ":date_naissance";
					$dateNaissance = null;
				}

				// requête sql
				$reqsql = "INSERT INTO  " . $this->schema . "membres VALUES  (:id_personne, " . $reqDateNaissance . ")";
				$result = $this->prepare_modif($reqsql, array('id_personne' => $idMembre, 'date_naissance' => $dateNaissance));

				$object->setId($idMembre);
				// ajout des spécialités
				$arraySpecialites = $object->getArraySpecialites();
				if (is_array($arraySpecialites) AND count($arraySpecialites) > 0){
					foreach($arraySpecialites as $spe){
						$this->insertMembreSpecialite($object, $spe);
					}
				}
				// ajout des instruments
				$arrayInstruments = $object->getArrayInstruments();
				if (is_array($arrayInstruments) AND count($arrayInstruments) > 0){
					foreach($arrayInstruments as $instru){
						$this->insertMembreInstrument($object, $instru);
					}
				}
				return $idMembre;
			}
			else {
				return 0;
			}
		}
		else {
			echo "ce n'est pas un membre";
		}
	}

	public function updateOne($object, $object2){
		$result = 0;
		if ($object2 instanceof Membre){
			$result = parent::updateOne($object, $object2);
		}

		if ($object instanceof Membre AND $object2 instanceof Membre){
			$array1 = $object->getArraySpecialites();
			$array2 = $object2->getArraySpecialites();
			$arraySpe1 = array();
			$arraySpe2 = array();

			if (is_array($array1)){
				foreach($array1 as $s){
					if ($s->getIdMembre() > 0){
						$arraySpe1[$s->getIdSpecialite()] = $s->getIdSpecialite();
					}
				}
			}
			if (is_array($array2)){
				foreach($array2 as $s){
					$arraySpe2[$s->getIdSpecialite()] = $s->getIdSpecialite();
				}
			}

			$diff1 = array_diff_key($arraySpe1, $arraySpe2);
			$diff2 = array_diff_key($arraySpe2, $arraySpe1);
			if (is_array($diff1) AND is_array($diff2)){
				if (count($diff1) != 0 OR count($diff2) != 0 ){
					foreach($diff1 as $s){
						$this->deleteMembreSpecialite($object, new Specialite($s, ""));
					}
					foreach($diff2 as $s){
						$this->insertMembreSpecialite($object, new Specialite($s, ""));
					}
				}
			}

			$array1 = $object->getArrayInstruments();
			$array2 = $object2->getArrayInstruments();
			$arrayI1 = array();
			$arrayI2 = array();

			if (is_array($array1)){
				foreach($array1 as $i){
					if ($i->getIdMembre() > 0){
						$arrayI1[$i->getIdInstrument()] = $i->getIdInstrument();
					}
				}
			}

			if (is_array($array2)){
				foreach($array2 as $i){
					$arrayI2[$i->getIdInstrument()] = $i->getIdInstrument();
				}
			}

			$diff1 = array_diff_key($arrayI1, $arrayI2);
			$diff2 = array_diff_key($arrayI2, $arrayI1);
			if (is_array($diff1) AND is_array($diff2)){
				if (count($diff1) != 0 OR count($diff2) != 0 ){
					foreach($diff1 as $i){
						$this->deleteMembreInstrument($object, new Instrument($i, ""));
					}
					foreach($diff2 as $i){
						$this->insertMembreInstrument($object, new Instrument($i, ""));
					}
				}
			}
		}

		return $result;
	}

	// recherche des groupes du membre
	private function findGroupes($id){

	}

	// recherche des instruments
	private function findInstruments($id){
		// requête sql
		$reqsql = "SELECT i.id_instrument, i.nom_instrument, id_personne
		FROM  " . $this->schema . "instruments i
		LEFT JOIN (SELECT ji.id_instrument as id_instru, id_personne
		FROM  " . $this->schema . "joue_instrument ji
		WHERE ji.id_personne = :id_membre)
		ON i.id_instrument = id_instru";

		// exécution de la requête paramétrée avec retour des résultats
		$instruments = $this->prepare_param($reqsql, array('id_membre' => $id));

		// lecture résultats
		if (is_array($instruments)){
			foreach($instruments as $element){
				$obj = new Instrument($element['ID_INSTRUMENT'], $element['NOM_INSTRUMENT']);
				if ($element['ID_PERSONNE'] != null){
					$obj->setIdMembre($element['ID_PERSONNE']);
				}
				$arr[] = $obj;
			}
			$this->unMembre->setArrayInstruments($arr);
		}
	}

	// recherche des spécialités
	private function findSpecialites($id){
		// requête sql
		$reqsql = "SELECT s.id_specialite, s.lib_specialite, id_personne FROM  " . $this->schema . "specialites s
		LEFT JOIN (SELECT aps.id_specialite as id_spe, aps.id_personne
		FROM  " . $this->schema . "a_pour_specialite aps
		WHERE id_personne = :id_membre)
		ON s.id_specialite = id_spe";
		$specialites = $this->prepare_param($reqsql, array('id_membre' => $id));
		if (is_array($specialites)){
			foreach($specialites as $element){
				$obj = new Specialite($element['ID_SPECIALITE'], $element['LIB_SPECIALITE']);
				if ($element['ID_PERSONNE'] != null){
					$obj->setIdMembre($element['ID_PERSONNE']);
				}
				$arr[] = $obj;
			}
			$this->unMembre->setArraySpecialites($arr);
		}
	}

	private function insertMembreSpecialite($membre, $specialite){
		if ($membre instanceof Membre AND $specialite instanceof Specialite){
			if ($membre->getId() > 0 AND $specialite->getIdSpecialite() > 0){
				// requête sql
				$reqsql = "INSERT INTO "  . $this->schema . "a_pour_specialite VALUES  (:id_specialite, :id_personne)";
				$result = $this->prepare_modif($reqsql, array('id_specialite' => $specialite->getIdSpecialite(),
				'id_personne' => $membre->getId()));
			}
		}
	}

	private function deleteMembreSpecialite($membre, $specialite){
		if ($membre instanceof Membre AND $specialite instanceof Specialite){
			if ($membre->getId() > 0 AND $specialite->getIdSpecialite() > 0){
				// requête sql
				$reqsql = "DELETE "  . $this->schema . "a_pour_specialite WHERE id_specialite = :id_specialite " .
				" AND id_personne = :id_personne";
				$result = $this->prepare_modif($reqsql, array('id_specialite' => $specialite->getIdSpecialite(),
				'id_personne' => $membre->getId()));
			}
		}
	}

	private function insertMembreInstrument($membre, $instrument){
		if ($membre instanceof Membre AND $instrument instanceof Instrument){
			if ($membre->getId() > 0 AND $instrument->getIdInstrument() > 0){
				// requête sql
				$reqsql = "INSERT INTO "  . $this->schema . "joue_instrument VALUES (:id_instrument, :id_personne)";
				$result = $this->prepare_modif($reqsql, array('id_instrument' => $instrument->getIdInstrument(),
				'id_personne' => $membre->getId()));
			}
		}
	}

	private function deleteMembreInstrument($membre, $instrument){
		if ($membre instanceof Membre AND $instrument instanceof Instrument){
			if ($membre->getId() > 0 AND $instrument->getIdInstrument() > 0){
				// requête sql
				$reqsql = "DELETE "  . $this->schema . "joue_instrument WHERE id_instrument = :id_instrument " .
				" AND id_personne = :id_personne";
				$result = $this->prepare_modif($reqsql, array('id_instrument' => $instrument->getIdInstrument(),
				'id_personne' => $membre->getId()));
			}
		}
	}
}
