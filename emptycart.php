<?php //emptycart.php
	require_once "conn.php";
	require_once "http.php";

	session_start();
	if(isset($_SESSION["userID"]))
	{
		$userID = $_SESSION["userID"];
		$sql = "DELETE FROM rrTable_cart " .
				"WHERE (userID=".$userID.")";
		mysql_query($sql,$conn) or
			die("Couldn't delete item from cart. " . mysql_error());
	}

	redirect("modcart.php");
	?>