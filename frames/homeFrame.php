
<a href="index.php"><img src="images/home1.png" width="64" height="64" 
title="Home"/>
	<span class="error">
	<?php if (!isset($_COOKIE['MYSQL_SERVER'])) {
		die('<h1>MYSQL_SERVER_ERROR: Nessun server MySql selezionato!</h1>');
	}
	?></span>
	<?php 
            echo 'MYSQL_SERVER:'.$_COOKIE['MYSQL_SERVER'];
                
?> </a>