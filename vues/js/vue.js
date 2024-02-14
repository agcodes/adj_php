/**
 * 
 */

idGroupe = 0;

// ajout des listeners
function addListeners() {
	// Listener combo pays
	var combopays = document.getElementById("pays");
	if (combopays != null){
		combopays.addEventListener("change", function(){rechRegions(combopays);}, false );
	}
	
	var comboregions = document.getElementById("regions");
	if (comboregions != null){
		comboregions.addEventListener("change", function(){rechGroupes(comboregions);}, false );
	}
	
	var rechNom = document.getElementById("rech-personnes");
	if (rechNom != null){
		rechNom.addEventListener("click", function(){rechPersonnes();}, false );
	}
	
	var rechAjoutMembre = document.getElementById("ajout-membre");
	if (rechAjoutMembre != null){
		rechAjoutMembre.addEventListener("click", function(){ajoutMembre();}, false );
	}
	
	var idSupprMembre = document.getElementById("suppr-membre");
	if (idSupprMembre != null){
		idSupprMembre.addEventListener("click", function(){supprMembre();}, false );
	}
	
	var rechModifSpe = document.getElementById("modif-specialites");
	if (rechModifSpe != null){
		rechModifSpe.addEventListener("click", function(){modifSpe();}, false );
	}
	
	if (document.getElementById("form-connexion")){
		installJQListeners_();
	}
	toggle();
}

function groupeSelectionne(){
	var groupes = document.getElementsByName("select-groupe");
	if (groupes.length != 0){
		for (var i = 0; i < groupes.length; i++){
			if (groupes[i].checked == true){
				idGroupe = groupes[i].value;
				break;
			}
		}
	}
	return idGroupe;
}

function confirmation(){
	//var supprmembre = document.getElementById("form-suppression");
	choix = confirm("oui ou non?");
	if (choix == true) {
		this.submit();
	}
	else {
		return false;
	}
}

// AJAX
// Recuperation objet XMLHttpRequest
function MyXMLHttpRequest(){
	var xhr;		
	xhr = null;
	if (window.XMLHttpRequest)
			xhr = new XMLHttpRequest();
	else if(window.ActiveXObject){
		var names = [
			"Msxml2.XMLHTTP.6.0",
			"Msxml2.XMLHTTP.3.0",
			"Msxml2.XMLHTTP",
			"Microsoft.XMLHTTP"
		];
		for(var i in names){
			try{ 
				xhr = new ActiveXObject(names[i]);
				break;
			}
			catch(e){}
		}
	}
	else {
		alert("AJAX non supporté");
	}
	return xhr ;
}

function appelAjax(URL, mode, param, fonction) {
	if (URL == null) URL = URL_ ;
	var xhr = MyXMLHttpRequest(); //alert(xhr);
	xhr.open(mode, URL, false); // asynchrone
	xhr.onreadystatechange = function() { // Fonction Ajax asynchrone	 
		if (xhr.readyState == 4 && xhr.status < 300) {
			var sMyString =  xhr.responseText; // chaine retournee
			var oParser = new DOMParser();
			var xmlDoc = oParser.parseFromString(sMyString, "text/xml"); // parsage
	
			// LE RESULTAT DE XHR DOIT ETRE TRAITEE DANS LA FONCTION ASYNCHRONE	
			if (fonction == 3){
				parseXmlDocGroupes(xmlDoc);
			}
			if (fonction == 4){
				parseXmlDocMembres(xmlDoc);
			}
			if (fonction == 5){
				parseXmlDocPersonnes(xmlDoc);
			}
			if (fonction == 6){
				ajoutMembre2(sMyString);
			}
			if (fonction == 7){
				supprMembre2(sMyString);
			}
			if (fonction == 8){
				alert(sMyString);
			}
		}
	};
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // type mime requete
	xhr.send(param);
}

// RECHERCHE DES PERSONNES
function rechPersonnes(){
	var nomSaisi = document.getElementById("nom-membre").value;
	if (nomSaisi != ""){
		$("#result-personnes" ).empty(); // vide la liste des personnes
		var param = "nom="+nomSaisi;
		alert("Recherche pour " + nomSaisi);
		appelAjax("index.php?controleur=personnes&action=liste", "post", param, 5);
	}
	else {
		alert("Aucun nom saisi");
	}
}

