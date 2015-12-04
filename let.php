
<?php
  
  ini_set("default_charset", "UTF-8"); 
  session_start();

  require_once("editace.php");

  if(!isset($_SESSION['username']))
  {
    header('location: login.php');
    exit();
  }
  if(isset($_GET['admin']))
  {
      $_SESSION['admin']=true;
  }
  if(isset($_GET['odhlasit']))
  {
    session_destroy();
    header('location: index.php');
    exit();
  }

/*Pro pamatovani udaju pri spatne vyplnenem formu*/
    if(isset($_POST['odlet']))
    	$tod=$_POST['odlet'];
  	if(isset($_POST['prilet']))
	    $tpr=$_POST['prilet'];
  	if(isset($_POST['kapacita']))
	    $tka=$_POST['kapacita'];
  	if(isset($_POST['spolecnost']))
	    $tsp=$_POST['spolecnost'];  	
	if(isset($_POST['cas_odl']))
	    $tco=$_POST['cas_odl'];
	if(isset($_POST['cas_pril']))
	    $tcp=$_POST['cas_pril'];
	if(isset($_POST['cena']))
	    $tce=$_POST['cena'];
	if(isset($_POST['trida']))
	    $ttr=$_POST['trida'];

  /******************************************/
  if(isset($_POST['hledej']))
  {
    $i=0;
    foreach ($_POST as $key) 
    {
      if(!empty($key))
      {
         $i++;
      }
    }
    
    if($i!=10)
    {
      header("location: let.php?info=empty&todv=$tod&tprv=$tpr&tkav=$tka&tspv=$tsp&tcov=$tco&tcpv=$tcp&tcev=$tce&ttrv=$ttr");
      exit(1);
    }

    $link=getConnectDb();
    $odkud=$_POST['odlet'];
    $destinace=$_POST['prilet'];

    if(is_numeric($_POST['kapacita']))
        $pocet_mist=$_POST['kapacita'];
    else{
        header("location: let.php?info=kapcislo&todv=$tod&tprv=$tpr&tkav=$tka&tspv=$tsp&tcov=$tco&tcpv=$tcp&tcev=$tce&ttrv=$ttr");
        exit(1);
      }


    $trida=$_POST['trida'];
     if($trida!="first" && $trida!="economy" && $trida!="business")
     {
        header("location: let.php?info=badtrida&todv=$tod&tprv=$tpr&tkav=$tka&tspv=$tsp&tcov=$tco&tcpv=$tcp&tcev=$tce&ttrv=$ttr");
        exit(1);
     } 

    $datum_odletu=date("Y-m-d", strtotime($_POST['date']));
    
    $cas_odletu=$_POST['cas_odl'];
    $cas_priletu=$_POST['cas_pril'];

    if(is_numeric($_POST['cena']))
       $cena=$_POST['cena'];
    else{
        header("location: let.php?info=cenacislo&todv=$tod&tprv=$tpr&tkav=$tka&tspv=$tsp&tcov=$tco&tcpv=$tcp&tcev=$tce&ttrv=$ttr");
        exit(1);
      }
    
    $spolecnost=$_POST['spolecnost'];

    $result=mysql_query("INSERT INTO letenka(odkud, destinace, pocet_mist, trida, datum_odletu, cas_odletu, cas_priletu, spolecnost, cena) 
                  VALUES ('$odkud', '$destinace','$pocet_mist','$trida', '$datum_odletu', '$cas_odletu' ,'$cas_priletu','$spolecnost','$cena')", $link);
    if($result)
    {
      header('location: let.php?info=ok');
      exit(1);
    }

    header("location: let.php?info=error&todv=$tod&tprv=$tpr&tkav=$tka&tspv=$tsp&tcov=$tco&tcpv=$tcp&tcev=$tce&ttrv=$ttr");
    exit(1);
    
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
      <h1> Rezervace letenek</h1>

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
        <div class="infopanel" id="index"><br>Jste přihlášen jako <?= htmlspecialchars($_SESSION['username']) ?>
            <?php
              if($_SESSION['admin'])
                echo 'admin';
            ?>
        <br>
        <a href="login.php?odhlasit">Odhlásit</a>
         </div>
          <div class="textField" id="rezervace2">
            <div id="login">
              <h2>Vytvoření letu</h2>
            </div>
            <?php  
            	   if(isset($_GET['todv'])) 
                 {
                  $todv=$_GET['todv'];
                  $todv=urldecode($todv);
                 }
                 if(isset($_GET['tprv'])) 
                 {
                  $tprv=$_GET['tprv'];
                  $tprv=urldecode($tprv);
                 }
                 if(isset($_GET['tkav'])) 
                 {
                  $tkav=$_GET['tkav'];
                  $tkav=urldecode($tkav);
                 }
                 if(isset($_GET['tspv'])) 
                 {
                  $tspv=$_GET['tspv'];
                  $tspv=urldecode($tspv);
                 }
                 if(isset($_GET['tcov'])) 
                 {
                  $tcov=$_GET['tcov'];
                  $tcov=urldecode($tcov);
                 }
                 if(isset($_GET['tcpv'])) 
                 {
                  $tcpv=$_GET['tcpv'];
                  $tcpv=urldecode($tcpv);
                 }
                 if(isset($_GET['tcev'])) 
                 {
                  $tcev=$_GET['tcev'];
                  $tcev=urldecode($tcev);
                 }
                 if(isset($_GET['ttrv'])) 
                 {
                  $ttrv=$_GET['ttrv'];
                  $ttrv=urldecode($ttrv);
                 }
            	
            	echo "<form action=\"let.php\" method=\"post\">
            
                <div id=\"typLetenky\">
                  <label>Odlet z</label>
                  ";
                  if(isset($todv)) 
                    echo "<input id=\"letenka\" name=\"odlet\" type=\"text\" value=\"$todv\"><br>";
                  else
                    echo "<input id=\"letenka\" name=\"odlet\" type=\"text\"><br>";
                  echo "<label>Přílet do</label>";
                  if(isset($tprv)) 
                    echo "<input id=\"letenka\" name=\"prilet\" type=\"text\" value=\"$tprv\"><br>";
                  else
                    echo "<input id=\"letenka\" name=\"prilet\" type=\"text\"><br>";
                  echo "<label>Kapacita</label>";
                  if(isset($tkav)) 
                    echo "<input id=\"kapacita\" name=\"kapacita\" type=\"text\" value=\"$tkav\"><br>";
                  else
                    echo "<input id=\"kapacita\" name=\"kapacita\" type=\"text\"><br>";
                  echo "<label>Společnost</label>";
                  if(isset($tspv)) 
                    echo "<input id=\"spolecnost\" name=\"spolecnost\" type=\"text\" value=\"$tspv\"><br>";
                  else
                    echo "<input id=\"spolecnost\" name=\"spolecnost\" type=\"text\"><br>";
                  echo "<label>Datum</label>";
                  echo "<input id=\"datepicker\" name=\"date\" placeholder=\"Datum odletu\" type=\"text\">
                  <br>
                  <label>Čas odletu</label>";
                  if(isset($tcov)) 
                    echo "<input id=\"datepicker\" name=\"cas_odl\" type=\"text\" value=\"$tcov\">";
                  else
                    echo "<input id=\"datepicker\" name=\"cas_odl\" type=\"text\">";
                  echo "<label>Čas příletu</label>";
                  if(isset($tcpv)) 
                    echo "<input id=\"datepicker\" name=\"cas_pril\" type=\"text\" value=\"$tcpv\">";
                  else
                    echo "<input id=\"datepicker\" name=\"cas_pril\" type=\"text\">";
                  echo "<label>Cena</label>";
                  if(isset($tcev)) 
                    echo "<input id=\"datepicker\" name=\"cena\" type=\"text\" value=\"$tcev\">";
                  else
                    echo "<input id=\"datepicker\" name=\"cena\" type=\"text\">";
                  echo "<label>Třída</label>";
                  if(isset($ttrv)) 
                    echo "<input id=\"datepicker\" name=\"trida\" type=\"text\" value=\"$ttrv\">";
                  else
                    echo "<input id=\"datepicker\" name=\"trida\" type=\"text\">";
                 echo "
                  </div>
                  <div id=\"typLetenky\">
                   
                    <input name=\"hledej\" type=\"submit\" value=\"Vytvořit\">

                </div>";
                ?>
                <?php
                  if(isset($_GET['info']))
                  {
                    if($_GET['info']=="empty")
                        echo "<div id=\"let\">Musíte vyplnit všechna políčka </div>";
                    if($_GET['info']=="error")
                        echo "<div id=\"let\">Nepodařilo se let zapsat do databáze</div>";  
                    if($_GET['info']=="ok")
                        echo "<div id=\"ok_let\">Let vytvořen</div>";  
                    if($_GET['info']=="kapcislo")
                        echo "<div id=\"let\">kapacita musi byt cislo</div>";    
                      if($_GET['info']=="cenacislo")
                        echo "<div id=\"let\">cena musi byt cislo</div>";    
                      if($_GET['info']=="badtrida")
                        echo "<div id=\"let\">Spatny nazev tridy</div>";    
                          
                  }

                ?>

                
              </form>
            
          </div>
              <?php  if($_SESSION['admin']) 
            {
              echo"<div id=\"tlacitko_let\">
                <form method=\"post\">
                <table class=\"edit_menu\">
                
                  <tr><td><input type=\"button\" name=\"reg_window\" value=\"Administrace\" onclick=\"location.href='admin.php'\"></td></tr>
               
                  <tr><td><input type=\"button\" name=\"reg_windows\" value=\"Registrace uživatele\" onclick=\"location.href='registrace.php'\"></td></tr>
                  
                  
                  
                  
                  </table>
                </form>
              </div>";
              }
              ?>
        </div>  
</body>
</html>
