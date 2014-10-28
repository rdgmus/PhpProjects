<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=MacRoman">
<title>Login</title>

<?php echo '<h1>PhpRegistroWeb 1.0</h1><br>';?>
<?php include 'jquery/jquery.php';?>
<link href="css/PhpRegistroWeb.css" rel="stylesheet">


<?php
// A way to view all cookies
//include 'config.php';
include 'functions/utilities_functions.php';
include 'functions/mysql_functions.php';


?>



</head>
<body>
<h1>
	Prova le connessioni a MySql 
</h1>
<h2>
    <a href="./tryConnections.php">Try Connections</a>
</h2><br/>
	<form method="post" id="indexForm"
		action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<table border="0">
			<tr align="center">
				<td colspan="3"><img src="images/LogoPhpRegistroWeb.png"
					width="500" height="250" />
				</td>
			</tr>
			<tr>

			<?php if(!isset($_COOKIE['MYSQL_SERVER'])){
				$_COOKIE['MYSQL_SERVER'] = 'SOCKET:3307';
			}$MySqlServer=$_COOKIE['MYSQL_SERVER'];
			?>
			<?php $serverGroups = getMySqlServerGroups();?>
				<td align="right"><select name="MySqlServer" id="MySqlServer"
					>
					<?php
					while ($row = mysql_fetch_assoc($serverGroups)) {
						?>
						<optgroup label="<?php echo $row['server_group'];?>">
						<?php

						$serverParams = getMySqlServerParams($row['id_server_group']);
						while ($params = mysql_fetch_assoc($serverParams)) {?>
							<option value="<?php echo $params['server_name'];?>"
							<?php if ($MySqlServer==$params['server_name']) {
								echo ' selected="selected" ';
							}?>><?php echo $params['note']?></option>
							<?php 
							
						}
					}
					?>
						</optgroup>
				</select>
				</td>
				
				<td><img name="actionRegister"
					title="Vai a Registrazione nuovo utente" src="images/edit_user.png"
					id="startNewUserPage" width="48" height="48" />
				</td>
				<td><img name="actionRegister" title="Vai al 'Login'"
					src="images/log_in.png" id="startLoginPage" width="48" height="48" />
				</td>
			</tr>
		</table>
	</form>

	<?php
	if (isset( $_COOKIE['message'])) {
		?>
	<div id="dialogEmail" title="Email Message">
		<p>
		<?php echo $_COOKIE['message']?>
		</p>
	</div>
	<?php
	}
	?>

</body>
</html>
