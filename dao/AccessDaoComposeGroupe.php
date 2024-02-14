<?php
class AccessDaoComposeGroupe extends Dao {

	/**
	 * Trouver une association groupe-membre
	 * @param object objet ComposeGroupe
	 */
	public function findOne($object){
		$composeGroupe = null; // objet ComposeGroupe
		// test type objet
		if ($object instanceof ComposeGroupe){
			// test validité objet
			if ($object->getMembre()->getId() > 0 AND $object->getGroupe()->getIdGroupe() > 0){
				// requête sql
				$reqsql = "SELECT id_personne, id_groupe, date_debut, date_fin, id_fonction
				FROM  " . $this->schema . "compose_groupes
				WHERE id_personne = :id_personne
				AND id_groupe = :id_groupe";
				// exécution de la requête paramétrée avec retour des résultats
				$result = $this->prepare_param($reqsql,
					array(
						'id_personne' => $object->getMembre()->getId(),
						'id_groupe' => $object->getGroupe()->getIdGroupe(),
					)
				);
				// lecture résultats
				if (is_array($result)){
					if (is_array($result)){
						foreach($result as $element){
							$composeGroupe = new ComposeGroupe($element['ID_GROUPE'], $element['ID_PERSONNE']);
							break; // on ne recherche qu'un objet
						}
					}
				}
			}
		}
		return $composeGroupe;
	}

	/**
	 * Trouver tous les associations groupe-membre
	 */
	public function findAll(){
	}

	public function findAllWithFK($object){
		$arrComposition = array();
		if ($object instanceof Groupe) {
			// requête sql
			$reqsql = "SELECT cg.id_groupe, p.id_personne, p.nom, p.prenom, to_char(cg.date_debut, 'YYYY-MM-DD') as datedeb, "
			. " to_char(cg.date_fin, 'YYYY-MM-DD') as datefin, to_char(m.date_naissance, 'YYYY-MM-DD') as date_naissance "
			. "FROM  " . $this->schema . "personnes p "
			. "INNER JOIN  " . $this->schema . "membres m on m.id_personne = p.id_personne "
			. "INNER JOIN  " . $this->schema . "compose_groupes cg on cg.id_personne = m.id_personne "
			. "WHERE cg.id_groupe = :idgroupe AND "
			. "cg.date_fin is null "
			. "ORDER BY p.nom, p.prenom, date_naissance";
			$param = array($object->getIdGroupe());

			// exécution de la requête paramétrée avec retour des résultats
			$results = $this->prepare_param($reqsql, $param);

			// lecture résultats
			if (is_array($results)){
				foreach($results as $element){
					$composeGroupe = new ComposeGroupe(new Groupe($element['ID_GROUPE'],"", "",""), new Membre($element['ID_PERSONNE']));
					$composeGroupe->getMembre()->setNom($element['NOM']);
					$composeGroupe->getMembre()->setPrenom($element['PRENOM']);
					$composeGroupe->getMembre()->setDateNaissance($element['DATE_NAISSANCE']);
					$composeGroupe->setDateDebut($element['DATEDEB']);
					$composeGroupe->setDateFin($element['DATEFIN']);
					$arrComposition[] = $composeGroupe; // ajout du membre
				}
			}
		}
		elseif ($object instanceof Membre) {
			// requête sql
			$reqsql = "SELECT cg.id_groupe, ng.nom_groupe, to_char(cg.date_debut, 'YYYY-MM-DD') as datedeb,
			to_char(cg.date_fin, 'YYYY-MM-DD') as datefin, cg.id_personne, cg.id_fonction, f.lib_fonction
			FROM  " . $this->schema . "noms_groupe ng
			INNER JOIN  " . $this->schema . "compose_groupes cg on cg.id_groupe = ng.id_groupe_
			LEFT JOIN  " . $this->schema . "fonctions f on f.id_fonction = cg.id_fonction
			WHERE cg.id_personne = :id_membre
			ORDER BY datefin DESC";

			// exécution de la requête paramétrée avec retour des résultats
			$results = $this->prepare_param($reqsql, array('id_membre' => $object->getId()));

			// lecture résultats
			if (is_array($results)){
				foreach($results as $element){
					$composeGroupe = new ComposeGroupe(new Groupe($element['ID_GROUPE'],"", "",""), new Membre($element['ID_PERSONNE']));
					$composeGroupe->setDateDebut($element['DATEDEB']);
					$composeGroupe->setDateFin($element['DATEFIN']);
					$composeGroupe->getGroupe()->setNomGroupe($element['NOM_GROUPE']);
					$arrComposition[] = $composeGroupe; // ajout du membre
				}
			}
		}
		return $arrComposition;
	}

