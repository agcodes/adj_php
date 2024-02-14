<!DOCTYPE html>
<html dir='ltr' lang='fr'>
	<head>
		<title>Air de Java</title>
		<meta content="Air de Java" name="description" />
		<meta content='text/html; charset=UTF-8' http-equiv='Content-Type' />
		<meta content='Arnaud Gac' name='author' />
		<link rel="stylesheet" type="text/css" href="vues/style.css" />
		<!--[if lt IE 9]> <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->
		<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js' type='text/javascript'></script>
		<script src='vues/js/vue.js' type='text/javascript'></script>
	</head>
	<body onload="addListeners()">
		<header id="entete">
			<h1 class="swing">Air de Java</h1>
			<nav role="navigation">
				<ul>
					<li><a href="index.php">Accueil</a></li>
					<li><a href="mailto:airjava@gmail.com?subject=contact">Contact</a></li>
					<li><a href="index.php?action=plan">Plan du site</a></li>
					<li><a href="#">Aide</a></li>
					<?php if ($session->getSession("login") != ""){ ?>
						<li>Connecté : <?php echo $session->getSession("login"); ?></li>
						<li><a href="index.php?action=deconnexion">Déconnexion</a></li>
					<?php } else { ?>
						<li>Déconnecté</li>
						<li><a href="index.php?action=connexion">Connexion</a></li>
					<?php } ?>

				</ul>
			</nav>
			<div class='cb'></div>
		</header>

		<main role="main">
			<?php if ($session->getSession("acces") > 0) { ?>
				<section class = "toggle">
					<h1 title = "cliquez">Menu</h1>
					<ul class = "sectioncache">
						<li>Gestion des groupes</li>
						<li><a href = "index.php?controleur=membres">Gestion des membres</a></li>
						<li>Gestion des oeuvres</li>
						<li>Gestion des rencontres</li>
					</ul>
				</section>
			<?php } ?>
			<!-- Contenu principal -->
			<?= $contenu ?>
		</main>
		<footer role = "contentinfo">
			<ul>
				<li><a href="#">Mentions légales</a></li>
				<li><a href="#">Vie privée</a></li>
				<li><a href="#">Médiateur</a></li>
				<li><a href="#">Accessibilité</a></li>
				<li id="lien-haut-page"><a href="#entete">Haut de page</a></li>
			</ul>
			<div class='cb'></div>
		</footer>
	</body>
</html>