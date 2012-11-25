<?php //conn.php
	define("SQL_HOST", "localhost");
	define("SQL_USER", "root");
	define("SQL_PASS", "");
	define("SQL_DB", "store");
	$conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PASS) or 
		die("Couldn't connect to the database: " . mysql_error());
	mysql_select_db(SQL_DB, $conn) or 
		die("Couldn't select the database: " . mysql_error());
?>