<!DOCTYPE html>
<html>
	<head>
		<title>Archivio Segreto</title>
	</head>
	<body>
		<?php

			include 'config\\credentials.php';

			$conn = mysqli_connect($db_host, $db_username, $db_password, $db);

			$user = $_POST['user'];

			$pass = $_POST['pass'];

			if (isset($_POST['pfileeliminazione'])) {

				session_start();

				$pfileeliminazione = $_POST['pfileeliminazione'];

				$sql_count = "SELECT COUNT(*) FROM documenti";
				$result_count = mysqli_query($conn, $sql_count);
				if (!$result_count) die("Error: ".$sql_count."<br>".mysqli_error($conn)."");
				$result_count = mysqli_fetch_row($result_count)[0]; // Il conteggio si trova all'indice 0

				// Check if there are any documents in the database
				if ($result_count > 0) {

					$sql_drop = "SELECT COUNT(*) AS totale FROM documenti WHERE indirizzo = '$pfileeliminazione'"; // (alternativa ALIAS)
					$result_drop = mysqli_query($conn, $sql_drop);
					if (!$result_drop) die("Error: ".$sql_drop."<br>".mysqli_error($conn)."");
					$result_drop = mysqli_fetch_assoc($result_drop)['totale']; // Il conteggio si trova nella chiave 'totale'

					// Check if the desired document to be deleted exists before attempting to delete
					if ($result_drop > 0) {

						$sql_drop = "DELETE FROM documenti WHERE indirizzo = '$pfileeliminazione'";
						$result_drop = mysqli_query($conn, $sql_drop);
						if (!$result_drop) die("Error: ".$sql_drop."<br>".mysqli_error($conn)."");

						// mysqli_query($conn, $result_drop);

						print("Nulla ha ostacolato i nostri comuni interessi.
						<br>La prossima scelta:<br><br><fieldset><legend>Cancellare..</legend>
						<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\">
						<input type=\"hidden\" name=\"pass\" value=\"".$pass."\">
						<input type=\"hidden\" name=\"user\" value=\"".$user."\">
						<input type=\"text\" name=\"pfileeliminazione\" maxlenght=\"255\" required><br><br>
						<input type=\"submit\" value=\"Another\">
						</form>
						</fieldset><br><br>
						<fieldset>
						<legend>.. Oppure scrivere.</legend>
						<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\">
						<input type=\"hidden\" name=\"pass\" value=\"".$pass."\">
						<input type=\"hidden\" name=\"user\" value=\"".$user."\">
						Il nome <input type=\"text\" name=\"nfile\" maxlenght=\"255\" required><br><br>
						La descrizione <input type=\"text\" name=\"dfile\" maxlenght=\"255\" required><br><br>
						Il percorso <input type=\"text\" name=\"pfile\" maxlenght=\"255\" required><br><br>
						<input type=\"submit\" value=\"Other\">
						</form>
						</fieldset><br><br>");

						$sql = "SELECT nome, descrizione, indirizzo FROM documenti";

						$result = mysqli_query($conn, $sql);

						if (!$result) die("Error: ".$sql."<br>".mysqli_error($conn)."");

						print("<fieldset>
						<legend>
						<h2>Consulti i pi&ugrave; arcaici codici, come ha sempre sognato.</h2></legend>");

						if (mysqli_num_rows($result) > 0)
							while ($row = mysqli_fetch_assoc($result)) 
								print("<a href=\"".$row["indirizzo"]."\">".$row["nome"]."</a> 
								<input type=\"button\" value=\"Descrizione\" onclick=\"alert('".$row["descrizione"]."')\"><br><br>");
						else print("<i>L'Archivio &egrave; ancora vuoto, ma non si scoraggi: &egrave; un ottimo momento per iniziare a popolarlo!</i>");

						print("</fieldset>");

					} else {
						print("E' verosimile che l'indirizzo inviato fosse imperfetto, 
						ma non si può neanche escludere che il documento indicato sia inesistente all'interno dell'Archivio<br><br>
						<fieldset>
						<legend>Delezione..</legend>
						<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\">
						<input type=\"hidden\" name=\"pass\" value=\"".$pass."\">
						<input type=\"hidden\" name=\"user\" value=\"".$user."\">
						<input type=\"text\" name=\"pfileeliminazione\" maxlenght=\"255\" required><br><br>
						<input type=\"submit\" value=\"Retry\">
						</form>
						</fieldset><br><br>
						<fieldset>
						<legend>.. O inserimento ?</legend>
						<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\">
						<input type=\"hidden\" name=\"pass\" value=\"".$pass."\">
						<input type=\"hidden\" name=\"user\" value=\"".$user."\">
						Il nome <input type=\"text\" name=\"nfile\" maxlenght=\"255\" required><br><br>
						La descrizione <input type=\"text\" name=\"dfile\" maxlenght=\"255\" required><br><br>
						Il percorso <input type=\"text\" name=\"pfile\" maxlenght=\"255\" required><br><br>
						<input type=\"submit\" value=\"Add\">
						</form>
						</fieldset>");

						$sql = "SELECT nome, descrizione, indirizzo FROM documenti";

						$result = mysqli_query($conn, $sql);

						if (!$result) die("Error: ".$sql."<br>".mysqli_error($conn)."");

						print("<fieldset>
						<legend>
						<h2>Consulti i pi&ugrave; arcaici codici, come ha sempre sognato.</h2>
						</legend>");

						if (mysqli_num_rows($result) > 0)
							while ($row = mysqli_fetch_assoc($result))
								print("<a href=\"".$row["indirizzo"]."\">".$row["nome"]."</a> 
								<input type=\"button\" value=\"Descrizione\" onclick=\"alert('".$row["descrizione"]."')\"><br><br>");
						else print("<i>L'Archivio &egrave; ancora vuoto, ma non si scoraggi: &egrave; un ottimo momento per iniziare a popolarlo!</i>");

						print("</fieldset>");
					}
				} else print("<fieldset>
						<legend>Popoli gli scaffali..</legend>
						<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\">
						<input type=\"hidden\" name=\"pass\" value=\"".$pass."\">
						<input type=\"hidden\" name=\"user\" value=\"".$user."\">
						Il nome che assegna al documento <input type=\"text\" name=\"nfile\" maxlenght=\"255\" required><br><br>
						Una descrizione approssimativa del contenuto <input type=\"text\" name=\"dfile\" maxlenght=\"255\" required><br><br>
						Con accuratezza insuperabile, il percorso da compiere per trovarlo <input type=\"text\" name=\"pfile\" maxlenght=\"255\" required><br><br>
						<input type=\"submit\" value=\"Upload\">
						</form>
						</fieldset>");

				print("<br><fieldset>
				<legend>La sua via di disconnessione</legend>
				<a href=\"index.php\">
				<input type=\"button\" value=\"Log out\" onclick=\"".session_destroy()."\">
				</a>
				</fieldset>");

			} elseif (isset($_POST['nfile'])) {

				session_start();

				$nfile = $_POST['nfile'];
				$dfile = $_POST['dfile'];
				$pfile = $_POST['pfile'];

				$sql_file = "SELECT COUNT(*) AS totale FROM documenti WHERE indirizzo = '$pfile'";
				$result_file = mysqli_query($conn, $sql_file);
				if (!$result_file) die("Error: ".$sql_file."<br>".mysqli_error($conn)."");
				$result_file = mysqli_fetch_assoc($result_file)['totale'];

				// Check if there are any duplicates in the database
				if ($result_file > 0) {

					print("<h3>L'Archivio non ammette duplicati.</h3><br>
						<fieldset>
						<legend>Pu&ograve; riformulare la richiesta o elaborarne una nuova.</legend>
						<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\">
						<input type=\"hidden\" name=\"pass\" value=\"".$pass."\">
						<input type=\"hidden\" name=\"user\" value=\"".$user."\">
						Il nome che gli assegna<input type=\"text\" name=\"nfile\" maxlenght=\"255\" required><br><br>
						Una descrizione approssimativa del contenuto<input type=\"text\" name=\"dfile\" maxlenght=\"255\" required><br><br>
						Con accuratezza insuperabile, il percorso da compiere per trovarlo<input type=\"text\" name=\"pfile\" maxlenght=\"255\" required><br><br>
						<input type=\"submit\" value=\"Re-Upload\">
						</form>
						</fieldset><br><br>
						<fieldset>
						<legend>Nonch&egrave; effettuare eliminazioni.</legend>
						<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\">
						<input type=\"hidden\" name=\"pass\" value=\"".$pass."\">
						<input type=\"hidden\" name=\"user\" value=\"".$user."\">
						<input type=\"text\" name=\"pfileeliminazione\" maxlenght=\"255\" required><br><br>
						<input type=\"submit\" value=\"Eliminate\">
						</form>
						</fieldset><br><br>");

					$sql = "SELECT nome, descrizione, indirizzo FROM documenti";

					$result = mysqli_query($conn, $sql);

					if (!$result) die("Error: ".$sql."<br>".mysqli_error($conn)."");

					print("<fieldset>
					<legend>
					<h2>Consulti i pi&ugrave; arcaici codici, come ha sempre sognato.</h2>
					</legend>");

					if (mysqli_num_rows($result) > 0)
						while ($row = mysqli_fetch_assoc($result))
							print("<a href=\"".$row["indirizzo"]."\">".$row["nome"]."</a> 
							<input type=\"button\" value=\"Descrizione\" onclick=\"alert('".$row["descrizione"]."')\"><br><br>");
					else print("<i>L'Archivio &egrave; ancora vuoto, ma non si scoraggi: &egrave; un ottimo momento per iniziare a popolarlo!</i>");

					print("</fieldset>");

				} else {

					mysqli_query($conn, "INSERT INTO documenti (nome, descrizione, indirizzo) VALUES ('$nfile', '$dfile', '$pfile')");

					$sql = "SELECT nome, descrizione, indirizzo FROM documenti";

					$result = mysqli_query($conn, $sql);

					if (!$result) die("Error: ".$sql."<br>".mysqli_error($conn)."");

					print("<fieldset>
					<legend>
					<h2>Consulti i pi&ugrave; arcaici codici, come ha sempre sognato.</h2>
					</legend>");

					if (mysqli_num_rows($result) > 0)
						while ($row = mysqli_fetch_assoc($result)) 
							print("<a href=\"".$row["indirizzo"]."\">".$row["nome"]."</a> 
							<input type=\"button\" value=\"Descrizione\" onclick=\"alert('".$row["descrizione"]."')\"><br><br>");
					else print("<i>L'Archivio &egrave; ancora vuoto, ma non si scoraggi: &egrave; un ottimo momento per iniziare a popolarlo!</i>");

					print("</fieldset>");
				
					print("<fieldset>
					<legend>Amplii la raccolta all'infinito..</legend>
					<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\">
					<input type=\"hidden\" name=\"pass\" value=\"".$pass."\">
					<input type=\"hidden\" name=\"user\" value=\"".$user."\">
					Il nome che gli assegni<input type=\"text\" name=\"nfile\" maxlenght=\"255\" required><br><br>
					Una descrizione approssimativa del contenuto<input type=\"text\" name=\"dfile\" maxlenght=\"255\" required><br><br>
					Con accuratezza insuperabile, il percorso da compiere per trovarlo<input type=\"text\" name=\"pfile\" maxlenght=\"255\" required><br><br>
					<input type=\"submit\" value=\"Upload\">
					</form>
					</fieldset><br><br>
					<fieldset>
					<legend>.. La riduca all'infinitesimo..</legend>
					<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\">
					<input type=\"hidden\" name=\"pass\" value=\"".$pass."\">
					<input type=\"hidden\" name=\"user\" value=\"".$user."\">
					<input type=\"text\" name=\"pfileeliminazione\" maxlenght=\"255\" required><br><br>
					<input type=\"submit\" value=\"Eliminate\">
					</form>
					</fieldset>");
				}

				print("<br><fieldset>
				<legend>La sua via di disconnessione</legend>
				<a href=\"index.php\">
				<input type=\"button\" value=\"Log out\" onclick=\"".session_destroy()."\">
				</a>
				</fieldset>");
				
			} else { // First access to the reserved area, before any upload or deletion operations

				$sql = "SELECT COUNT(*) AS totale FROM utenti WHERE nome = SUBSTRING_INDEX('$user', '.', 1) AND cognome = SUBSTRING_INDEX('$user', '.', -1)";
				$result = mysqli_query($conn, $sql);		
				if (!$result) die("Error: ".$sql."<br>".mysqli_error($conn)."");
				$result = mysqli_fetch_assoc($result)['totale'];

				// Check if there are any users in the database with the provided username (the password will be checked later)
				if ($result > 0) {

					$sql_pw = "SELECT COUNT(*) AS totale FROM utenti WHERE nome = SUBSTRING_INDEX('$user', '.', 1) AND cognome = SUBSTRING_INDEX('$user', '.', -1) AND password = '$pass'";
					$result_pw = mysqli_query($conn, $sql_pw);		
					if (!$result_pw) die("Error: ".$sql_pw."<br>".mysqli_error($conn)."");
					$result_pw = mysqli_fetch_assoc($result_pw)['totale'];

					// Check if the provided password matches the username
					if ($result_pw > 0) {

						if (session_status() === PHP_SESSION_NONE) session_start();
						
						$_SESSION['user'] = $user;

						$_SESSION['pass'] = $pass;

						$sql_display = "SELECT nome, descrizione, indirizzo FROM documenti";
						$result_display = mysqli_query($conn, $sql_display);
						if (!$result_display) die("Error: ".$sql_display."<br>".mysqli_error($conn)."");

						print("<fieldset>
						<legend>
						<h2>Consulti i pi&ugrave; arcaici codici, come ha sempre sognato.</h2>
						</legend>");

						if (mysqli_num_rows($result_display) > 0)
							while ($row_display = mysqli_fetch_assoc($result_display))
								print("<a href=\"".$row_display["indirizzo"]."\">".$row_display["nome"]."</a>  
								<input type=\"button\" value=\"Descrizione\" onclick=\"alert('".$row_display["descrizione"]."')\"><br><br>");
						else print("<i>L'Archivio &egrave; ancora vuoto, ma non si scoraggi: &egrave; un ottimo momento per iniziare a popolarlo!</i>");

						// Check if the logged-in user is the administrator
						// to let him/her perform management operations on the document collection, 
						// such as adding or removing items
						$sql_mail = "SELECT indirizzoEmail FROM utenti WHERE nome = SUBSTRING_INDEX('$user', '.', 1) AND cognome = SUBSTRING_INDEX('$user', '.', -1) AND password = '$pass'";
						$result_mail = mysqli_query($conn, $sql_mail);		
						if (!$result_mail) die("Error: ".$sql_mail."<br>".mysqli_error($conn)."");
						$result_mail = mysqli_fetch_assoc($result_mail)['indirizzoEmail'];

						if ($result_mail == $mail_account_username) print("<h3>Gli amministratori come lei 
							non dovrebbero esitare qualora gli saltasse in mente di ampliare o ridurre la raccolta.</h3><br>
							<fieldset>
							<legend>Per l'aggiunta di documenti, &egrave; sufficiente compilare questo FORM.</legend>
							<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\">
							<input type=\"hidden\" name=\"pass\" value=\"".$pass."\">
							<input type=\"hidden\" name=\"user\" value=\"".$user."\">
							Il nome che gli assegna <input type=\"text\" name=\"nfile\" maxlenght=\"255\" required><br><br>
							Una descrizione approssimativa del contenuto <input type=\"text\" name=\"dfile\" maxlenght=\"255\" required><br><br>
							Con accuratezza impeccabile, il percorso da compiere per trovarlo 
							(cortesemente, anteponga gli escape character a eventuali backslash nel percorso) 
							<input type=\"text\" name=\"pfile\" maxlenght=\"255\" required><br><br>
							<input type=\"submit\" value=\"Upload\">
							</form>
							</fieldset><br><br>
							<fieldset>
							<legend>Per la rimozione, questo.</legend>
							<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\">
							<input type=\"hidden\" name=\"pass\" value=\"".$pass."\">
							<input type=\"hidden\" name=\"user\" value=\"".$user."\">
							Con le stesse dinamiche presenti allo stesso campo, nel FORM precedente, 
							tutto il percorso necessario <input type=\"text\" name=\"pfileeliminazione\" maxlenght=\"255\" required><br><br>
							<input type=\"submit\" value=\"Cancel\">
							</form>
							</fieldset>");
	
						print("</fieldset><br>
							<fieldset>
							<legend>La sua via di disconnessione</legend>
							<a href=\"index.php\">
							<input type=\"button\" value=\"Log out\" onclick=\"".session_destroy()."\">
							</a>
							</fieldset>");

					} else print("<fieldset>
							<legend>L'invito &egrave; di rivisitare la mail contenente le pi&ugrave; 
							ragionevoli credenziali per un accesso pi&ugrave; efficace..</legend>
							<form action\"".$_SERVER['PHP_SELF']."\" method=\"POST\">
							Username<br><br><input type=\"text\" name=\"user\" required><br><br>
							Password<br><br><input type=\"password\" name=\"pass\" required><br><br>
							<input type=\"submit\" value=\"Reintroduci\">
							</form>
							</fieldset><br><br>");

				} else print("Prima ancora di procedere con le operazioni di log-in, &egrave; 
					opportuno registrare il proprio profilo.<br><br>	
					L'opzione &egrave; disponibile nella <a href=\"index.php\">home page</a>.");
			}

			mysqli_close($conn);

		?>
	</body>
</html>