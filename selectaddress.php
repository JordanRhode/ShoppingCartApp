<?php //selectaddress.php
	require_once "conn.php";
	require_once "header.php";

	if(isset($_SESSION["userID"]))
	{
		echo "<div id='cart_info'>";
		echo "<h3>Select your billing address please.</h3>";
		echo "<form method='post' action='checkout.php'>";
		echo "<select id='addressID' name='addressID'>";

		$sql = "SELECT addressID, houseNum, street, zip " .
		"FROM rrtable_address " .
		"WHERE userID =" . $_SESSION["userID"];
		$result = mysql_query($sql,$conn) or die(mysql_error());
		while($row = mysql_fetch_array($result))
		{
			echo "<option value='" . $row["addressID"] . "'>" . $row["houseNum"] . " " . $row["street"] . " " . $row["zip"] . "</option>";
		}
		echo "</select><input type='submit' value='Submit'/></form></div>";
	}
	require_once "footer.php";
	?>