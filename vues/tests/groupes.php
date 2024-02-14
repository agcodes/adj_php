<?php
$doc = new DOMDocument('1.0', 'UTF-8');
$doc->formatOutput = true;
$root = $doc->createElement('groupes'); // racine groupes
$root = $doc->appendChild($root); // ajout

for ($g = 0; $g < 6; $g++) {
	$groupe = $doc->createElement('groupe'); // groupe
	$groupe = $root->appendChild($groupe);
	$nom = $doc->createElement('nomgroupe'); // membre
	$nb = $g + 1;
	$texte = $doc->createTextNode('nomgroupe ' . $nb);
	$texte = $nom->appendChild($texte);
	$nom = $groupe->appendChild($nom);
	
	for ($m = 0; $m < 3; $m++) {
		$membre = $doc->createElement('membre'); // membre
			$nomMembre = $doc->createElement('nom'); // nom du membre
			$nomMembre = $membre->appendChild($nomMembre);
			$nbm = $m + 1;
			$texte = $doc->createTextNode('nom ' . $nbm);
			$texte = $nomMembre->appendChild($texte);
			$prenomMembre = $doc->createElement('prenom'); // prénom du membre
			$prenomMembre = $membre->appendChild($prenomMembre);
			$texte = $doc->createTextNode('prenom ' . $nbm);
			$texte = $prenomMembre->appendChild($texte);
		$membre = $groupe->appendChild($membre);
	}
}
echo $doc->saveXML();

//echo 'Écrit : ' . $doc->save("groupes.xml") . ' bytes'; // Écrit