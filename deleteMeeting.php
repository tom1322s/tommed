<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
				
	require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{
		$i = 1;
		while(!isset($_POST[$i]))
		{
			$i=$i+1;
		}
		$meet = $i;
					
		if ($rezultat = @$polaczenie->query(
		sprintf("DELETE FROM meetings where meeting_id=%s",
		mysqli_real_escape_string($polaczenie,$meet))))
		{
			
			//$rezultat->free_result();		
		} 
		else {
							
			$_SESSION['blad'] = '<span style="color:red">Bład brak medyków!</span>';
			//header('Location: index.php');							
		}
									
	}
								
	$polaczenie->close();
	header('Location: meetings.php');

				
				
?>