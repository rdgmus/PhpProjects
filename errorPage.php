<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=MacRoman">
<title>Error Page</title>
<link href="css/PhpRegistroWeb.css" rel="stylesheet">

</head>
<?php include 'functions/utilities_functions.php';?>
<body>
	<span class="error_page">Error Page</span>
	<?php removeAllCookyes();
	echo "<h2>Session expired!</h2><br>";?>
	<a href="index.php"><img src="images/home1.png" width="64" height="64" title="Home"/>
	</a>
	<form method="post"
		action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<table border="0">
			<tr align="center">
				<td colspan="4"><img src="images/LogoPhpRegistroWeb.png"
					width="500" height="250" />
				</td>
			</tr>
		</table>
	</form>
</body>
</html>
