
<?php
	ini_set("default_charset", "UTF-8");
	session_start();
	require_once("editace.php");
	$empty=false; //Overovani vyplneni formulare
	$uspech=true; //Pozadavky pro registraci
 if(!empty($_POST))
 {

  if(isset($_POST['jmeno']))
    $tj=$_POST['jmeno'];
  if(isset($_POST['prijmeni']))
    $tp=$_POST['prijmeni'];
  if(isset($_POST['add']))
    $ta=$_POST['add'];
  if(isset($_POST['mail']))
    $tm=$_POST['mail'];
  if(isset($_POST['tel']))
    $tt=$_POST['tel'];
	foreach ($_POST as $argument) 
	{
		if(empty($argument))
		{
			$empty=true;
			break;
		}	
	}
	if($empty)
	{	
    
		header("location: registrace.php?info=vpvu&tjv=$tj&tpv=$tp&tav=$ta&tmv=$tm&ttv=$tt");
		$uspech=false;
	}
	else{
		/*pripojeni do databaze*/
		$link=getConnectDb();

		$jmena=mysql_query("SELECT login FROM uzivatele", $link);
		/*Kontrola, zda zadany login existuje*/
	  while ($Kontrola_loginu=mysql_fetch_row($jmena))
	  {
	  	foreach ($Kontrola_loginu as $login)
		{
			
			if($login==$_POST["mail"] && $uspech)
			{
				header("location: registrace.php?info=teje&tjv=$tj&tpv=$tp&tav=$ta&tmv=$tm&ttv=$tt");
				$uspech=false;
			}
		}
	  }
		
		/*Kontrola hesla*/
		if($_POST["pass_reg"]!=$_POST["pass_reg2"] && $uspech)
		{
			header("location: registrace.php?info=hsn&tjv=$tj&tpv=$tp&tav=$ta&tmv=$tm&ttv=$tt");
			$uspech=false;
		}
		/*delka hesla, alespon 8 znaku*/
		else if((strlen($_POST["pass_reg"])<=8) && $uspech)
		{
			header("location: registrace.php?info=hjpk&tjv=$tj&tpv=$tp&tav=$ta&tmv=$tm&ttv=$tt");
			$uspech=false;
		}
		/*Pokud vsechny udaje byly spravne, uloz do databaze*/
		if($uspech)
		{	
			$vlozeni=mysql_query("INSERT INTO uzivatele(login, heslo, jmeno, prijmeni, adresa, email, telefon, is_admin) 
			VALUES ('$_POST[mail]','$_POST[pass_reg]','$_POST[jmeno]','$_POST[prijmeni]','$_POST[add]','$_POST[mail]','$_POST[tel]', false)", $link);	
			if($vlozeni)
			{
				echo "Uspesna registrace ".$Kontrola_loginu[0];	
				header("location: registrace.php?info=Registrace proběhla úspěšně & correct=true");
				exit();
			}
			else{
				echo "nepodarilo se vas vlozit do databaze, zkuste to prosim znovu";
			}
		}
	}
}	
?>

<!DOCTYPE html>
<html>
<link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Orbitron' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Titillium+Web' rel='stylesheet' type='text/css'>
<head>
	<title>Rezervace letenek</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
  $(function() {
    $( "#datepicker2" ).datepicker();
  });
  </script>
  <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>

	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	
		<div id="header">
		<h1>Rezervace letenek</h1>
		</div>
		<div id="menu">
		 <nav>
            <ul class="fancyNav">
                <li id="home"><a href="index.php">Letenky</a></li>
                <li id="news"><a href="destinace.php">Kam létáme</a></li>
              	<?php 
              			if(isset($_SESSION['admin']))
              				echo "<li id=\"admin\"><a href=\"admin.php\">Administrace</a></li>";
                    	
                    	else if(isset($_SESSION['username']))
                      echo "<li id=\"admin\"><a href=\"mujucet.php\">Můj účet</a></li>";
              	?>
                <li id="services"><a href="registrace.php">Registrace</a></li>
            </ul>
        </nav>
        </div>
        
        <div id="pageField">
          <div class="infopanel" id="index"><br>
              <?php
                    if(!empty($_SESSION['username']))
                        {
                          echo "Jste přihlášen jako ". htmlspecialchars($_SESSION['username']);
             
                			if(isset($_SESSION['admin']))
			                 {  
                           if($_SESSION['admin'])
                             echo ' admin';         
			                 }
                          echo "<br>";
                          echo "<a href=\"login.php?odhlasit\">Odhlásit</a>";
                        }
                    else
                      echo "Nejste přihlášen";
              ?>
          </div>

          <div id="reg_form">
            <div id="login">
              <h2>Registrace</h2>
            </div>
            <div id="jmeno_prij">
                
                <?php
		if(isset($_GET['tjv'])) 
		{	
                  $tjv=$_GET['tjv'];			
                  $tjv=urldecode($tjv);
		}
		if(isset($_GET['tav']))
		{
                  $tav=$_GET['tav'];
                  $tav=urldecode($tav);
		}
		if(isset($_GET['ttv']))
		{
                  $ttv=$_GET['ttv'];
                  $ttv=urldecode($ttv);
		}
		if(isset($_GET['tpv']))
		{
                  $tpv=$_GET['tpv'];
                  $tpv=urldecode($tpv);
		}
                  
                echo "<form method=\"post\"> ";
                if(isset($tjv))
                  echo "<input id=\"jmeno\" name=\"jmeno\" placeholder=\"Jméno\" type=\"text\" value=\"$tjv\"/>";
                else 
                  echo "<input id=\"jmeno\" name=\"jmeno\" placeholder=\"Jméno\" type=\"text\"/>";
                if(isset($tpv))
                  echo "<input id=\"prijmeni\" name=\"prijmeni\" placeholder=\"Příjmení\" type=\"text\" value=\"$tpv\" >";
                else
                  echo "<input id=\"prijmeni\" name=\"prijmeni\" placeholder=\"Příjmení\" type=\"text\">";
                if(isset($tav))
                 echo "<input id=\"add\" name=\"add\" placeholder=\"Adresa\" type=\"text\" value=\"$tpv\" >";
                else
                   echo "<input id=\"add\" name=\"add\" placeholder=\"Adresa\" type=\"text\">";
                if(isset($tpv))    
                   echo "<input id=\"tel\" name=\"tel\" placeholder=\"Telefon\" type=\"text\" value=\"$ttv\" >";
                else
                  echo "<input id=\"tel\" name=\"tel\" placeholder=\"Telefon\" type=\"text\" >";
                if(isset($tmv))
                  echo "<input id=\"mail\" name=\"mail\" placeholder=\"E-mail\" type=\"text\" value=\"$tmv\" >";
                else
                  echo "<input id=\"mail\" name=\"mail\" placeholder=\"E-mail\" type=\"text\" >";
            echo "
             </div>
            <div id=\"jmeno_prij\">
                <input id=\"pass_reg\" name=\"pass_reg\" placeholder=\"Heslo (minimálně 8 znaků)\" type=\"password\">
                <input id=\"pass_reg2\" name=\"pass_reg2\" placeholder=\"Kontrola hesla\" type=\"password\">
                <input name=\"submit_reg\" type=\"submit\" value=\" Registrovat \">
               ";
            ?>
            	 <?php 
            	 	/*Vysledek registrace, popripade chyba*/
		      if(isset($_GET['info']))
		      {		
            	 	if(isset($_GET['correct']))
            	 	{	
            	 		echo "<h3 style=\"color: green; font-weight: bold;\">".$_GET['info']."</h3>";
            	 		echo "<a href=\"index.php\" style=\"font-size: 20px; color: blue;\">Přejít na hlavní stránku</a>";
            	  	}
            	 	else		           
                  if($_GET['info']=="vpvu")
            	 		  echo "<h3 style=\"color: red; font-weight: bold;\">Vyplnte prosim vsechny udaje</h3>";
                  elseif($_GET['info']=="teje")
                    echo "<h3 style=\"color: red; font-weight: bold;\">tento login nebo E-mail již existuje !!!</h3>";
		              elseif($_GET['info']=="hsn")
                    echo "<h3 style=\"color: red; font-weight: bold;\">hesla se neshodují</h3>";
                  elseif($_GET['info']=="hjpk")
                    echo "<h3 style=\"color: red; font-weight: bold;\">Heslo je příliš krátké, musí obsahovat alespoň 8 znaků !!!</h3>";

          }
                ?>
            </div>
            </div>

            <?php  if(isset($_SESSION['admin']))
            {
              echo"<div id=\"tlacitko_reg1\">
                <form method=\"post\">
                <table class=\"edit_menu\">
                
                  <tr><td><input type=\"button\" name=\"reg_window\" value=\"Administrace\" onclick=\"location.href='admin.php'\"></td></tr>
               
                  <tr><td><input type=\"button\" name=\"reg_windows\" value=\"Vytvořit let\" onclick=\"location.href='let.php'\"></td></tr>
                  
                  
                  
                  
                  </table>
                </form>
              </div>";
              }
              ?>
                
            
      
        </div>
 

</body>
</html>