function parseXmlDocPersonnes(xml) {
	if (xml.getElementsByTagName('personnes')) {
		var nombre = xml.getElementsByTagName("personne").length;
		alert(nombre + " personne(s) trouvée(s)");
		if (nombre > 0){
			var personnes = xml.getElementsByTagName("personne");
			for (var i = 0; i <= nombre; i++){
				var id = personnes[i].getElementsByTagName("id")[0].firstChild.nodeValue;
				var nom = personnes[i].getElementsByTagName("nom")[0].firstChild.nodeValue;
				var prenom = personnes[i].getElementsByTagName("prenom")[0].firstChild.nodeValue;
				$('#result-personnes').append('<li><input name="select-personne" type="radio" value="' + id + '"><span class = "nom-clic">' + prenom + ' ' + nom + '</span></li>');
				//alert(id + "" + prenom + " " + nom);
			}
		}
	}
}
// RECHERCHE DES GROUPES correspondant a la region selectionee
function rechGroupes(a) {
	RAZ();
	var valeurselectionnee = a.options[a.selectedIndex].value;
	if (valeurselectionnee > 0){
		var param = "region="+valeurselectionnee;
		$('#nb-result-groupes').append(0 + " groupe");
		appelAjax("index.php?controleur=groupes&action=groupesregions", "post", param, 3);
	}
}

//parser réponse pour afficher les groupes
function parseXmlDocGroupes(xml) {
	if (xml.getElementsByTagName('groupes')) {
		var nombre = xml.getElementsByTagName("groupe").length;
		if (nombre > 0){
			var groupes = xml.getElementsByTagName("groupe");
			$('#nb-result-groupes').empty();
			$('#nb-result-groupes').append(nombre + " groupe(s)");
			//$('#result-groupes').append('<li><span class = "nom-groupe"><em>Nom du groupe</em></span></li>');
			
			for (var i = 0; i <= nombre; i++){
				var nom = groupes[i].getElementsByTagName("nomgroupe")[0].firstChild.nodeValue;
				var idgroupe = groupes[i].getElementsByTagName("idgroupe")[0].firstChild.nodeValue;
				$('#result-groupes').append('<li><input onclick = "rechMembres(' + idgroupe + ');" name="select-groupe" type="radio" value="' + idgroupe + '"><span class = "nom-clic">' + nom + '</span></li>');
			}
		}
	}
}

// lancer fonction AJAX pour les membres
function rechMembres(idgroupe){
	if (idgroupe > 0){
		//$('#ajout-membre').append('<li><a href = "index.php?controleur=membres&action=membre&id=0&gr=' + idgroupe + '">Ajouter un membre</a></li>');
		$('#liste-membres').empty(); // on vide la liste
		$('#id-groupe-input').empty(); // on vide id groupe
		var param = "groupe="+idgroupe;
		
		$('#id-groupe-input').append('<input name="select-groupe-m" value="' + idgroupe + '" type="text" />');
		appelAjax("index.php?controleur=membres&action=membres_groupe", "post", param, 4);
	}
}

// affiche les membres d'apres resultat XML
function parseXmlDocMembres(xml) {
	if (xml.getElementsByTagName('membres')) {
		var nombre = xml.getElementsByTagName("membre").length;
		if (nombre > 0){
			var membres = xml.getElementsByTagName("membre");
			for (var i = 0; i <= nombre; i++){
				var id = membres[i].getElementsByTagName("id")[0].firstChild.nodeValue;
				var nommembre = membres[i].getElementsByTagName("nom")[0].firstChild.nodeValue;
				var prenommembre = membres[i].getElementsByTagName("prenom")[0].firstChild.nodeValue;
				
				var datedeb = "";
				if (membres[i].getElementsByTagName("datedebut")[0].firstChild != null){
					datedeb = membres[i].getElementsByTagName("datedebut")[0].firstChild.nodeValue;	
				}
				else {
					datedeb = "";
				}
				
				// ajout du membre
				$('#liste-membres').append('<li><input onclick = "selectMembre(' + id + ');" type="radio" name="select-membre" value="' + id + '"><a target = "_blank" href = "index.php?controleur=membres&action=membre&id=' + id + '"><span class = "nom-clic">' + prenommembre + ' ' + nommembre + '</span></a></li>');
				
				
				if (datedeb != ""){
					$('#liste-membres').append('<li class = "cacher"><input hidden = "hidden" type="date" id="datedeb' + id + '"" value="' + datedeb + '"/></li>');
				}
			}
		}
	}
}

