<?php

	session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: mainPage.php');
		exit();
	}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>TOMMED</title>
	
	<?php require_once "addCss.php" ?>
	<link rel="stylesheet" href="fontello/css/fontello.css" type="text/css" />
	<!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	-->
</head>

<body>
	
	<div id="container">
		<div id="logo"> TOMMED </div>
		
		<div id="intro">
			<div id="introText">
				TOMMED jest bezpłatną usługą umożliwiającą odanalezienie i zapisanie się do najlepszych lekarzy w kraju.
				<br/><br/><br/>
				Co nas wyróżnia? <br/>
				Profesjonalna obsługa medyczna <i class="icon-smiley"></i><i class="icon-adult"></i> <br/>
				Wykwalifikowana kadra doświadczonych lekarzy <i class="icon-book"></i><i class="icon-group"></i> <br/>
				Możliwość dojazdu do klienta <i class="icon-right"></i><i class="icon-warehouse"></i> <br/>
				Atrakcyjne ceny <i class="icon-asl"></i><i class="icon-adult"></i> <br/>
				<br/>
				Zapisz się na wizyte już dziś!!! <i class="icon-phone"></i><i class="icon-calendar"></i> <br/>
				<br/>
				Znajdz nas na:<br/>
				
				<div class="icon"><a href="https://www.facebook.com/" class="tilelink"><i class="icon-facebook"></i></a></div>
				<div class="icon"><a href="https://www.instagram.com/?hl=pl" class="tilelink"><i class="icon-instagram"></i></a></div>
				<div class="icon"><a href="https://twitter.com/explore" class="tilelink"><i class="icon-twitter"></i></a></div>
				<div class="icon"><a href="https://www.linkedin.com/" class="tilelink"><i class="icon-linkedin"></i></a></div>
				<div class="icon"><a href="https://github.com/" class="tilelink"><i class="icon-github-text"></i></a></div>
				<div style="clear:both;"></div>
			</div>
		</div>
		
		<div id="logIn">
		
			<br /><br />
			<a id="linkSmall" href="rejestracja.php">Rejestracja - załóż darmowe konto!</a>
			<br /><br />
			
			<form action="zaloguj.php" method="post">
			
				Login: <br /> <input class="loginIn" type="text" name="login" /> <br />
				Hasło: <br /> <input class="loginIn" type="password" name="haslo" /> <br /><br />
				<input id="loginButton" type="submit" value="Zaloguj się" />
			
			</form>
		<br /><br />
<?php
	if(isset($_SESSION['blad']))	echo $_SESSION['blad'];
?>
		</div>
		<div style="clear:both;"></div>
		
		<div id="footer"> Najlepsza strona do umawiania wizyt Online!</div>
	</div>
	


</body>
</html>