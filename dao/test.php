<?php


$testGroupe = new AccessDaoGroupeM();
$arrGroupe = $testGroupe->findAll();

foreach($arrPays as $pays) {
	echo $pays->getNomPays();
	echo "<br/><br/>";
}


echo "<br/><br/>";


$testRegion = new AccessDaoRegion();
$arrRegion = $testRegion->findAll();

foreach($arrRegion as $region) {
	echo $region->getNomRegion();
	echo "<br/><br/>";
}

echo "<br/><br/>";

print_r($arrRegion);


$obj = new Pays();

if ($obj instanceof Pays) {
	echo 'A';
}

