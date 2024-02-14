
<!DOCTYPE html>
<html dir='ltr' lang='fr'>
	<head>
		<title>Test regex</title>
		<meta content="Air de Java" name="description" />
		<meta content='text/html; charset=UTF-8' http-equiv='Content-Type' />
		<meta content='Arnaud Gac' name='author' />
		<link rel="stylesheet" type="text/css" href="vues/style.css" />
		<!--[if lt IE 9]> <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->
		<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js' type='text/javascript'></script>
		<script src='vues/js/vue.js' type='text/javascript'></script>
	</head>
	<body">
	<?php

		echo "arnaudgac donne " . nettoyageAlphaNum("arnaudgac") . "<br/>";
		echo "arnaud - gac éèàùêâ donne " . nettoyageAlphaNum("arnaud - gac éèàùêâ- ") . "<br/>";

		echo "arnaud ' - gac éèàùêâ- donne " . nettoyageAlphaNum("arnaud ' - gac éèàùêâ- ") . "<br/>";


		echo "&é'(-è_çà)éèàùêâ- donne " . nettoyageAlphaNum("&é'(-è_çà)éèàùêâ- ") . "<br/>";


		function valideDate($value){
			$date_ = str_replace("-", "/", $value);
			if (preg_match( '`^\d{4}/\d{2}/\d{2}$`', $date_ )){ // format yyyy/mm/dd
				list($year, $month, $day) = split('[/.-]', $date_); // Valide une date grégorienne
				if (checkdate ($month,$day,$year)){
					return $value;
				}
			}
			elseif (preg_match( '`^\d{2}/\d{2}/\d{4}$`', $date_ )){ // format dd/mm/yyyy
				list($day, $month, $year) = split('[/.-]', $date_); // Valide une date grégorienne
				if (checkdate ($month, $day, $year)){
					return $year . "-" . $month . "-" . $day; // formatage
				}
			}
			return "";
		}

		echo valideDate( '21/11/1999') . " test 21/11/1999<br/>";; // -> true
		echo valideDate( '2100-11-10') . " test 2100/11/10<br/>";; // -> true
		echo valideDate( '0000-11-10') . " test 0000/11/10<br/>";; // -> true
		echo valideDate( '0000-13-10') . " test 0000/13/10<br/>";; // -> true

		function nettoyageAlphaNum($string){
			$string2 = preg_replace("/[^_0-9a-zA-ZÀ-ÖØ-öø-ÿœŒ&\)\(\s\-\']/i",'', $string);
			if ($string2 != $string){
				echo "des caractères ont été remplacés<br/>";
			}
			return $string2;
		}
		?>
	</body>
</html>


