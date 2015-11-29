
<?php
  session_start();

  require_once("editace.php");

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
      header('location: let.php?info=empty');
      exit(1);
    }

    $link=getConnectDb();
    $odkud=$_POST['odlet'];
    $destinace=$_POST['prilet'];

    if(is_numeric($_POST['kapacita']))
        $pocet_mist=$_POST['kapacita'];
    else{
        header('location: let.php?info=kapcislo');
        exit(1);
      }


    $trida=$_POST['trida'];
     if($trida!="first" && $trida!="economy" && $trida!="business")
     {
        header('location: let.php?info=badtrida');
        exit(1);
     } 

    $datum_odletu=date("Y-m-d", strtotime($_POST['date']));
    
    $cas_odletu=$_POST['cas_odl'];
    $cas_priletu=$_POST['cas_pril'];

    if(is_numeric($_POST['cena']))
       $cena=$_POST['cena'];
    else{
        header('location: let.php?info=cenacislo');
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

    header('location: let.php?info=error');
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
        <div class="infopanel" id="rez2"><br>Jste přihlášen jako <?= htmlspecialchars($_SESSION['username']) ?>
            <?php
              if($_SESSION['admin'])
                echo 'admin';
            ?>
        <br>
        <a href="login.php?odhlasit">Odhlásit</a>
         </div>
          <div id="login_pg">
            <div id="login">
              <h2>Vytvoření letu</h2>
            </div>
              <form action="let.php" method="post">
            
                <div id="typLetenky">
                  <label>Odlet z</label>
                  <input id="letenka" name="odlet" type="text"><br>
                  <label>Přílet do</label>
                  <input id="letenka" name="prilet" type="text"><br>
                  <label>Kapacita</label>
                  <input id="kapacita" name="kapacita" type="text"><br>
                  <label>Společnost</label>
                  <input id="spolecnost" name="spolecnost" type="text"><br>
                  <label>Datum</label>
                  <input id="datepicker" name="date" placeholder="Datum odletu" type="text">
                  <br>
                  <label>Čas odletu</label>
                  <input id="datepicker" name="cas_odl" type="text">
                  <label>Čas příletu</label>
                  <input id="datepicker" name="cas_pril" type="text">
                  <label>Cena</label>
                  <input id="datepicker" name="cena" type="text">
                  <label>Třída</label>
                  <input id="datepicker" name="trida" type="text">
                 
                  </div>
                  <div id="typLetenky">
                   
                    <input name="hledej" type="submit" value="Vytvořit">

                </div>
                <?php
                  if(isset($_GET['info']))
                  {
                    if($_GET['info']=="empty")
                        echo "<h3 style=\"color: red; font-weight: bold; font-size: 20px;\">Musíte vyplnit všechna políčka </h3>";
                    if($_GET['info']=="error")
                        echo "<h3 style=\"color: red; font-weight: bold; font-size: 20px;\">Nepodařilo se let zapsat do databáze</h3>";  
                    if($_GET['info']=="ok")
                        echo "<h3 style=\"color: green; font-weight: bold; font-size: 20px;\">Let vytvořen</h3>";  
                    if($_GET['info']=="kapcislo")
                        echo "<h3 style=\"color: red; font-weight: bold; font-size: 20px;\">kapacita musi byt cislo</h3>";    
                      if($_GET['info']=="cenacislo")
                        echo "<h3 style=\"color: red; font-weight: bold; font-size: 20px;\">cena musi byt cislo</h3>";    
                      if($_GET['info']=="badtrida")
                        echo "<h3 style=\"color: red; font-weight: bold; font-size: 20px;\">Spatny nazev tridy</h3>";    
                          
                  }

                ?>

                <span><?php echo $error; ?></span>
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
