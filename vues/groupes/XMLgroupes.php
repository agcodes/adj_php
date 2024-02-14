<?php
if (is_array($groupes)){
	$doc = new DOMDocument('1.0', 'UTF-8');
	$doc->formatOutput = true;
	$root = $doc->createElement('groupes'); // racine groupes
	$root = $doc->appendChild($root); // ajout

	foreach($groupes as $element){
		$groupe = $doc->createElement('groupe'); // groupe
		$groupe = $root->appendChild($groupe);

		$id = $doc->createElement('idgroupe'); // nom du groupe
		$texte = $doc->createTextNode($element->getIdGroupe());
		$texte = $id->appendChild($texte);
		$id = $groupe->appendChild($id);

		$nom = $doc->createElement('nomgroupe'); // nom du groupe
		$texte = $doc->createTextNode($element->getNomGroupe());
		$texte = $nom->appendChild($texte);
		$nom = $groupe->appendChild($nom);
	}
	echo $doc->saveXML();
}
else {
	echo "ce n'est pas un array";
}
