<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
	$wszystko_OK=true;
	
	$i = 0;
	while(!isset($_POST[$i]))
	{
		$i=$i+1;
	}
	$doctor = $i;
	
	if (isset($_POST['date']) and isset($_POST['time']))
	{
		$date = $_POST['date'];
		$time = $_POST['time'];
		
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$rezultat = $polaczenie->query("SELECT * FROM meetings WHERE doctor_id='$doctor' and date='$date' and time='$time'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_wizyt = $rezultat->num_rows;
				if($ile_takich_wizyt>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_datetime']="Wizyta w tym terminie już istnieje";
				}		
				
				if ($wszystko_OK==true)
				{
					$user=$_SESSION[id];
					if ($polaczenie->query("INSERT INTO meetings (user_id,doctor_id,date,time) VALUES ($user,$doctor,'$date','$time')"))
					{
						header('Location: meetings.php');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					
				}
				
				$polaczenie->close();
			}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			echo '<br />Informacja developerska: '.$e;
		}
		
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
		
		<div id="about">
			<div id="introText">
			
				<?php
					
					
					require_once "connect.php";

					$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
		
					if ($polaczenie->connect_errno!=0)
					{
						echo "Error: ".$polaczenie->connect_errno;
					}
					else
					{
						
						
						/*if ($rezultat = @$polaczenie->query("SELECT * FROM doctors ORDER BY rank DESC limit 5"))*/
						if ($rezultat = @$polaczenie->query(
						sprintf("SELECT * FROM doctors where doctor_id=%s",
						mysqli_real_escape_string($polaczenie,$doctor))))
						{
						$num_doctor = $rezultat->num_rows;
						if($num_doctor>0)
						{
							if (($wiersz = $rezultat -> fetch_assoc()) !== null)
							{
								echo '<br/>';
								echo '<div id="newMeetingText">';
								echo 'Umawiasz wizyte z doktorem '.$wiersz['first_name'].' ';
								echo $wiersz['last_name'].' o specjalizacji '.$wiersz['specialization'];
								echo '</div>';
								
								echo '<br/><br/>';
								echo '<form action="newMeeting.php" method="post">';
									echo '<input class="newMeetingInput" type="date" min="2020-06-10" max="2022-01-01" name="date" required/>';
									echo '<input class="newMeetingInput" type="time" min="08:00" max="18:00" name="time"  required/>';
									
									echo '<input id="newMeetingButton" type="submit" value="Umów wizyte" />';
									//$_SESSION['tempDoctor'] = $doctor;
									//echo 'setagain';
									echo '<input type="hidden" name="'.$doctor.'" value="" />';
									
								echo '</form>';
								
								if (isset($_SESSION['e_datetime']))
								{
									echo '<div class="error">'.$_SESSION['e_datetime'].'</div>';
									unset($_SESSION['e_datetime']);
								}
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
			</div>
		</div>
		
		<div id="footer"> Najlepsza strona do umawiania wizyt Online!</div>
	</div>

</body>
</html>