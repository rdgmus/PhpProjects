<!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<?php include_once 'functions/mysql_functions.php';?>
<?php include 'jquery/jquery.php';?>
<link href="css/PhpRegistroWeb.css" rel="stylesheet">

</head>
<body>
	<!-- 
$2y$10$3ZJS.QU4.K5TQvbPVItB4eyX6XC2JgOoxkVHZ1AQC36f57hrhxVGe
			H A S H - CONFERMA RICHESTA
$2y$10$3ZJS.QU4.K5TQvbPVItB4eyX6XC2JgOoxkVHZ1AQC36f57hrhxVGe
 
 -->
	<img src="images/Cbasso1.png" />
	<img src="images/LogoPhpRegistroWeb.png" width="500" height="250" />
	<br>
	<h1>PhpRegistroWeb 1.0</h1>
	<?php if(isset($_REQUEST['hash'])){
		$hash = urldecode($_REQUEST['hash']);
		$id_request = $_REQUEST['id_request'];
		$cognome = $_REQUEST['cognome'];
		$nome = $_REQUEST['nome'];
		$email = $_REQUEST['email'];
	}else{
		echo "<h2>Probabilmente le sue richieste sono gi&agrave state elaborate!</h2>";
		die("<h3>NESSUNA RICHIESTA IN ATTESA CHE POSSA ESSERE SERVITA!</h3>");

	}
	?>

	<h1>Hai inoltrato una richiesta di cambio Password?</h1>
	<hr>

	<form method='post' name='frm' id="frm">
	<?php
	foreach ($_REQUEST as $a => $b) {
		echo "<input type='text' name='".htmlentities($a)."' value='".htmlentities($b)."'>";
	}
	?>
		<hr>
		<?php
		if(!existRequestPendingFor($id_request, $hash, $cognome, $nome, $email)){
			die("<h3>NESSUNA RICHIESTA IN ATTESA CHE POSSA ESSERE SERVITA!</h3>");
		}else{
			echo "<h3>RICHIESTA VALIDA!</h3>";
		}?>
		<input type="button" id="lanciaConfermaRichiesta"
			value="Conferma la tua Richiesta">
	</form>
</body>

</html>
