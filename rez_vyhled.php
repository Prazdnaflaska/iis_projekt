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
                if($_SESSION['admin'])
                    echo "<li id=\"admin\"><a href=\"admin.php\">Administrace</a></li>";
                else
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
       		<h2>Rezervace letenek</h2>
       	</div>
        <form method="post" action="platba.php">
        <table class="data">
            <tr class="head">
                <td>Odlet z</td>
                <td>Destinace</td>
                <td>Počet míst</td>
                <td>Datum</td>
                <td>Čas odletu</td>
                <td>Cena</td>
                <td></td>
              </tr>
                <?php 
                require_once("editace.php");

               function printTable($result)
               {
                $checkArray= array();
                $x=0;
                $y=0;
                while($row = mysql_fetch_row($result))
                { 
                            $isCorrect=true;
                            echo "<tr>";
                            echo "<td><input name=\"odlet[$y]\" value=\"$row[0]\" type=\"hidden\">$row[0] </td>";
                            echo "<td><input name=\"prilet[$y]\" value=\"$row[1]\" type=\"hidden\">$row[1] </td>";
                            echo "<td><input name=\"pocet_mist[$y]\" value=\"$row[2]\" type=\"hidden\">$row[2] </td>";
                            echo "<td><input name=\"datum[$y]\" value=\"$row[3]\" type=\"hidden\">$row[3] </td>";
                            echo "<td><input name=\"cas[$y]\" value=\"$row[4]\" type=\"hidden\">$row[4] </td>";
                            echo "<td><input name=\"cena[$y]\" value=\"$row[5]\" type=\"hidden\">$row[5] </td>";
                            echo "<td><input type=\"checkbox\" name=\"rezervuj[$y]\" value=\"Rezervovat\" ></td><br>";
                            echo "<input name=\"id_let[$y]\" value=\"$row[6]\" type=\"hidden\">";
                            echo "</tr>\n";
                            $y++;

                }

                          return $isCorrect;
               }

                if(!empty($_POST))
                {
                  $link=getConnectDb();
                  $isCorrect=false; //promenna pro informaci vyhledavani v databazi
                  /*Pokud neni zadano misto odletu nebo priletu skonci s chybou*/
                  if((empty($_POST['odlet'])) && (empty($_POST['prilet'])))
                  {
                    echo "neni zadano misto odletu nebo priletu";
                    header('location: login.php?notice=mistoOdletu');
                  }

                  elseif(!empty($_POST['odlet']))
                  {
                    $odkud=$_POST['odlet'];
                    $kam=$_POST['prilet'];

                   if (isset($_POST['class']))   // if ANY of the options was checked
                      $trida=$_POST['class'];    // echo the choice
                  else
                      $trida="economy"; //vychozi trida economy
                    
                      /*Pokud bylo zadano pouze misto odletu*/
                      if(!empty($_POST['odlet']) && empty($_POST['prilet']) && empty($_POST['date']) && empty($_POST['date2']))
                      {
                        $result=mysql_query("SELECT odkud, destinace, pocet_mist, datum_odletu, cas_odletu, cena, id_letenky FROM letenka WHERE odkud='$odkud' AND trida='$trida'", $link);
                         
                          $status=printTable($result);
                          
                          if(!$status)
                            header('location: login.php?notice=neplaModl'); 
                      }
                      /*Pokud bylo zadano misto odletu a misto priletu*/
                      elseif(!empty($_POST['odlet']) && !empty($_POST['prilet']) && empty($_POST['date']) && empty($_POST['date2']))
                      {                     
                        $result=mysql_query("SELECT odkud, destinace, pocet_mist, datum_odletu, cas_odletu, cena, id_letenky FROM letenka WHERE odkud='$odkud' AND destinace='$kam' AND trida='$trida'", $link);

                          $status=printTable($result);
                          
                          if(!$status)
                            header('location: login.php?notice=neplaDest'); 
                      }

                        /*Pokud uzivatel zadal misto odletu, misto priletu a datumy*/
                      elseif(!empty($_POST['odlet']) && !empty($_POST['prilet']) && !empty($_POST['date']) && !empty($_POST['date2']))
                      {
                        $dateOd=date("Y-m-d",strtotime($_POST['date']));
                        $datePri=date("Y-m-d",strtotime($_POST['date2']));
                          $result=mysql_query("SELECT odkud, destinace, pocet_mist, datum_odletu, cas_odletu, cena, id_letenky FROM letenka WHERE odkud='$odkud' 
                                              AND destinace='$kam' AND trida='$trida' AND datum_odletu BETWEEN '$dateOd' AND '$datePri'  ", $link);

                          $status=printTable($result);

                          if(!$status)
                            header('location: login.php?notice=dateNon');
                      }

                       /*Pokud uzivatel vyplnil jen jedno datum, jinak vse*/ 
                      else
                      {

                          $dateOd=date("Y-m-d",strtotime($_POST['date']));
                          $datePri="2030-12-30";
                          $datePri=date("Y-m-d",strtotime($datePri));
                          
                         $result=mysql_query("SELECT odkud, destinace, pocet_mist, datum_odletu, cas_odletu, cena, id_letenky FROM letenka WHERE odkud='$odkud' 
                                              AND destinace='$kam' AND trida='$trida' AND datum_odletu BETWEEN '$dateOd' AND '$datePri'  ", $link);
                          $status=printTable($result);

                          if(!$status)
                            header('location: login.php?notice=dateNon');

                      }
                 }

                 else{
                  header('location: login.php?notice="necojinak"');
                 }
                }

                else{
                  exit(1);
                }
              ?>
              </table>
              <input type="submit"  value="Rezervovat" name="rez_vyhled_bt">
              </form>
      </div>
    </div>

</body>
</html>
