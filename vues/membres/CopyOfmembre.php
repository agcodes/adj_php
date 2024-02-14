<section>
	<p><?php echo $info ?></p>
</section>

<!-- vue d'un membre -->
<section>
	<header>
		<h1>Fiche membre</h1>
	</header>

	<form class="ajout-personne" action= "index.php?controleur=membres&action=membre&id=<?php echo $unMembre->getId()?>" method="post">
		<fieldset>
			<legend>Personne</legend>
			<ol>
				<li>
					<label for="civilite">Civilité</label>
					<select id="civilite" name="civilite">
						<?php if ($unMembre->getIdCivilite() == 1){
							$attr1 = "selected='selected'";
							$attr2 = "";
						} else {
							$attr1 = "";
							$attr2 = "selected='selected'";
						} ?>
						<option <?php echo $attr1 ?> value='1'>M.</option>
						<option <?php echo $attr2 ?> value='2'>Mme</option>
					</select>
				</li>

				<li>
					<label for="id-membre">Id</label>
					<input readonly = "readonly" id="id-membre" name="id-membre" value="<?php echo $unMembre->getId()?>" type="text" /> <!--type hidden-->
				</li>
				<li>
					<label for="nom-membre">Nom</label> <!--   -->
					<input id="nom-membre" name="nom-membre" value="<?php echo $unMembre->getNom()?>" maxlength="80" pattern="[A-Za-z\u00E0-\u00FC\s]{0,80}" type="text" title = "seules les lettres sont autorisées"/>
				</li>
				<li>
					<label for="prenom-membre">Prénom</label>
					<input id="prenom-membre" name="prenom-membre" value="<?php echo $unMembre->getPrenom()?>" pattern="[A-Za-z\u00E0-\u00FC\s\-]{0,80}" maxlength="80" type="text" />
				</li>
				<li>
					<label for="date-naissance">Date de naissance</label>
					<input id="date-naissance" min="1850-01-01" name="date-naissance" value = "<?php echo $unMembre->getDateNaissance()?>" type="date" />
				</li>
			</ol>
		</fieldset>

		<fieldset>
			<legend>Contacts</legend>
			<ol>
				<?php
				if (is_array($unMembre->getArrayContacts())){
					foreach($unMembre->getArrayContacts() as $d){
					?>
					<li>
						<label for="contact-<?php echo $d["ID_CONTACT"] ?>"><?php echo $d["LIB_TYPE_CONTACT"] ?></label>
						<input id="contact-<?php echo $d["ID_CONTACT"] ?>" name="contact-<?php echo $d["ID_CONTACT"] ?>" value="<?php echo $d["CONTACT"]; ?>" size="20" maxlength="20" type="tel" title = "numéro" autocomplete = "off" />
					</li>
					<?php
					}
				}
				?>
			</ol>
		</fieldset>

		<fieldset>
			<legend>Adresse</legend>
				<?php
				if (is_array($unMembre->getArrayAdresses())){
					foreach($unMembre->getArrayAdresses() as $d){
				?>
					<ol>
						<li>
							<label for="numero-voie-<?php echo $d["ID_ADRESSE"]; ?>">N°</label>
							<input id="numero-voie-<?php echo $d["ID_ADRESSE"]; ?>" name="numero-voie-<?php echo $d["ID_ADRESSE"]; ?>" value="<?php echo trim($d["NUMERO_VOIE"]); ?>" size="7" maxlength="7" type="text" pattern="[a-zA-Z0-9]{0,10}" />
						</li>
						<li>
							<label for="nom-voie-<?php echo $d["ID_ADRESSE"]; ?>">Nom de voie</label>
							<input id="nom-voie-<?php echo $d["ID_ADRESSE"]; ?>" name="nom-voie-<?php echo $d["ID_ADRESSE"]; ?>" value="<?php echo $d["NOM_VOIE"]; ?>" size="40" maxlength="128" title="0 à 10 caractères alphanumériques"  type="text" />
						</li>
						<li><label for="complement-adresse-<?php echo $d["ID_ADRESSE"]; ?>">Complément d'adresse</label>
							<input id="complement-adresse-<?php echo $d["ID_ADRESSE"]; ?>" name="complement-adresse-<?php echo $d["ID_ADRESSE"]; ?>" size="40" value="<?php echo $d["COMPLEMENT_ADRESSE"]; ?>" maxlength="128" type="text" />
						</li>
						<li>
							<label for="ville-<?php echo $d["ID_ADRESSE"]; ?>">Ville</label>
							<select id="ville-<?php echo $d["ID_ADRESSE"]; ?>" name="ville-<?php echo $d["ID_ADRESSE"]; ?>">
								<option value="1">Brest</option>
								<option value="2">Quimper</option>
							</select>
						</li>
					</ol>
				<?php
					}
				}
				?>
		</fieldset>

		<?php
		if (is_array($unMembre->getArrayGroupes())){
			$nbgroupe = 0;
			foreach($unMembre->getArrayGroupes() as $cg){
			$nbgroupe++;
			$idGroupe = $cg->getIdGroupe();
		?>
			<fieldset class="toggle">
				<legend>Groupe <?php echo $nbgroupe; ?></legend>
				<ol class="sectioncache">

					<li>
						<label for="groupe-<?php echo $idGroupe; ?>">Nom du groupe</label>
						<input disabled = "disabled" id="groupe-<?php echo $idGroupe; ?>" name ="groupe-<?php echo $idGroupe; ?>"  value="<?php echo $cg->getGroupe()->getNomGroupe(); ?>" type="text" />
					</li>

					<li>
						<label for="date-debut-<?php echo $idGroupe; ?>">Date d'entrée</label>
						<input disabled = "disabled" id="date-debut-<?php echo $idGroupe; ?>" name ="date-debut-<?php echo $idGroupe; ?>"  value="<?php echo $cg->getDateDebut(); ?>" type="date" />
					</li>
					<li>
						<label for="date-fin-<?php echo $idGroupe; ?>">Date de sortie</label>
						<input disabled = "disabled" id="date-fin-<?php echo $idGroupe; ?>" name ="date-fin-<?php echo $idGroupe; ?>"  value="<?php echo $cg->getDateFin(); ?>" type="date" />
					</li>

				</ol>
			</fieldset>
		<?php
			}
		}
		?>

		<fieldset>
			<legend>Spécialité(s)</legend>
			<?php
				if (is_array($unMembre->getArraySpecialites())){
					foreach($unMembre->getArraySpecialites() as $d){
						$attr = "";
						if ($d->getIdMembre() > 0){
							$attr = "checked='checked'";
						}
						echo "<input type='checkbox' " . $attr . " name='specialites[]' value='" . $d->getIdSpecialite() . "'>" . $d->getNomSpecialite() ;
					}
				}
			?>
		</fieldset>

		<fieldset class="toggle">
			<legend>Instrument(s)</legend>
			<select class="sectioncache" id="instruments" name="instruments[]" size="20" multiple="multiple">
				<?php
					if (is_array($unMembre->getArrayInstruments())){
						foreach($unMembre->getArrayInstruments() as $d){
							$attr = "";
							if ($d->getIdMembre() > 0){
								$attr = "selected='selected'";
							}
							echo "\n<option " . $attr . " value='" . $d->getIdInstrument() . "'>" . $d->getNomInstrument();
						}
					}
				?>
			</select>
		</fieldset>

		<input id='valider-membre' class='valider' role="button" type="submit" value="Valider" />
	</form>
	<?php if ($session->getSession("acces") < 2) { ?>
		<form id='form-suppression' onSubmit="return confirmation(this);" class="ajout-personne" action= "index.php?controleur=membres&action=membre&id=<?php echo $unMembre->getId()?>" method="post">
			<input class='valider' role="button" type="submit" value="Supprimer le membre" />
		</form>
	<?php } ?>
</section>