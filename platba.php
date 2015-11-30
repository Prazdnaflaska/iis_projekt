<?php
  ini_set("default_charset", "UTF-8");
  session_start();
  require_once("editace.php");
  /*Overeni platby a vutvoreni rezervace*/
  if(isset($_POST['submit_platba']))
  {
    if(isset($_POST['platba_text']))
    {
      if(!is_numeric($_POST['platba_text']))
      {
        header('location: platba.php?transaction=neplatucet');
         exit(1); 
      }

      if(!isset($_SESSION['username']))
      {
        header('location: platba.php?transaction=nologin');
        exit(1);
      }

          
      if(!empty($_POST['id_let']))
      {
        
        $link=getConnectDB();
        $user=$_SESSION['username'];
        $result=mysql_query("SELECT id_cestujici FROM uzivatele WHERE login='$user'", $link);
        $row=mysql_fetch_row($result);
          $id_user=$row[0];
        foreach ($_POST['id_let'] as $let) 
        {
           /*Vytvoreni rezervace*/
            $result=mysql_query("INSERT INTO rezervace(`id_cestujici`, `id_letenky`, `zaplaceno`) VALUES ('$id_user','$let', 'true')", $link);
            /*snizeni poctu mist v letadle na zaklade rezervace*/
            $result=mysql_query("UPDATE `letenka` SET `pocet_mist`=`pocet_mist`-1 WHERE id_letenky='$let'");
        }

        header('location: platba.php?transaction=1');
      } 

    }

    else{
      echo "zadejte cislo uctu";
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
		<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
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
                if(isset($_SESSION['admin']))
		{  
		  if(!$_SESSION['admin'])
                      echo "<li id=\"admin\"><a href=\"mujucet.php\">Můj účet</a></li>";
		}
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
      <div id="platba_div">
        <div id="login">
       		<h2>Platba</h2>
       	</div>
        <table class="data">
            <tr class="head">
                <td>Počet letenek</td>
                <td>Cena</td>
              </tr>
                <?php 
                  require_once("editace.php");
                  if(!empty($_GET['transaction']))
                  {
                    if($_GET['transaction']==1)
                      echo "<h3 style=\"color: green\">Platba probehla</h3>";
                    if($_GET['transaction']=="nologin")
                      echo "<h3 style=\"color: red\">Musite byt prihlasen</h3>";
                    if($_GET['transaction']=="neplatucet")
                      echo "<h3 style=\"color: red\">Neplatne cislo uctu</h3>";
                  }

                    /*Pokud jeste neprobehla platba, get je prazdny*/
                else{

                  if(!empty($_POST))
                  {
                        $i=0;
                        foreach ($_POST['odlet'] as $key) 
                        {
                            $i++;
                        }
    
                  $rezervuj = $_POST['rezervuj'];
                  $cena= $_POST['cena'];
                  $id_let=$_POST['id_let'];
                  $pocet_letenek=0;
                  $id_pole = array();
		  $suma=0;
                    for($j=0; $j<$i; $j++)
                    {
                      if(isset($rezervuj[$j]))
                      {
                        $rezervuj[$j]=1;
                        $suma+=$cena[$j];
                        $id_pole[$pocet_letenek]=$id_let[$j];
                        $pocet_letenek++;

                      } 
                      else{
                        $rezervuj[$j]=0;
                      }
                    }

                    if($suma==0)
                    {
                      echo "<h3 style=\"color: red;\">Nevybral jste zadnou rezervaci</h3>";
                      echo "<input style=\"color: red; background-color: white; border: none; font-size: 18px;\" value=\"zpet\" name=\"cancel\" type=\"button\" onclick=\"location.href='index.php'\">";
                    }
                  }

            else
              echo "chyba";
                  
                  /*Vypis informaci o platbe*/
                  echo "<br>";
                  echo "<tr>";
                  echo "<td>$pocet_letenek </td>";
                    echo "<td>$suma </td>";

                    echo "</tr>\n";
            }    
              ?>
              </table>
              <div id="platba">
              <label>Číslo účtu</label>
              <form method="post">
              <?php
                   if(isset($pocet_letenek))
		   {	 
                    for ($k=0; $k < $pocet_letenek; $k++) 
                    { 
                        echo "<input type=\"hidden\" id=\"id_let[$k]\" name=\"id_let[$k]\" value=\"$id_pole[$k]\">";
                    } 
                   }     
              
              ?>
                  <input id="plat" name="platba_text" type="text">
                  <input value="Zaplatit" name="submit_platba" type="submit">
                    <input value="Zrušit" name="cancel" type="button" onclick="location.href='index.php'">
              </div>

      </div>

    </div>

</body>
</html>
