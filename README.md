# (Italian) overview
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
