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
        	<div id="textField">
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
       							<input name="hledej" type="submit" value="Vyhledat">

       					</div>



       					<span><?php echo $error; ?></span>
       				</form>
       			

        	</div>
        	<div id="loginform">
        	<div id="login">	
        	<h2>Login</h2>
        	</div>
				<form action="" method="post">
						<input id="name" name="username" placeholder="E-mail" type="text">
						<input id="password" name="password" placeholder="Heslo" type="password">
						<input name="submit" type="submit" value=" Přihlásit ">
						<span><?php echo $error; ?></span>
				</form>
        </div>
        </div>	
</body>
</html>
