<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>TOMMED - Witaj</title>
	<!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	-->
	<?php require_once "addCss.php" ?>
</head>

<body>
	
	<div id="container">
		<div id="logo"> TOMMED </div>
		
		<div class="nav">
			<ol>
				<li><a href="mainPage.php">Strona główna</a></li>
				<li><a href="#">Wizyta Online</a>
					<ul>
						<li><a href="meetings.php">Moje wizyty</a></li>
						<li><a href="clinics.php">Umów wizyte</a></li>
					</ul>
				</li>
				<li><a href="clinics.php">Nasze przychodnie</a>
				</li>
				<li><a href="#">Nasi Lekarze</a>
					<ul>
						<li><a href="doctors.php">Spis</a></li>
						<li><a href="doctorsRank.php">Ranking</a></li>
					</ul>
				</li>
				<li><a href="#">Kontakt</a>
					<ul>
						<li><a href="aboutUs.php"><span style="font-size:80%">Czym jest TOMMED?</span></a></li>
						<li><a href="contact.php">Kontakt</a></li>
					</ul>
				</li>
				<li><a href="logout.php">Wyloguj się</a>
				</li>
			</ol>
		
		</div>
		
		<div id="mainPageCointeiner">
			
			<div id="topBar"> 
				<?php
				
				echo 'Witaj '.$_SESSION['first_name'].' '.$_SESSION['last_name'].'. Miło cie widziec!!!!';
				
				?> 
			</div>
			<div class="mainBlocks" style="margin-left:0px">
				<a href="meetings.php"> <img class="mainPageFoto" src="img/mojeWizyty.jpg"> </a>
				<a class="link" href="meetings.php"><p>Moje wizyty</p></a>
			</div>
			<div class="mainBlocks">
				<a href="clinics.php"> <img class="mainPageFoto" src="img/umowWizyte.jpeg"> </a>
				<a class="link" href="clinics.php"><p>Umów wizyte</p></a>
			</div>
			<div class="mainBlocks">
				<a href="clinics.php"> <img class="mainPageFoto" src="img/przychodnia.jpg"> </a>
				<a class="link" href="clinics.php"><p>Przychodnie</p></a>
			</div>
			<div class="mainBlocks">
				<a href="doctors.php"> <img class="mainPageFoto" src="img/lekarze.jpg"> </a>
				<a class="link" href="doctors.php"><p>Lekarze</p></a>
			</div>
			<div class="mainBlocks" style="margin-left:0px">
				<a href="doctorsRank.php"> <img class="mainPageFoto" src="img/ranking.jpg"> </a>
				<a class="link" href="doctorsRank.php"><p>Ranking</p></a>
			</div>
			<div class="mainBlocks">
				<a href="aboutUs.php"> <img class="mainPageFoto" src="img/szpital.jpg"> </a>
				<a class="link" href="aboutUs.php"><p>Czym jest TOMMED</p></a>
			</div>
			<div class="mainBlocks">
				<a href="contact.php"> <img class="mainPageFoto" src="img/kontakt.jpg"> </a>
				<a class="link" href="contact.php"><p>Kontakt</p></a>
			</div>
			<div class="mainBlocks">
				<a href="logout.php"> <img class="mainPageFoto" src="img/wyloguj.jpg"> </a>
				<a class="link" href="logout.php"><p>Wyloguj się</p></a>
			</div>
			<div style="clear:both;"></div>
			
		
		</div>
		
		<div id="footer"> Najlepsza strona do umawiania wizyt Online!</div>
	</div>
	
<?php

	//echo "<p>Witaj ".$_SESSION['first_name'].'! [ <a href="logout.php">Wyloguj się!</a> ]</p>';
	
	
	//echo "<p><b>E-mail</b>: ".$_SESSION['mail'];

	
?>

</body>
</html>