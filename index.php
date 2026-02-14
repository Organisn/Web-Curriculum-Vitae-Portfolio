<!DOCTYPE html>
<html>
	<head>
		<title>Front page</title>
		<style type="text/css">

			body {
				background-color: lightgrey;
				margin: auto;
				width: 80%;
				margin-bottom: 30px;
				margin-top: 10px;
			}

			div.h1 {
				text-align: center;
				padding: 10px;
				border-bottom: solid 5px black;
				margin-top: 20px;
				margin-bottom: 20px;
			}

			h1 {
				font-family: "Courier New", monospace;
				font-variant: bold;
				color: black ;
			}

			div.heroes {
				display: flex;
				justify-content: space-around;
				align-items: center;
				padding-bottom: 20px;
				border-bottom: solid 4px black;
			}

			img {
				border: solid 2px white;
				width: 30%;
				height: 200px;
			}

			div.skill {
				width: 20%;
				height: 80%;
				background-color: #9b9696;
				display: flex;
  				flex-direction: column;
				align-items: center;
				padding-top: 10px;
				padding-bottom: 25px;
				border: solid 2px white;
			}

			div.experience{
				width: 20%;
				height: 80%;
				background-color: #969b96;
				display: flex;
  				flex-direction: column;
				align-items: center;
				padding-top: 10px;
				padding-bottom: 25px;
				border: solid 2px white;
			}

			div.input {
				display: block;
				margin-bottom: 3px; 
			}

			input {
				display: inline;
			}

			input.prefix {
				width: 4%;
			}

			h3.white {
				color: white;
				margin-bottom: 3px;
			}

			fieldset.first {
				display: block;
				width: 50%;
				margin: auto;
			}

			ul {
				margin-right: 10%;
			}

			li {
				margin-bottom: 2px;
				color: white;
				text-align: left;
			}

		</style>
	</head>
	<body>
		<div class="h1">
			<h1>HIS ONLINE CURRICULUM VITAE</h1>
		</div>
		<div class="heroes">
			<div class="skill">
				<h3 class="white">Skills</h3>
				<ul>
					<li>Sensibilit&agrave;</li>
					<li>Discrezione</li>
					<li>Eloquienza</li>
				</ul>
			</div>
			<img src="assets\myPic.jfif">
			<div class="experience">
				<h3 class="white">Experiences</h3>
				<ul>
					<li>Multiple discipline sportive</li>
					<li>Scoutismo</li>
					<li>Hard school team work</li>
				</ul>
			</div>
		</div>
		<fieldset class="first">
			<legend>
				<h3>La sua via di registrazione al Segreto Archivio</h3>
			</legend>
			<form action="shipment.php" method="POST">
				<div class="input">Nome<br>
					<input type="text" name="nome" required>
				</div>
				<div class="input">Cognome<br>
					<input type="text" name="cognome" required>
				</div>
				<div class="input">Telefono<br>
					<input class="prefix" type="text" name="prefisso" value="+39"> 
					<input type="number" name="indirizzot" size="10">
				</div>
				<div class="input">Email<br>
					<input type="email" name="indirizzoe" required>
				</div>
				<div class="input">Messaggio<br>
					<textarea name="messaggio"></textarea>
				</div>
				<div class="input">
					<br>Approvazione del metodo di trattamento dei dati personali <input type="radio" name="conferma" required> 
					<input type="button" onclick="alert('Human Rights Respected')" value="Informativa">
				</div>
				<div class="input">
					<br><input type="submit" value="Contatto">
				</div>
			</form>
		</fielset>
		<fieldset>
			<legend>
				<h3>La sua via di accesso al Segreto Archivio</h3>
			</legend>
			<form action="reserved.php" method="POST">
				<?php

					if (session_status() === PHP_SESSION_NONE) session_start();

					if (isset($_SESSION['pass'])) {

						$pass=$_SESSION['pass'];
						$user=$_SESSION['user'];

						print("<input type=\"hidden\" name=\"pass\" value=\"".$pass."\">
							<input type=\"hidden\" name=\"user\" value=\"".$user."\">");

					} else print("<div class=\"input\">Username<br><br><input type=\"text\" name=\"user\" required></div><br>
							<div class=\"input\">Password<br><br><input type=\"password\" name=\"pass\" required></div><br>");
							
				?>
				<div class="input">
					<input type="submit" value="Log in">
				</div>
			</form>
		</fieldset>
	</body>
</html>