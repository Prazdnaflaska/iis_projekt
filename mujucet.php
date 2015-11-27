<?php
  session_start();
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
                    if(!$_SESSION['admin'])
                      echo "<li id=\"admin\"><a href=\"mujucet.php\">Můj účet</a></li>";
                    ?>
        <li id="services"><a href="registrace.php">Registrace</a></li>
      
      </ul>
    </nav>
    </div>
    <div id="pageField">
      <div class="infopanel" id="rez_vh"><br>
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
      <div id="rez_vyhled">
        <div id="login">
       		<h2>Moje rezervace</h2>
       	</div>
        <table class="data">
            <tr class="head">
                <td>Odlet z</td>
                <td>Destinace</td>
                <td>Sedadlo</td>
                <td>Datum</td>
                <td>Čas odletu</td>
                <td></td>
              </tr>
                <?php 
                  require_once("editace.php");
                  $link=getConnectDb();
                  $result=mysql_query("SELECT jmeno, prijmeni, adresa, email, telefon FROM uzivatele");
              while($row = mysql_fetch_row($result))
                {
                  echo "<tr>";
                  echo "<td>$row[0] </td>";
                    echo "<td>$row[1] </td>";
                    echo "<td>$row[2] </td>";
                    echo "<td>$row[3] </td>";
                    echo "<td>$row[4] </td>";
                    echo "<td><input type=\"button\" value=\"Zrušit\" onclick=\"window.close()\"></td><br>";
                    echo "</tr>\n";
                  }
              ?>
              </table>

      </div>

       <div id="rez_vyhled">
        <div id="login">
          <h2>Můj účet</h2>
        </div>
        <table class="data">
            <tr class="head">
                <td>Jméno</td>
                <td>Příjmení</td>
                <td>Adresa</td>
                <td>E-mail</td>
                <td>Telefoní číslo</td>
                <td></td>
              </tr>
                <?php 
                  require_once("editace.php");
                  $link=getConnectDb();
                  $result=mysql_query("SELECT jmeno, prijmeni, adresa, email, telefon FROM uzivatele");
              while($row = mysql_fetch_row($result))
                {
                  echo "<tr>";
                  echo "<td>$row[0] </td>";
                    echo "<td>$row[1] </td>";
                    echo "<td>$row[2] </td>";
                    echo "<td>$row[3] </td>";
                    echo "<td>$row[4] </td>";
                    echo "<td><input type=\"button\" value=\"Upravit\" onclick=\"window.close()\"></td><br>";
                    echo "</tr>\n";
                  }
              ?>
              </table>

      </div>
    </div>

</body>
</html>
