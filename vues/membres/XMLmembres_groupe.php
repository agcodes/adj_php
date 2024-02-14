<?php
if (is_array($cg)){
	$doc = new DOMDocument('1.0', 'UTF-8');
	$doc->formatOutput = true;
	$root = $doc->createElement('membres'); // racine groupes
	$root = $doc->appendChild($root); // ajout

	foreach($cg as $element){
		$membre = $doc->createElement('membre'); // membre
		$membre = $root->appendChild($membre);

		$id = $doc->createElement('id'); // nom
		$texte = $doc->createTextNode($element->getMembre()->getId());
		$texte = $id->appendChild($texte);
		$id = $membre->appendChild($id);

		$nom = $doc->createElement('nom'); // nom
		$texte = $doc->createTextNode($element->getMembre()->getNom());
		$texte = $nom->appendChild($texte);
		$nom = $membre->appendChild($nom);

		$prenom = $doc->createElement('prenom'); // prénom
		$texte = $doc->createTextNode($element->getMembre()->getPrenom());
		$texte = $prenom->appendChild($texte);
		$prenom = $membre->appendChild($prenom);

		$naissance = $doc->createElement('naissance'); // prénom
		$texte = $doc->createTextNode($element->getMembre()->getDateNaissance());
		$texte = $naissance->appendChild($texte);
		$naissance = $membre->appendChild($naissance);

		$datedeb = $doc->createElement('datedebut'); // prénom
		$texte = $doc->createTextNode($element->getDateDebut());
		$texte = $datedeb->appendChild($texte);
		$datedeb = $membre->appendChild($datedeb);
	}
	echo $doc->saveXML();
}