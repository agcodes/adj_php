<?php
class AutoLoad {
	public static function autoloadEntites($class){
		$rep = 'entites/';
		AutoLoad::autoloadRep($rep, $class);
	}
	public static function autoloadDao($class){
		$rep = 'dao/';
		AutoLoad::autoloadRep($rep, $class);
	}
	public static function autoloadModele($class){
		$rep = 'modeles/';
		AutoLoad::autoloadRep($rep, $class);
	}
	public static function autoloadRep($rep, $class){
		$file = $rep . $class . '.php';
		if(is_file($file)){
			require_once($file);
		}
	}
}