function selectMembre(id){
	//alert(id);
	var dateDebut = "";
	if (document.getElementById("datedeb" + id)){
		dateDebut = document.getElementById("datedeb" + id).value;
		//alert(dateDebut);
	}
	else {
		dateDebut = "";
	}
	// modifier date debut
	$("input[id=date-debut-m]").val(dateDebut);
	
}

//MODIFICATION DU MEMBRE
function supprMembre(){
	var idMembre = 0;
	var membres = document.getElementsByName("select-membre");
	if (membres.length != 0){
		for (var i = 0; i < membres.length; i++){
			if (membres[i].checked == true){
				idMembre = membres[i].value; // membre sélectionné
				break;
			}
		}
	}
	var dateDebut = "";
	if (document.getElementById("date-debut-m")){
		dateDebut = document.getElementById("date-debut-m").value;
	}
	
	var dateFin = "";
	if (document.getElementById("date-fin-m")){
		dateFin = document.getElementById("date-fin-m").value;
	}
	alert("Date de début : " + dateDebut);
	
	if (dateDebut != ""  || dateFin != ""){
		if (idMembre == 0){
			alert("Veuillez sélectionner un membre");
			return false;
		}
		idGroupe = groupeSelectionne(); // groupe sélectionné
		if (idGroupe == 0){
			alert("Veuillez sélectionner un groupe");
			return false;
		}
		if (idMembre > 0 && idGroupe > 0){
			param = "select-membre="+idMembre+"&select-groupe="+idGroupe+"&datedebut="+dateDebut+"&datefin="+dateFin;
			appelAjax("index.php?controleur=membres", "post", param, 7);
		}
	}
	else {
		alert("Les dates n'ont pas été modifiées");
	}
	
}

function supprMembre2(sMyString){
	if (sMyString == 1){
		alert("Le membre a été modifié");
		$("input[id=date-debut-m]").val("");
		$("input[id=date-fin-m]").val("");
		rechMembres(idGroupe);
	}
	else if (sMyString == 3){
		alert("Dates incorrectes");
	}
	else {
		alert("Echec modification du membre");
	}
}

// AJOUT D'UN MEMBRE
function ajoutMembre(){
	var idMembre = 0;
	var dateSaisie = document.getElementById("date-debut").value;

	idGroupe = groupeSelectionne();
	if (idGroupe == 0){
		alert("Veuillez sélectionner un groupe");
		return false;
	}
	var personnes = document.getElementsByName("select-personne");
	
	if (personnes.length != 0){
		for (var i = 0; i < personnes.length; i++){
			if (personnes[i].checked == true){
				idMembre = personnes[i].value; // personne sélectionnée
				break;
			}
		}	
	}
	
	if (idMembre == 0){
		alert('Vous devez sélectionner une personne');
		return false;
	}
	
	if (idMembre > 0 && idGroupe > 0){
		param = "select-personne="+idMembre+"&select-groupe="+idGroupe+"&date-debut="+dateSaisie;
		appelAjax("index.php?controleur=membres", "post", param, 6);
	}
}

function ajoutMembre2(sMyString){
	if (sMyString == 1){
		alert("La personne a été ajoutée");
		rechMembres(idGroupe);
	}
	else if (sMyString == 2){
		alert("La personne sélectionnée est déjà dans le groupe");
	}
	else if (sMyString == 3){
		alert("La personne est introuvable dans le fichier");
	}
	else if (sMyString == 4){
		alert("Le membre est introuvable dans le fichier");
	}
	else if (sMyString == 5){
		alert("Erreur");
	}
	else {
		alert("Echec ajout du membre");
	}
}

