<?php
	//session_start();
	ini_set("default_charset", "UTF-8");	
	/*Funkce pro pripojeni k databazi*/
	function getConnectDb()
	{
			$link=mysql_connect("127.0.0.1", "root", "decathlon");
 			if(!$link)
 			{
 				echo "Chyba nepodarilo se spojit s databazi";
 				exit();
 			}
 			$select=mysql_select_db("rezervace_letenek", $link);
			if(!$select)
			{
				echo "Nepodarilo se vybrat databazi";
				exit();
			}
			return $link;
	}
	if(!empty($_POST))
	{
		/*Pokud admin bude chtit upravovat*/
		 if (isset($_POST['submit']) || isset($_POST['submitmuj']) || isset($_POST['submit_ucet']) )
		 {
		 		if(isset($_POST['submit']))
		 		{
   					$submit_id = array_keys($_POST['submit']);
   					$submit_id = $submit_id[0];
   				}

   				if(isset($_POST['submitmuj']))
		 		{
		 			
   					$submit_id = array_keys($_POST['submitmuj']);
   					$submit_id = $submit_id[0];
   				}

   				if(isset($_POST['submit_ucet']))
		 		{
   					$submit_id = array_keys($_POST['submit_ucet']);
   					$submit_id = $submit_id[0];
   				}
		
 		$i=0; 	

 		foreach ($_POST['heslo'] as $key)
 			{		
 					$heslo[$i]=$key;
 					$i++;
 			}	
 		$i=0;
 		foreach ($_POST['jmeno'] as $key)
 			{		
 					$jmeno[$i]=$key;
 					$i++;
 			}	
 			$i=0;
 		foreach ($_POST['prijmeni'] as $key)
 			{		
 					$prijmeni[$i]=$key;
 					$i++;
 			}	
 			$i=0;
 		foreach ($_POST['adresa'] as $key)
 			{		
 					$adresa[$i]=$key;
 					$i++;
 			}	
 			$i=0;
 		foreach ($_POST['email'] as $key)
 			{		
 					$email[$i]=$key;
 					$i++;
 			}	
 			$i=0;
 		foreach ($_POST['telefon'] as $key)
 			{		
 					$telefon[$i]=$key;
 					$i++;
 			}
 		

 			if(isset($_POST['submit']) || isset($_POST['submit_ucet']) )
 		 	{
 		/*Zacatek Admin checkbox*/
 			$admin = $_POST['admin'];
 		 	
 		 	
 		 	for($j=0; $j<$i; $j++)
 		 	{
 		 		if(isset($admin[$j]))
 		 		{
 		 			$admin[$j]=1;
 		 		}
 		 		else{
 		 			$admin[$j]=0;
 		 		}
 		 	}
 		 	
 		 	echo $admin[$submit_id];
 		 }
 		 /*konec Admin checkbox*/
 				$i=0;
 				print_r($_POST['login']);
 				foreach ($_POST['login'] as $key)
 				{		
 					$login[$i]=$key;
 					$i++;
 				}
 			
 			$link=getConnectDb();

 			mysql_query("UPDATE uzivatele SET heslo='$heslo[$submit_id]' WHERE login='$login[$submit_id]'", $link);	
			mysql_query("UPDATE uzivatele SET jmeno='$jmeno[$submit_id]' WHERE login='$login[$submit_id]'", $link);
			mysql_query("UPDATE uzivatele SET prijmeni='$prijmeni[$submit_id]' WHERE login='$login[$submit_id]'", $link);
			mysql_query("UPDATE uzivatele SET adresa='$adresa[$submit_id]' WHERE login='$login[$submit_id]'", $link);
			mysql_query("UPDATE uzivatele SET email='$email[$submit_id]' WHERE login='$login[$submit_id]'", $link);
			mysql_query("UPDATE uzivatele SET telefon='$telefon[$submit_id]' WHERE login='$login[$submit_id]'", $link);

			
			if(isset($_POST['submit']))
				mysql_query("UPDATE uzivatele SET is_admin='$admin[$submit_id]' WHERE login='$login[$submit_id]'", $link);						
			
			if(isset($_POST['submit']))
 		 	{
				header('location: admin.php?stav=Upraveno!');
			}
			
			if(isset($_POST['submitmuj']))
 		 	{
				header('location: mujucet.php?stav=Upraveno!');
			}

			if(isset($_POST['submit_ucet']))
 		 	{
				header('location: admin.php?stav2=Upraveno!');
			}
		}
		/*Konec upravovani*/
		/*Pokud admin bude chtit mazat*/
		if(isset($_POST['delete']))
		{
				$delete_id = array_keys($_POST['delete']);
   				$delete_id = $delete_id[0];
   			$i=0;
 			foreach ($_POST['login'] as $key)
 			{		
 					$login[$i]=$key;
 					$i++;
 			}
 			$link=getConnectDb();
			mysql_query("DELETE FROM uzivatele WHERE login='$login[$delete_id]'", $link);
			header('location: admin.php?stav=Smazáno!');
 		}
		/*Konec mazani*/
		
	}	
?>
