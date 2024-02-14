<?php
class AccessDaoUtilisateur extends Dao {

	/**
	 * Trouver un utilisateur
	 * @param object objet Utilisateur
	 */
	public function findOne($object){
		if ($object instanceof Utilisateur){
			if ($object->getLogin() != "" AND $object->getPassword() != ""){
				$reqSql = "select " . $this->schema . " appli_user_security.valid_user('" . $object->getLogin() . "','" . $object->getPassword() . "') from dual";
				$result = $this->prepare_gen($reqSql);

				foreach($result as $element){
					if (isset($element['0'])){
						$access = $element['0'];
						$object->setAccess($access);

						break;
					}
				}
			}
		}
		return $object;
	}

	/**
	 * Trouver tous les utilisateurs
	 */
	public function findAll(){
	}

	public function findAllWithFK($object){
	}

	public function insertOne($object){
		if ($object instanceof Utilisateur){
			if ($object->getLogin() != "" AND $object->getPassword() != ""){
				$reqSql = "BEGIN appli_user_security.add_user('" . $object->getLogin() . "','" . $object->getPassword() . "'," . $object->getAccess() . ") ; END;";
				$result = $this->prepare_gen($reqSql);

				foreach($result as $element){
					if (isset($element['0'])){
						$access = $element['0'];
						$object->setAccess($access);

						break;
					}
				}
			}
		}
		return $object;
	}

	/**
	 * Supprimer un utilisateur
	 * @param object objet Utilisateur
	 */
	public function deleteOne($object){
	}

	/**
	 * Modifier un utilisateur
	 * @param object objet Utilisateur
	 */
	public function updateOne($object, $object2){
	}
}