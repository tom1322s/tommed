<?php
	if (isset($_POST['date']) and isset($_POST['time']))
	{
		if(isset($_SESSION['tempDoctor']))
		{
			//echo 'coReset';
			unset($_SESSION['tempDoctor']);
			//header('Location: mainPage.php');
		}
		header('Location: mainPage.php');
	}
?>