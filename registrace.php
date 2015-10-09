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
                <li id="news"><a href="#news">Akce</a></li>
              
                <li id="services"><a href="registrace.php">Registrace</a></li>
            </ul>
        </nav>
        </div>
        <div id="pageField">
            <div id="reg_form">
                <div id="login">
                    <h2>Registrace</h2>
                </div>
                <div id="jmeno_prij">
                <input id="jmeno" name="jmeno" placeholder="Jméno" type="text">
                <input id="prijmeni" name="prijmeni" placeholder="Příjmení" type="text">
                 <input id="add" name="add" placeholder="Adresa" type="text">
                 <input id="tel" name="tel" placeholder="Telefon" type="text">

                <input id="mail" name="mail" placeholder="E-mail" type="text">
                </div>
                <div id="jmeno_prij">
                <input id="pass_reg" name="pass_reg" placeholder="Heslo" type="password">
                <input id="pass_reg2" name="pass_reg2" placeholder="Kontrla hesla" type="password">


            <input name="submit_reg" type="submit_reg" value=" Přihlásit ">
                </div>
                

            </div>
        </div>

</body>
</html>
