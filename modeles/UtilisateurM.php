<?php
class UtilisateurM {
	public function connexionUtilisateur($login, $password){
		$utilisateur = new Utilisateur($login, $password);
		$daoUtilisateur = DaoFactory::getDAOUtilisateur();
		$object = $daoUtilisateur->findOne($utilisateur);
		return $object->getAccess();
	}
}