<?php
// singleton Connexion
class ConnectDao {
	const db = "oci:dbname=//localhost:1521/xe;charset=AL32UTF8";
	private static $user = "Rjava";
	private static $pass = "janvier13";
	// Manager base
	protected static $bdd = null ;

	protected $schema = "Rjava.";

	// CONNECTEUR BASE
	private static function getConnect_() {
		ConnectDao::getSession();
		try {
			ConnectDao::$bdd = new PDO (ConnectDao::db, ConnectDao::$user, ConnectDao::$pass );
			ConnectDao::$bdd->query('SET NAMES utf8');
			return ConnectDao::$bdd;

		} catch ( Exception $e ) {
			throw new Exception("Connexion impossible" . ConnectDao::db . " - " . ConnectDao::$user . '<br/>' . $e);
			return null;
		}
	}

	private static function getSession(){
		$session = new Session();
		if ($session->getSession("acces") > 0){
			$access = $session->getSession("access");
			if ($access == 3){
				ConnectDao::$user = "visiteur";
				ConnectDao::$pass = "view17b";
			}
			elseif ($access == 2) {
				ConnectDao::$user = "gerant";
				ConnectDao::$pass = "use16b";
			}
			elseif ($access == 1) {
				ConnectDao::$user = "Rjava";
				ConnectDao::$pass = "janvier13";
			}
		}
		else {
			ConnectDao::$user = "visiteur";
			ConnectDao::$pass = "view17b";
		}
		//echo ConnectDao::$user . " - " . ConnectDao::$pass . "";
	}

	public static function getBdd() {
		if (empty ($bdd) ||$bdd == null) {
			$bdd = ConnectDao::getConnect_();
		}
		return $bdd;
	}

	protected function deconnect(){
		ConnectDao::$bdd = null;
	}

	protected function setUser($user){
		$this->user = $user;
	}

	protected function setPass($pass){
		$this->pass = $pass;
	}
}