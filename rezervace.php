<?php
	session_start();
  if(!$_SESSION['admin'])
  { 
    echo "<meta charset=\"utf-8\">";
    echo "<p style=\"font-size: 50px;\">nejste přihlášen jako admin !!!</p>";
    echo "<a href=\"index.php\" style=\"font-size: 25px;\">zpět na hlavní stránku</a>";
     exit();
  } 
  if(!isset($_SESSION['username']))
  {
  	header('location: login.php');
    exit();
  }
  if($_GET['admin'])
  {
  		$_SESSION['admin']=true;
  }
  if(isset($_GET['odhlasit']))
  {
    session_destroy();
    header('location: index.php');
    exit();
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
                <li id="news"><a href="#news">Akce</a></li>
              	<?php 
              			if($_SESSION['admin'])
              				echo "<li id=\"admin\"><a href=\"admin.php\">Administrace</a></li>";
              	?>
                <li id="services"><a href="registrace.php">Registrace</a></li>
            </ul>
        </nav>
        </div>
       


        <div id="pageField">
                <div class="infopanel"  id="rez"><br>
         <?php
          if(!empty($_SESSION['username']))
          {
            echo "Jste přihlášen jako ". htmlspecialchars($_SESSION['username']);
              
              if($_SESSION['admin'])
                echo ' admin';         
            echo "<br>";
            echo "<a href=\"login.php?odhlasit\">Odhlásit</a>";
          }
          else
            echo "Nejste přihlášen";
         ?>

         </div>
            <div class="textField"  id="rezervace_lt">
        		<div id="login">
       				<h2>Rezervace letenek</h2>
       			</div>
       				<form action="" method="post">
       					<div id="typLetenky">
       						<label>Typ letenky</label>
       						<input type="radio" name="typ" value="" checked>Zpáteční
       						<input type="radio" name="typ" value="" >Jednosměrná
       						
       					</div>
       					<div id="typLetenky">
       						<label>Odlet z</label>
       						<input id="letenka" name="odlet" type="text"><br>
       						<label>Přílet do</label>
       						<input id="letenka" name="prilet" type="text"><br>
       						<label>Datum</label>
       						<input id="datepicker" name="date" placeholder="Datum od" type="text">
       						<label for="pomlcka">-</label>
       						<input id="datepicker2" name="date2" placeholder="Datum do" type="text">
       						</div>
       						<div id="typLetenky">
       							<label for="tridas">Třída</label>
       							<input type="radio" name="trida" value="" checked>First
       							<input type="radio" name="trida" value="" >Bussines
       							<input type="radio" name="trida" value="" >Economy
       							

       					</div>
       					<div id="typLetenky">
       						
       						<?php  if($_SESSION['admin']) 
       							{
       								echo "<label>E-mail uživatele</label>
       									<input id=\"letenka\" name=\"e_mail\" type=\"text\"><br>";
       							}
       						?>
       						<input name="rezervuj" type="submit" value="Rezervovat">
       					</div>



       					<span><?php echo $error; ?></span>
       				</form>
       				</div>
       				<?php  if($_SESSION['admin']) 
            {
            	echo"<div id=\"tlacitko_rez\">
        				<form method=\"post\">
        				<table class=\"edit_menu\">
        				
        					<tr><td><input type=\"button\" name=\"reg_window\" value=\"Administrace\" onclick=\"location.href='admin.php'\"></td></tr>
        					<tr><td><input type=\"button\" name=\"reg_windows\" value=\"Vytvořit rezervaci\" onclick=\"location.href='rezervace.php'\"></td></tr>
        					<tr><td><input type=\"button\" name=\"reg_windows\" value=\"Vytvořit let\" onclick=\"hello()\"></td></tr>
        					<tr><td><input type=\"button\" name=\"reg_windows\" value=\"Přidat společnost\" onclick=\"hello()\"></td></tr>
        					
        					
        					
        					</table>
        				</form>
        			</div>";
        			}
        			?>
       			
        </div>

</body>
</html>