	/**
	 * Insérer une association groupe-membre
	 * @param object objet ComposeGroupe
	 */
	public function insertOne($object){
		$result = 0;
		if ($object instanceof ComposeGroupe){
			// test validité objet à insérer
			if ($object->getMembre()->getId() > 0 AND $object->getGroupe()->getIdGroupe() > 0){
				// recherche objet dans COMPOSE_GROUPE
				$composeGroupe = $this->findOne($object);
				if ($composeGroupe == null){ // n'existe pas dans COMPOSE_GROUPE
					$this->beginTransaction_(); // début de transaction

					$daoPersonne = new AccessDaoPersonne(); // dao Personne

					// recherche dans table PERSONNES
					$unePersonne = $daoPersonne->findOne($object->getMembre()->getId());

					if ($unePersonne != null){ // existe dans PERSONNES
						$daoMembre = new AccessDaoMembre();

						// recherche dans table MEMBRES
						$unMembre = $daoMembre->findOne($object->getMembre(), 0);
						if ($unMembre == null){ // n'existe pas dans MEMBRES
							// insertion dans table MEMBRES
							if ($daoMembre->insertOne($unMembre) != 1){
								$unMembre = null; // création du membre a échoué
							}
						}

						if ($unMembre != null){ // ajout dans COMPOSE_GROUPE si objet trouvé ou créé
							// préparation partie requête date
							if ($object->getDateDebut() != null AND $object->getDateDebut() != ""){
								$dateDeb = $object->getDateDebut();
								$reqDateDeb = "to_date(:date_debut, 'yyyy-mm-dd')";
							}
							else {
								$reqDateDeb = ":date_debut";
								$dateDeb = null;
							}

							if ($object->getMembre()->getId()){
								// requête sql ajout dans COMPOSE_GROUPES
								$reqsql = "INSERT INTO  " . $this->schema . "compose_groupes
								VALUES (:id_personne, :id_groupe," . $reqDateDeb . ", :date_fin, :id_fonction)";

								// exécution de la requête paramétrée avec retour du résultat
								$result = $this->prepare_modif($reqsql, array(
									'id_personne' => $object->getMembre()->getId(),
									'id_groupe' => $object->getGroupe()->getIdGroupe(),
									'date_debut' => $object->getDateDebut(),
									'date_fin' => $object->getDateFin(),
									'id_fonction' => $object->getIdFonction()
								));
							}
						}
						else {
							$result = 4;
						}
					}
					else {
						$result = 3;
					}
					$this->endTransaction_();
				}
				else {
					$result = 2;
				}
			}
			else {
				$result = 5;
			}
		}
		else {
			$result = 6;
		}
		return $result;
	}

	/**
	 * Modifier une association groupe-membre
	 * @param object objet ComposeGroupe
	 */
	public function updateOne($object, $object2){
		$result = 0;
		if ($object instanceof ComposeGroupe){
			if ($object->getMembre()->getId() > 0 AND $object->getGroupe()->getIdGroupe() > 0){
				// recherche dans COMPOSE_GROUPES avant modification
				if ($this->findOne($object)){
					// preparation partie requête date
					$dateDebut = $this->testDate($object->getDateDebut());
					$dateFin = $this->testDate($object->getDateFin());
					$reqDateDeb = $this->reqDate($dateDebut, "datedebut");
					$reqDateFin = $this->reqDate($dateFin, "datefin");

					// requête sql modification compose_groupes
					$reqsql = "UPDATE " . $this->schema . "compose_groupes SET date_fin = " .
					$reqDateFin . ", date_debut = " . $reqDateDeb . " WHERE id_groupe = :idgroupe AND id_personne = :idmembre";
					// paramètres de la requête
					$params = array(
				 		'idmembre' => $object->getMembre()->getId(),
				 		'idgroupe' => $object->getGroupe()->getIdGroupe(),
				 		'datefin' => $dateFin,
						'datedebut' => $dateDebut
					);
					// exécution de la requête paramétrée avec retour du résultat
					$result = $this->prepare_modif($reqsql, $params);
				}
				else {
					$result = 4;
				}
			}
			else {
				$result = 3;
			}
		}
		else {
			$result = 2;
		}
		return $result;
	}

	/**
	 * Supprimer une association groupe-membre
	 * @param object objet ComposeGroupe
	 */
	public function deleteOne($object){
		if ($object instanceof ComposeGroupe){
			if ($object->getMembre()->getId() > 0 AND $object->getGroupe()->getIdGroupe() > 0){
				// requête sql
				$reqsql = "DELETE  " . $this->schema . "compose_groupes where id_groupe = :idgroupe AND id_personne = :idmembre";
				// exécution de la requête paramétrée avec retour du résultat
				$result = $this->prepare_modif($reqsql, array('idmembre' => $object->getMembre()->getId(), 'idgroupe' => $object->getGroupe()->getIdGroupe()));
				return $result;
			}
		}
	}
}