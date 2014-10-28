<?php
include 'functions/mysql_functions.php';
include 'functions/utilities_functions.php';
/**
 *
 *
 * @author Roberto Della Grotta
 * @version $Id$
 * @copyright , 18 October, 2014
 * @package default
 */

/**
 *	CHIAMATE A FUNZIONI EFFETTUATE DA TINYMCE PLUGIN
 *
 */
if (isset($_POST['actionRequest'])) {
	if ($_POST['actionRequest'] == 'confirmChangePassword') {
		$hash = ($_POST['hash']);
		$id_request = ($_POST['id_request']);

		echo setRequestConfirmedFor($hash, $id_request);
		exit();
	}
	echo FALSE;
	exit();
}

if (isset($_POST['callGetEmailSubject'])) {
	if (isset($_POST['emailSubject'])) {
		$subject = ($_POST['emailSubject']);
		setEmailSubject($_COOKIE['emailId'], $subject);
	}
	echo getEmailSubject($_COOKIE['emailId']);
}
if (isset($_POST['callGetEmailBody'])) {//emailBody
	if (isset($_POST['emailBody'])) {
		$body = ($_POST['emailBody']);
		setEmailBody($_COOKIE['emailId'], $body);
	}
	echo getEmailBody($_COOKIE['emailId']);
}
if (isset($_POST['callUndoToLastRecipient'])) {//cancella ultmo destinatario To textarea
	undoLastRecipient($_COOKIE['emailId'], 'to');
	echo getToRecipients($_COOKIE['emailId']);
}
if (isset($_POST['callUndoCcLastRecipient'])) {//cancella ultmo destinatario To textarea
	undoLastRecipient($_COOKIE['emailId'], 'cc');
	echo getCcRecipients($_COOKIE['emailId']);
}
if (isset($_POST['callUndoBccLastRecipient'])) {//cancella ultmo destinatario To textarea
	undoLastRecipient($_COOKIE['emailId'], 'bcc');
	echo getBccRecipients($_COOKIE['emailId']);
}

/**
 * SELEZIONA LE OPERAZIONI DA SVOLGERE IN BASE AL PARAMETRO page
 * CHE VIENE FORNITO DALLA CHIAMATA $.ajax EFFETTUATA DALL'UTENTE
 */
