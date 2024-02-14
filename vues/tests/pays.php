<?php
$doc = new DOMDocument('1.0', 'UTF-8');
$doc->formatOutput = true;
$root = $doc->createElement('lespays'); // racine groupes
$root = $doc->appendChild($root); // ajout

for ($p = 0; $p < 6; $p++) {
	$nbp = $p +1 ;
	
	$pays = $doc->createElement("pays"); // groupe
	
	$attr = $doc->createAttribute("id");
	$attr->value = $nbp;
	
	$attr = $pays->appendChild($attr);
	
	$nom = $doc->createElement('nompays'); // nom du pays
	$texte = $doc->createTextNode('nompays ' . $p);
	$texte = $pays->appendChild($texte);
	
	$pays = $root->appendChild($pays);
	
	
	
	for ($r = 0; $r < 3; $r++) {
		$region =  $doc->createElement('region'); // région
		$texte = $doc->createTextNode('region ' . $r);
		$texte = $region->appendChild($texte);
		$attr = $doc->createAttribute("idregion");
		$attr->value = $r;
		$attr = $region->appendChild($attr);
		$region = $pays->appendChild($region);
	}
}
echo $doc->saveXML();