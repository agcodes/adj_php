<?php
class DaoFactory {
	public static function getDAOGroupe(){
		return new AccessDaoGroupeM();
	}

	public static function getDAORegion(){
		return new AccessDaoRegion();
	}

	public static function getDAOPays(){
		return new AccessDaoPays();
	}

	public static function getDAOPersonne(){
		return new AccessDaoPersonne();
	}

	public static function getDAOMembre(){
		return new AccessDAOMembre();
	}

	public static function getDAOComposeGroupe(){
		return new AccessDaoComposeGroupe();
	}

	public static function getDAOGroupeM(){
		return new AccessDaoGroupeM();
	}

	public static function getDAOUtilisateur(){
		return new AccessDaoUtilisateur();
	}

	public static function getDAOOeuvre(){
		return new AccessDaoOeuvre();
	}
}