<?php
// point d'entrée dans le programme
include_once 'vues/Vue.php';
include_once 'Controleur/Routeur.php' ;
include_once 'Controleur/AutoLoad.php';

session_start();

spl_autoload_register(array('AutoLoad', 'autoloadEntites'));
spl_autoload_register(array('AutoLoad', 'autoloadDao'));
spl_autoload_register(array('AutoLoad', 'autoloadModele'));

$r = new Routeur();
$r->routerRequete();
