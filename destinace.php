
<?php
	ini_set("default_charset", "UTF-8");
	session_start();
	require_once("editace.php");

 if(!empty($_POST))
 {
		if(isset($_POST['odstranit']))
		{
				$link=getConnectDb();

				$id_letenky=$_POST['idlet'];
    			$odstranit=$_POST['odstranit'];
    			$submit_id=array_keys($odstranit);
    			$submit_id=$submit_id[0];
    			$odstranit=$id_letenky[$submit_id];
    			
    			mysql_query("DELETE FROM letenka WHERE id_letenky='$odstranit'", $link);
    			header('location: destinace.php?notice=zruseno');

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

          <div class="textField" id="kam">
            <div id="login">
              <h2>Kam létáme</h2>
            </div>
       
       		<form method="post" action="">
        	<table class="data">
            <tr class="head">
                <td>Odlet z</td>
                <td>Destinace</td>
                <td>Společnost</td>
                <td>Třída</td>
                <?php
                	if(isset($_SESSION['admin']))
                		 echo "<td></td>";
                ?>
               

              </tr>
                <?php 
                  require_once("editace.php");
		 if(isset($_SESSION['username']))
	                  $login=$_SESSION['username'];

                  $link=getConnectDb();
                  $result=mysql_query("SELECT DISTINCT odkud, destinace, spolecnost, id_letenky, trida FROM letenka", $link);
                  $i=0;
                  echo "<br>";
              while($row = mysql_fetch_row($result))
                {
                  echo "<tr>";
                  echo "<td>$row[0]</td>";
                    echo "<td><input type=\"hidden\" name=\"destinace[$i]\">$row[1] </td>";
        			echo "<td>$row[2]</td>";
        			echo "<td>$row[4]</td>";
        			if(isset($_SESSION['admin']))
	        		{
	        			echo "<td><input type=\"submit\" name=\"odstranit[$i]\" value=\"odstranit\"></td>";
	        			echo "<input type=\"hidden\" name=\"idlet[$i]\" value=\"$row[3]\">";
	        		}	
                    	
                    echo "</tr>\n";
                    $i++;
                  }
                  
                    
                
                    /*Vysledek registrace, popripade chyba*/
                    if(isset($_GET['notice']))
                    { 
                    	if($_GET['notice']=="zruseno")
                      		echo "<h3 style=\"color: red; font-weight: bold; font-size: 20px;\">zruseno</h3>";                     
                    }                                 
              ?>
              </table>
              </form>
              </div>
      
        
        </div>
 

</body>
</html>

