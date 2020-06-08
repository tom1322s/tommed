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
				<li style="margin-left:80px";>Doktor</li>
				<li style="margin-left:90px";>Specjalizacja</li>
				<li style="margin-left:40px";>Przychodnia</li>
				<li style="margin-left:60px";>Data</li>
				<li style="margin-left:110px";>Godzina</li>
				<li style="margin-left:50px";>
				
				<?php
				
				$var = 'meeting_id';
				if(isset($_POST['sortuj']) )
				{
					$name = $_POST['sortuj'];
					if ($name == 'docname')
					{
						$var = 'doctors.first_name';
					}
					else if ($name == 'spec')
					{
						$var = 'doctors.specialization';
					}
					else if ($name == 'clinic')
					{
						$var = 'clinic.name';
					}
					else if ($name == 'data')
					{
						$var = 'meetings.date';
					}
					else if ($name == 'time')
					{
						$var = 'meetings.time';
					}
				}
				
				?>
				
				
					<form action="meetings.php" method="post">
						
						<select name="sortuj" id="sortuj">
							<option value="id">sort by...</option>
							<option value="id">id</option>
							<option value="docname">doc name</option>
							<option value="spec">specjalizacja</option>
							<option value="clinic">przychodnia</option>
							<option value="data">data</option>
							<option value="time">czas</option>
							

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
					$u_id = $_SESSION['id'];
					
					if ($rezultat = @$polaczenie->query(
					sprintf("SELECT meetings.meeting_id,doctors.first_name,doctors.specialization,clinic.name,meetings.date,meetings.time 
					FROM meetings,doctors,clinic
					where user_id='%s' and meetings.doctor_id=doctors.doctor_id 
						and doctors.clinic_id=clinic.clinic_id 
					ORDER BY %s",
					mysqli_real_escape_string($polaczenie,$u_id),
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
							echo '<li style="width:150px;">'.$wiersz['specialization'].'</li>';
							echo '<li style="width:150px;">'.$wiersz['name'].'</li>';
							echo '<li style="width:150px;">'.$wiersz['date'].'</li>';
							echo '<li style="width:50px;">'.$wiersz['time'].'</li>';
							
							echo '<li style="width:50px;">';
							echo '<form action="deleteMeeting.php" method="post">';
							echo '<input type="hidden" name="'.$wiersz['meeting_id'].'" value="" />';
							echo '<input id="newMeetingButton" type="submit" value="usun wizyte" />';
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