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
	<?php require_once "addCss.php" ?>
	<link rel="stylesheet" href="fontello/css/fontello.css" type="text/css" />
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
		
		<div id="about">
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
		
		</div>
		
		<div id="footer"> Najlepsza strona do umawiania wizyt Online!</div>
	</div>
	
<?php

	//echo "<p>Witaj ".$_SESSION['first_name'].'! [ <a href="logout.php">Wyloguj się!</a> ]</p>';
	
	
	//echo "<p><b>E-mail</b>: ".$_SESSION['mail'];

	
?>

</body>
</html>