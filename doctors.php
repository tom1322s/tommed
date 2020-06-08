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
	
	<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){

		$('select[name="sortuj"]').change(function(){
			// as you select your pick, 
			// this will append the name inside the hidden input
			var selected = $(this).val();
			var value = $('select[name="sortuj"] option[value="'+selected+'"]').text();
			$(this).prev('input[name="selected"]').attr('value', value);
			$('form').submit();
		});

	});
	</script>-->
</head>

<body>
	
	<div id="container">
		<div id="logo"> TOMMED </div>
		
		<div class="nav">
			<ol>
				<li><a href="mainPage.php">Strona główna</a></li>
				<li><a href="#">Wizyta Online</a>
					<ul>
						<li><a href="meetings.php">Moje izyty</a></li>
						<li><a href="clinics.php">Umów wizyte</a></li>
					</ul>
				</li>
				<li><a href="clinics.php">Nasze przychodnie</a>
				</li>
				<li><a href="#">Nasi Lekarze</a>
					<ul>
						<li><a href="doctors.php">Spis</a></li>
						<li><a href="doctorsRank.php">Ranging</a></li>
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
		
		<div class="main">
		<div class="textNadTab">
			<ul>
				<li style="margin-left:80px";>Imie</li>
				<li style="margin-left:130px";>Nazwisko</li>
				<li style="margin-left:70px";>Specjalizacja</li>
				<li style="margin-left:50px";>Ranga</li>
				<li style="margin-left:30px";>Nr. kliniki</li>
				<li style="margin-left:60px";>
				
				<?php
				
				$var = 'clinic_id';
				if(isset($_POST['sortuj']) )
				{
					$name = $_POST['sortuj'];
					if ($name == 'fname')
					{
						$var = 'first_name';
					}
					else if ($name == 'sname')
					{
						$var = 'last_name';
					}
					else if ($name == 'id')
					{
						$var = 'doctor_id';
					}
					else if ($name == 'spec')
					{
						$var = 'specialization';
					}
					else if ($name == 'rank')
					{
						$var = 'rank';
					}
					else if ($name == 'clinic')
					{
						$var = 'clinic_id';
					}
				}
				
				?>
				
				
					<form action="doctors.php" method="post">
						
						<select name="sortuj" id="sortuj">
							<option value="id">sort by...</option>
							<option value="id">id</option>
							<option value="fname">first name</option>
							<option value="sname">second name</option>
							<option value="spec">specjalization</option>
							<option value="rank">rank</option>
							<option value="clinic">clinic</option>

						</select>
						
						<input id="sortButton" type="submit" value="Sortuj" />
					</form>
				</li>
			
			</ul>
		</div>
	
		
			<ol>
			
			<?php
				
				
				require_once "connect.php";

				$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
				if ($polaczenie->connect_errno!=0)
				{
					echo "Error: ".$polaczenie->connect_errno;
				}
				else
				{
					if ($rezultat = @$polaczenie->query(
					sprintf("SELECT * FROM doctors ORDER BY %s",
					mysqli_real_escape_string($polaczenie,$var))))
					{
					$num_clinic = $rezultat->num_rows;
					if($num_clinic>0)
					{
						while (($wiersz = $rezultat -> fetch_assoc()) !== null)
						{
						
							//echo '<li>'.$wiersz['name'].'</li>';
							echo '<li><ul>';
							echo '<li style="width:150px;">'.$wiersz['first_name'].'</li>';
							echo '<li style="width:150px;">'.$wiersz['last_name'].'</li>';
							echo '<li style="width:200px;">'.$wiersz['specialization'].'</li>';
							echo '<li style="width:70px;">'.$wiersz['rank'].'</li>';
							echo '<li style="width:50px;"><a href=clinics.php>'.$wiersz['clinic_id'].'</a></li>';
							
							echo '<li style="width:50px;">';
							echo '<form action="newMeeting.php" method="post">';
							echo '<input type="hidden" name="'.$wiersz['doctor_id'].'" value="" />';
							echo '<input id="newMeetingButton" type="submit" value="Umów się" />';
							echo '</form>';
							echo '</li>';
							
							echo '</ul></li>';
						}
						$rezultat->free_result();
							
					} 
					else {
							
							$_SESSION['blad'] = '<span style="color:red">Bład brak medyków!</span>';
							//header('Location: index.php');
										
						}
									
					}
								
					$polaczenie->close();
				}
				
			?>
			</ol>
		
		</div>
		
		<div id="footer"> Najlepsza strona do umawiania wizyt Online!</div>
	</div>
	
<?php

	//echo "<p>Witaj ".$_SESSION['first_name'].'! [ <a href="logout.php">Wyloguj się!</a> ]</p>';
	
	
	//echo "<p><b>E-mail</b>: ".$_SESSION['mail'];

	
?>

</body>
</html>