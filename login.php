
<?php
  ini_set("default_charset", "UTF-8");
  session_start();
  if(!isset($_SESSION['username']))
  {
    header('location: login.php');
    exit();
  }
  if(isset($_GET['admin']))
  {
	if($_GET['admin']==1)
	{	
	      $_SESSION['admin']=true;
	}
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
                <li id="news"><a href="destinace.php">Kam létáme</a></li>
                <?php 
                    if(isset($_SESSION['admin']))
                      echo "<li id=\"admin\"><a href=\"admin.php\">Administrace</a></li>";
                    else
                       echo "<li id=\"admin\"><a href=\"mujucet.php\">Můj účet</a></li>";
                ?>
                <li id="services"><a href="registrace.php">Registrace</a></li>
            </ul>
        </nav>
        </div>

        
        <div id="pageField">
        <div class="infopanel" id="index"><br>Jste přihlášen jako <?= htmlspecialchars($_SESSION['username']) ?>
            <?php
		if(isset($_SESSION['admin']))
		{	
	              if($_SESSION['admin']==true)
        	        echo 'admin';
		}
            ?>
        <br>
        <a href="login.php?odhlasit">Odhlásit</a>
         </div>
          <div class="textField" id="rezervace2">
            <div id="login">
              <h2>Rezervace letenek</h2>
            </div>
              
              <form action="rez_vyhled.php" method="post">

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
                    
                    <input type="radio" name="class" value="first" class="radio" <?php if (isset($_POST['class']) && $_POST['class'] == 'first'): ?>checked='checked'<?php endif; ?> /> First
                    <input type="radio" name="class" value="business"  class="radio" <?php if (isset($_POST['class']) && $_POST['class'] ==  'business'): ?>checked='checked'<?php endif; ?> /> Business
                    <input type="radio" name="class" value="economy"  class="radio" <?php if (isset($_POST['class']) && $_POST['class'] ==  'economy'): ?>checked='checked'<?php endif; ?> /> Economy
                   
                    <input name="hledej" type="submit" value="Vyhledat">

                </div>

                <?php

                  if(isset($_GET['notice']))
                  {

                    switch ($_GET['notice']) {
                      case "mistoOdletu":
                        echo "<div id=\"vyhled\">Zadejte misto odletu !!!</div>";
                        break;
                      case "neplaModl":
                          echo "<div id=\"vyhled\">Misto odletu nenalezeno !!!</div>";
                          break;
                      case "neplaDest":
                          echo "<div id=\"vyhled\">Destinace nebyla nalezena !!!</div>";
                          break;  
                      case 'dateNon':                      
                        echo "<div id=\"vyhled\">Zadny let v tomto datu !!!</div>"; 
                        break;
                      
                      default:
                        echo "<div id=\"vyhled\">Zkontrolujte zda jste spravne vyplnili formular !!!</div>";
                        
                        break;
                    }
                    
                  }
                ?>


              </form>
            
          </div>
        </div>  
</body>
</html>