function modifSpe(){
	var specialites = document.getElementsByName("specialites");
	var chaineSpes = "";

	if (specialites.length != 0){
		for (var i = 0; i < specialites.length; i++){
			if (specialites[i].checked == true){
				alert(specialites[i].value); // spécialité sélectionnée
				chaineSpes = chaineSpes + specialites[i].value + "/";
			}
		}	
	}

	var param = "spes=" + chaineSpes;
	appelAjax("index.php?controleur=membres&action=specialites", "post", param, 8);
}

//affiche/masque regions du pays selectionne dans combo pays
function rechRegions(a) {
	var x = a.selectedIndex;
	var y = a.options[x].value;
	var r = document.getElementById("regions");

	for (var i=0;i<r.length;i++){
		var c = r.options[i].className;
		if (c == y || c == "0"){
			r.options[i].style.display="block"; // masque la région
		}
		else {
			r.options[i].style.display="none";
		}
	}
	RAZ();
	r.selectedIndex = 0;
}

function RAZ(){
	$('#liste-membres').empty(); // vide la liste des membres
	$("#result-groupes" ).empty(); // vide la liste des groupes
	$('#nb-result-groupes').empty();
}

// JQUERY affiche/masque sections
function toggle(){
	// On cache les elements sectioncache
	// sauf celui qui porte la classe "open_at_load" :
	$(".sectioncache:not('.open_at_load')").hide();
	
	$(".toggle > h1").click(function() {
		// Si l'élément sectioncache etait deja ouvert, on le referme :
		if ($(this).next(".sectioncache:visible").length != 0) {
			$(this).next(".sectioncache").slideUp("normal");
		}
		// Si l'element sectioncache est cache, on ferme les autres et on l'affiche :
		else {
			$(this).next(".sectioncache").slideDown("normal");
		}
		return false;
	});
	
	$(".toggle > legend").click(function() {
		// Si l'element sectioncache etait deja ouvert, on le referme :
		if ($(this).next(".sectioncache:visible").length != 0) {
			$(this).next(".sectioncache").slideUp("normal");
		}
		// Si l'element sectioncache est cache, on ferme les autres et on l'affiche :
		else {
			$(this).next(".sectioncache").slideDown("normal");
		}
		return false;
	});
}


// formulaire de connexion
function installJQListeners_() {
	var $pseudo = $('#pseudo'),
	$mdp = $('#mdp'),
	$envoi = $('#envoi'),
	$reset = $('#rafraichir'),
	$erreur = $('#erreur'),
	$champ = $('.champ');
	
	$champ.keyup(function(){
		if($(this).val().length < 3){ // si la chaine de caracteres est inferieure a 5
			$(this).css({ // on rend le champ rouge
				borderColor : 'red',
				color : 'red'
			});
		}
		else{
			$(this).css({ // si tout est bon, on le rend vert
				borderColor : 'green',
				color : 'green'
			});
		}
	});

	$envoi.click(function(e){
		//e.preventDefault(); // on annule la fonction par defaut du bouton d'envoi
		// puis on lance la fonction de verification sur tous les champs :
		verifier($pseudo);
		verifier($mdp);
		if ($('#pseudo').val().length < 3 || $('#mdp').val().length < 3){
			$erreur.css('display', 'block'); // on affiche le message d'erreur
			return false;
		}
	});

	function verifier(champ){
		if(champ.val() == ""){ // si le champ est vide
			$erreur.css('display', 'block'); // on affiche le message d'erreur
			champ.css({ // on rend le champ rouge
				borderColor : 'red',
				color : 'red'
			});
		}
	}	
	
	$reset.click(function(){
		$champ.css({ // on remet le style des champs comme on l'avait defini dans le style CSS
			borderColor : '#ccc',
			color : '#555'
		});
		
		$erreur.css('display', 'none'); // on prend soin de cacher le message d'erreur
	});
}
