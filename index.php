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
	<!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	-->
</head>

<body>
	
	<div id="container">
		<div id="logo"> TOMMED </div>
		
		<div id="intro">
			
			TOMMED jest bezpłatną usługą umożliwiającą ........
			<!--<button class="btn btn-primary">Zaloguj sie</button>-->
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