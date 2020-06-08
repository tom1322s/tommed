<?php

	session_start();
	
	if (isset($_POST['email']))
	{
		$wszystko_OK=true;
		$nick = $_POST['nick'];
		$fname = $_POST['fname'];
		$sname = $_POST['sname'];
		
		if ((strlen($nick)<3) || (strlen($nick)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków!";
		}
		
		if (ctype_alnum($nick)==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
		
		if (ctype_alnum($fname)==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_fname']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
		if (ctype_alnum($sname)==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_sname']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
		
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$wszystko_OK=false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail!";
		}
		
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		
		if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		if ($haslo1!=$haslo2)
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Podane hasła nie są identyczne!";
		}	

		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
		
		if (!isset($_POST['regulamin']))
		{
			$wszystko_OK=false;
			$_SESSION['e_regulamin']="Potwierdź akceptację regulaminu!";
		}				
		
		$sekret = "6Ldwk_8UAAAAANPfJlq3SYO4kioQd5J8ksOXXrnt";
		
		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
		
		$odpowiedz = json_decode($sprawdz);
		
		if ($odpowiedz->success==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
		}		
		
		//Zapamiętaj wprowadzone dane
		$_SESSION['fr_nick'] = $nick;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_haslo1'] = $haslo1;
		$_SESSION['fr_haslo2'] = $haslo2;
		$_SESSION['fr_fname'] = $nick;
		$_SESSION['fr_sname'] = $nick;
		if (isset($_POST['regulamin'])) $_SESSION['fr_regulamin'] = true;
		
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
				//Czy email już istnieje?
				$rezultat = $polaczenie->query("SELECT mail FROM users WHERE mail='$email'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}		

				//Czy nick jest już zarezerwowany?
				$rezultat = $polaczenie->query("SELECT login FROM users WHERE login='$nick'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_nickow = $rezultat->num_rows;
				if($ile_takich_nickow>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_nick']="Istnieje już gracz o takim nicku! Wybierz inny.";
				}
				
				if ($wszystko_OK==true)
				{
					//Hurra, wszystkie testy zaliczone, dodajemy gracza do bazy
					
					if ($polaczenie->query("INSERT INTO users (login,password,mail,first_name,last_name) VALUES ('$nick', '$haslo_hash', '$email','$fname','$sname')"))
					{
						$_SESSION['udanarejestracja']=true;
						header('Location: witamy.php');
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
	<title>TOMMED - załóż darmowe konto!</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	
	<?php require_once "addCss.php" ?>
	<style>
		.error
		{
			color:red;
			margin-top: 10px;
			margin-bottom: 10px;
		}
	</style>
</head>

<body>
	
	<div id="container">
		<div id="logo"> TOMMED </div>
		
		<div id="singUpDiv">
			
			<div style="float:left;">
				<form id="singUpText" method="post">
					
					<div style="float:left">
					
						Login: <br /> <input class="loginIn" type="text" value="<?php
							if (isset($_SESSION['fr_nick']))
							{
								echo $_SESSION['fr_nick'];
								unset($_SESSION['fr_nick']);
							}
						?>" name="nick" /><br />
						
						<?php
							if (isset($_SESSION['e_nick']))
							{
								echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
								unset($_SESSION['e_nick']);
							}
						?>
						
						E-mail: <br /> <input class="loginIn" type="text" value="<?php
							if (isset($_SESSION['fr_email']))
							{
								echo $_SESSION['fr_email'];
								unset($_SESSION['fr_email']);
							}
						?>" name="email" /><br />
						
						<?php
							if (isset($_SESSION['e_email']))
							{
								echo '<div class="error">'.$_SESSION['e_email'].'</div>';
								unset($_SESSION['e_email']);
							}
						?>
						
						Twoje hasło: <br /> <input class="loginIn" type="password"  value="<?php
							if (isset($_SESSION['fr_haslo1']))
							{
								echo $_SESSION['fr_haslo1'];
								unset($_SESSION['fr_haslo1']);
							}
						?>" name="haslo1" /><br />
						
						<?php
							if (isset($_SESSION['e_haslo']))
							{
								echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
								unset($_SESSION['e_haslo']);
							}
						?>		
						
						Powtórz hasło: <br /> <input class="loginIn" type="password" value="<?php
							if (isset($_SESSION['fr_haslo2']))
							{
								echo $_SESSION['fr_haslo2'];
								unset($_SESSION['fr_haslo2']);
							}
						?>" name="haslo2" /><br />
						
						<label>
							<input  type="checkbox" name="regulamin" <?php
							if (isset($_SESSION['fr_regulamin']))
							{
								echo "checked";
								unset($_SESSION['fr_regulamin']);
							}
								?>/> Akceptuję regulamin
						</label>
						
						<?php
							if (isset($_SESSION['e_regulamin']))
							{
								echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
								unset($_SESSION['e_regulamin']);
							}
						?>	
						
						<div class="g-recaptcha" data-sitekey="6Ldwk_8UAAAAAPdTDsRyVgziM4WvQOKAqOGbqfh2"></div>
						
						<?php
							if (isset($_SESSION['e_bot']))
							{
								echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
								unset($_SESSION['e_bot']);
							}
						?>	

						
						<input id="loginButton" type="submit" value="Zarejestruj się" />
					</div>
					<div style="float:left">
					
						Imię: <br /> <input class="loginIn" type="text" value="<?php
							if (isset($_SESSION['fr_fname']))
							{
								echo $_SESSION['fr_fname'];
								unset($_SESSION['fr_fname']);
							}
						?>" name="fname" /><br />
						
						<?php
							if (isset($_SESSION['e_fname']))
							{
								echo '<div class="error">'.$_SESSION['e_fname'].'</div>';
								unset($_SESSION['e_fname']);
							}
						?>
						
						Nazwisko: <br /> <input class="loginIn" type="text" value="<?php
							if (isset($_SESSION['fr_sname']))
							{
								echo $_SESSION['fr_sname'];
								unset($_SESSION['fr_sname']);
							}
						?>" name="sname" /><br />
						
						<?php
							if (isset($_SESSION['e_sname']))
							{
								echo '<div class="error">'.$_SESSION['e_sname'].'</div>';
								unset($_SESSION['e_sname']);
							}
						?>
					</div>
					<div style="clear:both;"></div>
					
				</form>
			
			</div>
			<div style="float:right;min-width:150px;"> obrazek</div>
			<div style="clear:both;"></div>
		</div>	
			
		<div id="footer"> Najlepsza strona do umawiania wizyt Online!</div>
	</div>
</body>
</html>