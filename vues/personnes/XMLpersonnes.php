<?php
if (is_array($personnes)){
	$doc = new DOMDocument('1.0', 'UTF-8');
	$doc->formatOutput = true;
	$root = $doc->createElement('personnes'); // racine personnes
	$root = $doc->appendChild($root); // ajout

	foreach($personnes as $element){
		$personne = $doc->createElement('personne'); // personne
		$personne = $root->appendChild($personne);

		$id = $doc->createElement('id'); // id
		$texte = $doc->createTextNode($element->getId());
		$texte = $id->appendChild($texte);
		$id = $personne->appendChild($id);

		$nom = $doc->createElement('nom'); // nom
		$texte = $doc->createTextNode($element->getNom());
		$texte = $nom->appendChild($texte);
		$nom = $personne->appendChild($nom);

		$prenom = $doc->createElement('prenom'); // prénom
		$texte = $doc->createTextNode($element->getPrenom());
		$texte = $prenom->appendChild($texte);
		$nom = $personne->appendChild($prenom);
	}
	echo $doc->saveXML();
}
else {
	echo "ce n'est pas un array";
}