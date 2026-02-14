# (Italian) overview
## [index.php](/index.php)
La prima visualizzata è la home page del sito. Al primo avvio vengono stampati i contenuti che costituiscono il portfolio del programmatore, quali almeno la foto, l’elenco delle skill e quello delle esperienze, e due form.
* Il primo consente il contatto con l’utente admin e la registrazione (facoltativa, ma necessaria al fine di accedere all’area riservata).
* Il secondo è destinato solo agli utenti che possiedono le credenziali di accesso all’area riservata, ai quali, qualora avessero già effettuato il log in durante la sessione in corso, non verrà richiesta nuovamente un’immissione [con una sessione PHP].
## [shipment.php](/shipment.php)
È, questa, una pagina di elaborazione delle informazioni che giungono dal primo form di home.php.  Dapprima i dati fondamentali (Nome, Cognome ed Email), senza il cui inserimento nei campi del form di contatto non viene consentito l’invio, vengono sottoposti a delle analisi che ne verificano la validità, affinché sia possibile la formulazione e l’invio [con PHPMailer](https://github.com/PHPMailer/PHPMailer) della mail di risposta (un indirizzo e-mail inesatto impedirebbe la ricezione delle credenziali). A seguito delle opportune correzioni vengono composte due mail.
* La prima, destinata all’utente admin, elenca le informazioni inserite in home.php.
* La seconda, per l’utente che sta interagendo, rappresenta un messaggio di conferma della spedizione della prima e fornisce le credenziali richieste.\

Le credenziali, solo quando l’indirizzo e-mail specificato risulta inesistente all’interno del database , sono generate dal codice e registrate [con PHP MySQLi](https://www.php.net/manual/en/book.mysqli.php) assieme agli altri dati utente.
* L’username corrisponde a ‘nome.cognome’.
* La password è una ricombinazione casuale a sei caratteri della stringa ‘abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789’.
## [reserved.php](/reserved.php)
Entrambi gli utenti, standard e admin, una volta confrontati i valori “Username” e “Password” inviati dalla prima o dalla seconda pagina del sito con quelli della tabella “utenti”, avranno ottenuto i permessi per la visualizzazione dell’elenco dei documenti, la lettura delle descrizioni ed il download [con l’inclusione del nome stampato in un tag di tipo “a”, che si riferisce all’indirizzo del file system settato dall’admin per il record]. Sempre agli stessi sarà consentito disconnettersi, ovvero distruggere la sessione attiva e venire ricatapultati alla home page. Solo l’admin, unico utente a possedere un record nella colonna “indirizzoEmail” congruente a quello impostato in “credentials.php”, sarà autorizzato a rimuovere o aggiungere (se non duplicati) interi record alla tabella “documenti”.
# Windows setup
## PHP setup
1. Installation
  * Follow [instructions](https://www.php.net/manual/en/install.windows.php)
2. php.ini (php installation folder) setup
	> check extension_dir constant: must point to `C:\\phpinstallationfolder\ext` folder
  * enable mysqli extension (remove comment line marker `;`)
  * enable openssl extension
## DB setup
1. [MySQL installation](https://dev.mysql.com/downloads/installer/)
  * Activate MySQL Windows Service and eventually set it as startup
2. Prepare db instance
  * Execute [cvo.sql](/config/cvo.sql) with MySQL client (command line or GUI) or Database Management VSCode extension
	> be aware: eventual pre-existing 'cvo' named db instance will be dropped
  * Customize [credentials.php](/config/credentials.php)
## Mailer setup
Customize [credentials.php](/config/credentials.php)
	> Must have a Google account and a Google App Password
## Program execution on local host with dedicated port
1. `cd C:\\project\dir`
2. `php -S localhost:8080` (default landing page: index.php)
3. Search `localhost:8080` on the browser
> check your spam if you don't find credentials mails in your mailbox
# Still to implement 
* multiuser sessions
* user unsubscription
# Security issue
* A registered user can return to home without actually killing its own session (and so other users can access its reserved area without actually authenticate)
	> Good pratice: always log out as a user!
