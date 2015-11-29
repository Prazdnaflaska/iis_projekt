<?php
  session_start();
  require_once("editace.php");
  if(isset($_POST['zrusit']))
  {
    $link=getConnectDb();
    $id_rezervace=$_POST['id_rezervace'];
    
    $zrusit=$_POST['zrusit'];
    $submit_id=array_keys($zrusit);
    $submit_id=$submit_id[0];
    $zrusit=$id_rezervace[$submit_id];

    $result=mysql_query("SELECT id_letenky FROM letenka NATURAL JOIN rezervace WHERE rezervace.id_rezervace='$zrusit'", $link);
    $row=mysql_fetch_row($result);
    $idlet=$row[0];
    
     mysql_query("DELETE FROM rezervace WHERE id_rezervace='$zrusit'", $link);
     mysql_query("UPDATE letenka SET pocet_mist=pocet_mist+1 WHERE id_letenky='$idlet'", $link);
    
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
        <form method="post">
        <table class="data">
            <tr class="head">
                <td>Odlet z</td>
                <td>Destinace</td>
                <td>Datum</td>
                <td>Čas odletu</td>
                <td>Třida</td>
                <td></td>
              </tr>
                <?php 
                  require_once("editace.php");
                  $login=$_SESSION['username'];
                  $link=getConnectDb();
                  $result=mysql_query("SELECT odkud, destinace, datum_odletu, cas_odletu, trida, id_rezervace FROM letenka NATURAL JOIN 
                                      rezervace NATURAL JOIN uzivatele WHERE rezervace.id_cestujici=uzivatele.id_cestujici 
                                      AND rezervace.id_letenky=letenka.id_letenky AND uzivatele.login='$login'", $link);
                  $i=0;
              while($row = mysql_fetch_row($result))
                {
                  echo "<tr>";
                  echo "<td><input type=\"hidden\" name=\"odkud[$i]\">$row[0] </td>";
                    echo "<td><input type=\"hidden\" name=\"destinace[$i]\">$row[1] </td>";
                    echo "<td><input type=\"hidden\" name=\"datum_od[$i]\">$row[2] </td>";
                    echo "<td><input type=\"hidden\" name=\"cas_od[$i]\">$row[3] </td>";
                    echo "<td><input type=\"hidden\" name=\"trida[$i]\">$row[4] </td>";
                    echo "<input type=\"hidden\" name=\"id_rezervace[$i]\" value=\"$row[5]\">";
                    echo "<td><input type=\"submit\" name=\"zrusit[$i]\" value=\"Zrušit\" onclick=\"window.close()\"></td><br>";
                    echo "</tr>\n";
                    $i++;
                  }
              ?>
              </table>
              </form>

      </div>

       <div id="rez_vyhled">
        <div id="login">
          <h2>Můj účet</h2>
        </div>
        <form action="editace.php" method="post"> 
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
                  $login=$_SESSION['username'];
                    $j=0;
                  $result=mysql_query("SELECT jmeno, prijmeni, adresa, email, telefon, login 
                                        FROM uzivatele WHERE login='$login'", $link);
                  $row=mysql_fetch_row($result);    
                 
                  echo "<tr>";
                  echo "<td><input name=\"jmeno[$j]\" type=\"text\" class=\"adminace\" value=\"$row[0]\"></td>";
              echo "<td><input name=\"prijmeni[$j]\"type=\"text\" class=\"adminace\" value=\"$row[1]\"></td>";
              echo "<td><input name=\"adresa[$j]\" type=\"text\" class=\"adminace\" value=\"$row[2]\"> </td>";
              echo "<td><input name=\"email[$j]\" type=\"text\" class=\"adminace\" value=\"$row[3]\"></td>";
              echo "<td><input name=\"telefon[$j]\" type=\"text\" class=\"adminace\" value=\"$row[4]\"> </td>";
              echo "<input name=\"login[$y]\" type=\"hidden\" class=\"adminace\" value=\"$row[5]\">";
                    echo "<td><input type=\"submit\" value=\"Upravit\" name=\"submitmuj[0]\"></td><br>";
                    echo "</tr>\n";
                  
              ?>
              </table>
              </form>
      </div>
    </div>

</body>
</html>