if (isset($_POST['page'])) {
	$page = $_POST['page'];


	/**
	 * $page == 'index.php'
	 */

	if ($page == 'index.php') {//index.php
		setcookie('MYSQL_SERVER',trim($_POST['MySqlServer']));
		echo $_SERVER['SERVER_NAME'];
	}
	/**
	 * $page == 'emailToUser.php'
	 */
	elseif($page == 'emailToUser.php'){//emailToUser.php
		if (isset($_POST['action'])) {
			if($_POST['action']=='selectRecipient'){
				setcookie('selectedRecipient', $_POST['selectedRecipient']);
				echo $_SERVER['SERVER_NAME'];
			}
		}elseif(isset($_POST['selectedRecipient'])) {
			$selectedRecipient = $_POST['selectedRecipient'];
			if (isset($_POST['emailButton'])) {
				$emailButton = $_POST['emailButton'];
				$id_email=$_COOKIE['emailId'];
				if ($emailButton == "To") {
					$to = stripcslashes($_POST['to']);//email destinatario da mettere nella casella TO
					if (!recipientExists($id_email, getUserEmail($selectedRecipient),
					getUserName($selectedRecipient))) {
						addRecipientToEmail($id_email, getUserEmail($selectedRecipient),
						getUserName($selectedRecipient), 1, 0, 0, 0);
						echo getToRecipients($_COOKIE['emailId']);
					}else
					echo $to;

				}elseif ($emailButton == "Cc") {//email destinatario da mettere nella casella CC
					$cc = stripcslashes($_POST['cc']);
					if (!recipientExists($id_email, getUserEmail($selectedRecipient),
					getUserName($selectedRecipient))) {
						addRecipientToEmail($id_email, getUserEmail($selectedRecipient),
						getUserName($selectedRecipient), 0, 1, 0, 0);
						echo getCcRecipients($_COOKIE['emailId']);
					}else
					echo $cc;

				}elseif ($emailButton == "Bcc") {//email destinatario da mettere nella casella BCC
					$bcc = stripcslashes($_POST['bcc']);
					if (!recipientExists($id_email, getUserEmail($selectedRecipient),
					getUserName($selectedRecipient))) {
						addRecipientToEmail($id_email, getUserEmail($selectedRecipient),
						getUserName($selectedRecipient), 0, 0, 1, 0);
						echo getBccRecipients($_COOKIE['emailId']);
					}else
					echo $bcc;
				}

			}else{
				echo getUserName($selectedRecipient).'<'.getUserEmail($selectedRecipient).'>;';
			}
			setcookie('selectedRecipient', $_POST['selectedRecipient']);

		}else{
			echo $_SERVER['SERVER_NAME'];
		}
	}
	/**
	 * $page == 'userRegistration.php'
	 */
	elseif ($page == 'userRegistration.php'){//userRegistration.php
		echo $_SERVER['SERVER_NAME'];
	}
	/**
	 * $page == 'userMenu.php'
	 */
	elseif ($page == 'userMenu.php'){//userMenu.php
		if(isset($_POST['action'])){
			if($_POST['action']=="gotochangeOthersPassword"){
				echo $_SERVER['SERVER_NAME'];
				//echo get_ip();
				//echo $_SERVER['SERVER_ADDR'];
			}
			elseif($_POST['action']=="createEmail"){
				//Crea una nuova email se non ne � stata salvata una
				
				createEmailAndCookyes();

				echo $_SERVER['SERVER_NAME'];
			}elseif ($_POST['action']=="backToUserMenu"){
				//cancella le email con data a NULL?
				//$.prompt("Hello World!");
				if (isset($_POST['cancellaEmail'])) {
					if ($_POST['cancellaEmail']=='true') {
						deleteNullEmail($_COOKIE['id_utente'], $_COOKIE['emailId']);
					}else{
						//Salva Email
						if (isset($_POST['subject'])) {
							$subject = $_POST['subject'];
						}
						if (isset($_POST['body'])) {
							$body = $_POST['body'];
						}
						saveEmailDraft($_COOKIE['emailId'], $subject, $body);
					}
				}
				echo $_SERVER['SERVER_NAME'];
			}elseif ($_POST['action']=="testUserHasToChangePassword") {
				echo hasUserToChangePassword($_COOKIE['id_utente']);
			}elseif ($_POST['action']=="logout"){
				registerLogEvent("LOGOUT", "LOGOUT DA REGISTRO SCOLASTICO", $_COOKIE['id_utente'], $_SERVER['REMOTE_ADDR']);
				echo $_SERVER['SERVER_NAME'];
			}
		}elseif (isset($_POST['id_ruolo'])) {
			$id_utente = $_POST['selectedUtente'];
			$id_ruolo = $_POST['id_ruolo'];
			setUnsetRuoloUtente($id_utente, $id_ruolo);
			echo $_SERVER['SERVER_NAME'];
		}elseif (isset($_POST['selectedUtente'])){
			setcookie('selectedUtente', $_POST['selectedUtente']);
			echo $_SERVER['SERVER_NAME'];
		}else{

			echo $_SERVER['SERVER_NAME'];
		}
	}
	/**
	 * $page == 'changePassword.php'
	 */
	elseif ($page == 'changePassword.php'){
		if (isset($_POST['action'])) {
			if ($_POST['action'] == 'changePassword') {
				$selectedRecipient = $_COOKIE['id_utente'];//$_POST['selectedRecipient'];
				setcookie('selectedRecipient',$selectedRecipient);

				$user_email = getUserEmail($selectedRecipient);

				$oldpassword = $_POST['oldpassword'];
				$oldpasswordErr = testPasswordErr($oldpassword);
				setcookie('oldpasswordErr',$oldpasswordErr);
				if($oldpasswordErr != '*'){
					echo $_SERVER['SERVER_NAME'];
					exit();
				}


				$password = $_POST['password'];
				$newpasswordErr = testPasswordErr($password);
				setcookie('newpasswordErr',$newpasswordErr);
				if($newpasswordErr != '*'){
					echo $_SERVER['SERVER_NAME'];
					exit();
				}

				$password_one = $_POST['password_one'];
				$repeatPasswordErr = testPasswordsAreEqual($password, $password_one);
				setcookie('repeatPasswordErr',$repeatPasswordErr);
				if($repeatPasswordErr != '*'){
					echo $_SERVER['SERVER_NAME'];
					exit();
				}

				if ($oldpasswordErr == '*' && $newpasswordErr = '*' && $repeatPasswordErr= '*') {
					changePassword($selectedRecipient, $user_email, $oldpassword, $password);
					setUserHasToChangePassword($_COOKIE['id_utente'], 0);
					
					echo $_SERVER['SERVER_NAME'];
					exit();
				}
				echo $_SERVER['SERVER_NAME'];
			}
		}


	}
	/**
	 * $page == 'changeOthersPassword.php'
	 */
	elseif ($page == 'changeOthersPassword.php'){
		if (isset($_POST['action'])) {
			if ($_POST['action'] == 'changeOthersPassword') {
				//removeChangePasswordCookyes();
				$countRowPending = $_POST['countRowPending'];
				if ($countRowPending == 0) {
					setcookie('message', 'NESSUNA RICHIESTA PENDENTE');
					echo $_SERVER['SERVER_NAME'];
					exit();
				}
				$selectedRecipient = $_POST['selectedRecipient'];
				setcookie('selectedRecipient',$selectedRecipient);

				$user_email = getUserEmail($selectedRecipient);

				$oldpassword = $_POST['oldpassword'];
				$oldpasswordErr = testPasswordErr($oldpassword);
				setcookie('oldpasswordErr',$oldpasswordErr);
				if($oldpasswordErr != '*'){
					echo $_SERVER['SERVER_NAME'];
					exit();
				}


				$password = $_POST['password'];
				$newpasswordErr = testPasswordErr($password);
				setcookie('newpasswordErr',$newpasswordErr);
				if($newpasswordErr != '*'){
					echo $_SERVER['SERVER_NAME'];
					exit();
				}

				$password_one = $_POST['password_one'];
				$repeatPasswordErr = testPasswordsAreEqual($password, $password_one);
				setcookie('repeatPasswordErr',$repeatPasswordErr);
				if($repeatPasswordErr != '*'){
					echo $_SERVER['SERVER_NAME'];
					exit();
				}

				if ($oldpasswordErr == '*' && $newpasswordErr = '*' && $repeatPasswordErr= '*') {
					//CAMBIA LA PASSWORD DELL'UTENTE
					if(changePassword($selectedRecipient, $user_email, $oldpassword, $password)){

						$from = getUserEmail($_COOKIE['id_utente']);
						$to = $user_email;
						$subject = 'Le sue nuove credenziali di accesso sono: <br>'.
					"Email: ".$user_email."<br> Password: ".$password;
							
							
						$message_content= 'Al primo accesso con le nuove credenziali, deve cambiare <br>'.
					"la password per ragioni di sicurezza del suo account. <br>".
					"Cordiali Saluti <br> Admin - PhpRegistroScuolaNetBeans ";
							
						//Assigning a picture for {logo} replacement
						$logo = "images/Cbasso1.png";
						//INVIA IL MESSAGGIO CON LE NUOVE CREDENZIALI ALL'UTENTE
						include_once 'phpmailer-with-templates/phpmailer-config.php';
						$status = send_message($from, $to, $subject, $message_content, $logo);
						if($status){//EMAIL INVIATA
							//AGGIORNA il DATABASE
							removePendingFromUserRequest($selectedRecipient, $_COOKIE['id_utente']);
							setUserHasToChangePassword($selectedRecipient, 1);
						}
					}
					echo $_SERVER['SERVER_NAME'];
					exit();
				}
			}elseif ($_POST['action'] == 'selectRecipient'){
				$selectedRecipient = $_POST['selectedRecipient'];
				setcookie('selectedRecipient', $selectedRecipient);
				echo retrievePassword($selectedRecipient);

			}elseif ($_POST['action'] == 'generatePassword'){
				if (isset($_POST['numChars'])) {
					$numChars = $_POST['numChars'];
					echo generate_password($numChars);
				}
			}elseif ($_POST['action'] == 'copyPassword'){
				if (isset($_POST['password'])) {
					$generatedPassword = $_POST['password'];
					echo $generatedPassword;
				}
			}
			else echo $_SERVER['SERVER_NAME'];

		}

	}
	else{
		setcookie('selectedUtente', $_POST['selectedUtente']);
	}
}

