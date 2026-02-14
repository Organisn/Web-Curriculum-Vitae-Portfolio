<!DOCTYPE html>
<html>
	<head>
		<title>Verifiche e conferme</title>
		<?php
			function validation($data) {
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}

			use PHPMailer\PHPMailer\PHPMailer;
			use PHPMailer\PHPMailer\Exception;
		?>
	</head>
	<body>
		<?php
			
			$ea = $_POST['indirizzoe'];

			$n = $_POST['nome'];

			$c = $_POST['cognome'];
			
			$p = $_POST['prefisso'];

			if (isset($_POST['indirizzot'])) $tn = $_POST['indirizzot'];

			if (isset($_POST['messaggio'])) $m = $_POST['messaggio'];

			$n = validation($n);

			$c = validation($c);

			$ea = validation($ea);

			if (!preg_match("/^[a-zA-Z]*$/", $n) || !preg_match("/^[a-zA-Z]*$/", $c) || !filter_var($ea, FILTER_VALIDATE_EMAIL)) {
				print("I campi 'Nome' e 'Cognome' ammettono l'immissione di sole lettere e spaziature, mentre 'Email' deve presentare i caratteri '@' e '.'.<br><br>
					<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\">");
				if(!preg_match("/^[a-zA-Z]*$/", $n) && !preg_match("/^[a-zA-Z]*$/", $c) && !filter_var($ea, FILTER_VALIDATE_EMAIL)) print("Nome, dopo la generosa raffinazione <input type=\"text\" name=\"nome\" required><br><br>Cognome, dopo la generosa raffinazione <input type=\"text\" name=\"cognome\" required><br><br>Email, dopo la generosa raffinazione <input type=\"mail\" name=\"indirizzoe\" required><br><br>");

				elseif (!preg_match("/^[a-zA-Z]*$/", $c) && !filter_var($ea, FILTER_VALIDATE_EMAIL)) print("Cognome, dopo la generosa raffinazione <input type=\"text\" name=\"cognome\" required><br><br>Email, dopo la generosa raffinazione <input type=\"mail\" name=\"indirizzoe\" required><br><br><input type=\"hidden\" name=\"nome\" value=\"".$n."\">");

				elseif (!preg_match("/^[a-zA-Z]*$/", $n) && !filter_var($ea, FILTER_VALIDATE_EMAIL)) print("<input type=\"hidden\" name=\"cognome\" value=\"".$c."\">Nome, dopo la generosa raffinazione <input type=\"text\" name=\"nome\" required><br><br>Email, dopo la generosa raffinazione <input type=\"mail\" name=\"indirizzoe\" required><br><br>");

				elseif (!preg_match("/^[a-zA-Z]*$/", $n) && !preg_match("/^[a-zA-Z]*$/", $c)) print("Nome, dopo la generosa raffinazione <input type=\"text\" name=\"nome\" required><br><br>Cognome, dopo la generosa raffinazione <input type=\"text\" name=\"cognome\" required><br><br><input type=\"hidden\" name=\"indirizzoe\" value=\"".$ea."\">");
				
				elseif (!preg_match("/^[a-zA-Z]*$/", $n)) print("Nome, dopo la generosa raffinazione <input type=\"text\" name=\"nome\" required>
					<input type=\"hidden\" name=\"cognome\" value=\"".$c."\">
					<input type=\"hidden\" name=\"indirizzoe\" value=\"".$ea."\">
					<br><br>");

				elseif (!preg_match("/^[a-zA-Z]*$/", $c)) print("Cognome, dopo la generosa raffinazione <input type=\"text\" name=\"cognome\" required>
					<input type=\"hidden\" name=\"nome\" value=\"".$n."\">
					<input type=\"hidden\" name=\"indirizzoe\" value=\"".$ea."\">
					<br><br>");
				
				else print("Email, dopo la generosa raffinazione <input type=\"mail\" name=\"indirizzoe\" required>
					<input type=\"hidden\" name=\"cognome\" value=\"".$c."\">
					<input type=\"hidden\" name=\"nome\" value=\"".$n."\"><br><br>");

				if (isset($tn)) print("<input type=\"hidden\" name=\"indirizzot\" value=\"".$tn."\">");

				if (isset($m) && !empty($m)) print("<input type=\"hidden\" name=\"messaggio\" value=\"".$m."\">");

				print("<input type=\"hidden\" name=\"prefisso\" value=\"".$p."\">
					<input type=\"submit\" value=\"Correzione\">
					</form>");
			} else {

				$fn = "".$n." ".$c."";

				$text_admin = "Informazioni dal form:\n - full name: ".$fn.";\n - email address: ".$ea."";

				$text_user = "Prezioso/a ".$fn.", la sua domanda non verrà ignorata.";

				if (isset($tn)) {
					$tn = "".$p."".$tn."";
					$text_admin = "".$text_admin.";\n - telephone number: ".$tn."";
				}

				include 'config\\credentials.php';

				if (isset($m) && !empty($m))
					$text_admin = "".$text_admin.";\n - the message: ".$m.""; 
					
				$un = "".$n.".".$c."";
				
				$pw = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 6);

				$conn = mysqli_connect($db_host, $db_username, $db_password, $db);
		
				if (!$conn) die("L'Archivio ti sta rigettando, verifica le credenziali per l'accesso. L'errore: ".mysqli_connect_error());

				$sqlea = "SELECT indirizzoEmail FROM utenti";

				$resultea = mysqli_query($conn, $sqlea);

				if (!$resultea) die("Error: ".$sqlea."<br>".mysqli_error($conn)."");

				while ($row = mysqli_fetch_assoc($resultea))
					if ($ea == $row["indirizzoEmail"]) 
						die("A questo indirizzo email &egrave; stato intestato un altro account, precedentemente registrato.
						<br><br>Le credenziali sono ancora riesumabili dalla casella di posta.
						<br><br>Altri contenuti misteriosi sono rinvenibili nella <a href=\"index.php\">home page</a>..<br><br>");

				$sql = "INSERT INTO utenti (nome, cognome,  indirizzoEmail, indirizzoTelefonico, password) VALUES ('$n', '$c', '$ea', '$tn', '$pw')";

				if (!mysqli_query($conn, $sql)) die("Error: ".$sql."<br>".mysqli_error($conn)."");

				mysqli_close($conn);
						
				$text_user = "".$text_user."\nNel frattempo, le chiavi del Segreto Archivio sono nelle sue mani...\n - Username: ".$un."\n - Password: ".$pw."";

				require 'PHPMailer\Exception.php';
				require 'PHPMailer\PHPMailer.php';
				require 'PHPMailer\SMTP.php';

				$mail_to_admin = new PHPMailer;
				$mail_to_admin -> isSMTP();
				$mail_to_admin -> SMTPDebug = 0; // Set as '2' to show detailed client-server communication events on browser
				$mail_to_admin -> SMTPAuth = true;
				$mail_to_admin -> SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
				$mail_to_admin -> Host = 'smtp.gmail.com';
				$mail_to_admin -> Port = 587;
				$mail_to_admin -> Username = $mail_account_username;
				$mail_to_admin -> Password = $mail_account_password;
				$mail_to_admin -> CharSet = 'utf-8';
				$mail_to_admin -> setFrom($mail_to_admin -> Username, 'Contact Form');
				$mail_to_admin -> addAddress($mail_to_admin -> Username, 'Dear Administrator');
				$mail_to_admin -> Subject = 'Profilo nuova utenza';
				$mail_to_admin -> Body = "".$text_admin."";
		
				if (!$mail_to_admin -> send()) print("Mailer Error: ".$mail_to_admin->ErrorInfo."");
				else {
					$mail_to_user = new PHPMailer; 
					$mail_to_user -> isSMTP();
					$mail_to_user -> SMTPDebug = 0;
					$mail_to_user -> SMTPAuth = true;
					$mail_to_user -> SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
					$mail_to_user -> Host = 'smtp.gmail.com';
					$mail_to_user -> Port = 587;
					$mail_to_user -> Username = $mail_account_username;
					$mail_to_user -> Password = $mail_account_password;
					$mail_to_user -> CharSet = 'utf-8';
					$mail_to_user -> setFrom($mail_to_user -> Username, 'Contact Form');
					$mail_to_user -> addAddress($ea, $fn);
					$mail_to_user -> Subject = 'Accoglienza';
					$mail_to_user -> Body = "".$text_user."";

					if (!$mail_to_user -> send()) print("Mailer Error: ".$mail_to_user->ErrorInfo."");
					else print("La risposta la attende nella sua casella di posta.<br><br>
						Altri contenuti misteriosi sono rinvenibili nella <a href=\"index.php\">home page</a>..<br><br>
						<fieldset>
						<legend>..Come questa immediata possibilit&agrave; 
						di varcare i cancelli del S.A. con quanto appena ricevuto.</legend>
						<form action=\"reserved.php\" method=\"POST\">
						Username<br><br><input type=\"text\" name=\"user\" required><br><br>
						Password<br><br><input type=\"password\" name=\"pass\" required><br><br>
						<input type=\"submit\" value=\"Accesso\">
						</form>
						</fieldset>");
				}
			}
		?>
	</body>
</html>