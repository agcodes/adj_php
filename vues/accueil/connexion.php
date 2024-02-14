<article>
	<header>
		<h1>Connexion</h1>
	</header>
	<p><?php echo $info ;?></p>

	<div id="erreur">
		<p>Vous n'avez pas rempli correctement les champs du formulaire !</p>
	</div>

	<form action="index.php?action=connexion" id = 'form-connexion' method="post">
		<fieldset>
			<legend>Se connecter</legend>
			<ol>
				<li>
					<label for="pseudo">Nom d'utilisateur</label>
					<input type="text" id="pseudo" name = "pseudo" maxlength = "20" size = "20" title="3 à 20 caractères alphanumériques" pattern="[a-zA-Z0-9]{3,20}" required="required" autocomplete="off" class="champ" />
				</li>
				<li>
					<label for="mdp">Mot de passe</label>
					<input type="password" id="mdp" name = "mdp" maxlength = "20" size = "20" pattern="[\w€]{3,20}" title="3 à 20 caractères alphanumériques" required="required" class="champ" />
				</li>
				<li>
					<input type="submit" id="envoi" value="Valider" />
					<input type="reset" id="rafraichir" value="Effacer" />
				<li>
			</ol>
		</fieldset>
	</form>
</article>