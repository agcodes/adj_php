<article>
	<header>
		<h1>Liste des membres</h1>
	</header>
	<form class="rech-groupe" action="index.html" method="post">
			<ol>
				<li>
					<label for="pays">Pays</label>
					<select id="pays" name="pays">
						<option value="0">Sélectionner un pays</option>
						<?php
						if (is_array($pays)){
							foreach($pays as $pays){
								echo "\n<option value='pays" . $pays->getIdPays() . "'>" . $pays->getNomPays() . "</option>";
							}
						}
						?>
					</select>
				</li>
				<li>
					<label for="regions">Région</label>
					<select id="regions" name="region">
						<option class = "0" value="0">Sélectionner une région</option>
						<?php
						if (is_array($regions)){
							foreach($regions as $region){
								echo "\n<option class = 'pays" . $region->getIdPays() . "' value='" .  $region->getIdRegion() .
								"'>" . $region->getNomRegion() . "</option>";
							}
						}
						?>
					</select>
				</li>
			</ol>
	</form>

	<form name = "liste-groupes" id = "form-groupes">
		<fieldset class="toggle">
			<legend>Groupes</legend>
			<ol class="sectioncache open_at_load"  id="result-groupes">
				<!-- chargement par AJAX -->
			</ol>
		</fieldset>

		<div class = "cacher" id = "id-groupe-input">
		</div>
		<fieldset class = "toggle" >
			<legend>Membres</legend>
			<ol class="sectioncache open_at_load" id="liste-membres">
				<!-- chargement par AJAX -->
			</ol>

			<ol>
				<li>
					<label for="date-debut-m">Date d'entrée</label>
					<input id="date-debut-m" min="1900-01-01" name="date-debut-m" value="" type="date" />
				</li>
				<li>
					<label for="date-fin-m">Date de sortie</label>
					<input id="date-fin-m" min="1900-01-01" name="date-fin-m" value="" type="date" />
				</li>
			</ol>

			<?php if ($session->getSession("acces") < 2) { ?>
				<a id='suppr-membre' role="button">Modifier le membre sélectionné</a>
			<?php } ?>
		</fieldset>

		<?php if ($session->getSession("acces") < 2) { ?>
			<fieldset class="toggle">
				<legend>Ajouter un membre dans le groupe sélectionné</legend>
				<ol class="sectioncache open_at_load">
					<li>
						<label for="nom-membre">Recherche par nom</label>
						<input id="nom-membre" name="nom-membre" value="" maxlength="80" pattern="[A-Za-z\u00E0-\u00FC\s]{0,80}" type="text" title = "seules les lettres sont autorisées"/>
					</li>
					<li>
						<a role="button" id = "rech-personnes">Rechercher</a>
					</li>

					<li>

						<ol class="sectioncache open_at_load"  id="result-personnes">
							<!-- chargement par AJAX -->
						</ol>
					</li>
					<li>
						<a role="button" id = "ajout-membre">Ajouter le membre sélectionné</a>
					</li>
					<li>
						<label for="date-debut">Date d'entrée dans le groupe</label>
						<input id="date-debut" min="1900-01-01" name="date-debut" value="<?php echo date("Y-m-d") ?>" type="date" />
					</li>
				</ol>
			</fieldset>
		<?php } ?>
	</form>
</article>

<nav class='fil-ariane'>
	<ul>
		<li itemscope='itemscope'
			itemtype='http://data-vocabulary.org/Breadcrumb'><a href='index.php'
			itemprop='url'><span itemprop='title'>Accueil</span></a>
		</li>
		<li itemscope='itemscope'
			itemtype='http://data-vocabulary.org/Breadcrumb'><a href='index.php?controleur=membres'
			itemprop='url'><span itemprop='title'>Membres</span></a>
		</li>
	</ul>
</nav>