/**
 *
 * Enter description here ...
 * @param unknown_type $selectedRecipient
 * @param unknown_type $user_email
 * @param unknown_type $oldpassword
 * @param unknown_type $password
 */
function changePassword($selectedRecipient, $user_email, $oldpassword, $password) {
	if (connectToMySql()) {
		//QUERY FOR USER ACCOUNT HERE
		if(authenticateUser($user_email, $oldpassword, FALSE)){
			//QUI CAMBIA LA PASSWORD
			changeUtenteScuolaPassword($selectedRecipient, $user_email, $oldpassword, $password);
			closeConnection();
			return TRUE;
		}else{
			$msg = '<span class="error">L\'utente selezionato non ha i permessi di accesso!</span>';
			setcookie("message",$msg);
			closeConnection();
			return FALSE;
		}
	}
	return FALSE;
}

/**
 *
 * Enter description here ...
 * @param unknown_type $password
 */
function testPasswordErr($password) {
	if (empty($password)) {
		$passwordErr = 'Password required';
	}else{
		$password = test_input($password);
		//VALIDATE PASSWORD
		if (!filter_var($password, FILTER_VALIDATE_REGEXP,
		array("options"=>array("regexp"=>"((?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,10})") ))){
			//da 4 a 10 caratteri, deve contenere maiuscole, minuscole e numeri
			$passwordErr = "Invalid Password format";
		}else $passwordErr = "*";
	}
	return $passwordErr;
}




/**
 *
 * Enter description here ...
 * @param unknown_type $password
 * @param unknown_type $password_one
 */
function testPasswordsAreEqual($password,$password_one) {
	if (empty($password_one)) {
		$passwordErr = 'Password required';
	}elseif( strlen($password)>0 && strlen($password_one) > 0 &&  $password == $password_one){
		//QUERY FOR DATABASE CONNECTION HERE
		if (!filter_var($password, FILTER_VALIDATE_REGEXP,
		array("options"=>array("regexp"=>"((?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,10})") ))){
			//da 4 a 10 caratteri, deve contenere maiuscole, minuscole e numeri
			$passwordErr = "Invalid Password format";
		}else $passwordErr = "*";
	}else{
		$passwordErr = 'Passwords do not match!';
	}
	return $passwordErr;
}