<!DOCTYPE html>
<html>
<link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Orbitron' rel='stylesheet' type='text/css'>
<head>
	<title>Rezervace letenek</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
		<div id="header">
		<h1>Rezervace letenek</h1>
		</div>
		<div id="menu">
		 <nav>
            <ul class="fancyNav">
                <li id="home"><a href="index.php">Úvod</a></li>
                <li id="news"><a href="#news">Rezervace</a></li>
                <li id="about"><a href="login.php">Login</a></li>
                <li id="services"><a href="#services">Registrace</a></li>
            </ul>
        </nav>
        </div>
        <div id="loginform">
        	<div id="login">	
        	<h2>Login</h2>
        	</div>
				<form action="" method="post">
						<input id="name" name="username" placeholder="Login" type="text">
						<input id="password" name="password" placeholder="Heslo" type="password">
						<input name="submit" type="submit" value=" Přihlásit ">
						<span><?php echo $error; ?></span>
				</form>
        </div>


		

	
</body>
</html>
