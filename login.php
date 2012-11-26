<?php //login.php
	require_once "header.php";
	require_once "http.php";
	require_once "conn.php";

	if (!isset($_POST['submit'])){
?>
<form method="post" action="login.php">
	<h1>Member Login</h1>
	<p>Email Address: </br>
		<input type="text" name="email" maxlength="255" value="" />
	</p>
	<p>Password: </br>
		<input type="password" name="password" maxlength="50" />
	</p>
	<p>
		<input type="submit" class="submit" name="submit" value="Login" />
	</p>
	<p>Not a member yet? <a href="register.php">Create an account.</a>
	</p>
</form>
<?php } 
	else
	{
		if(isset($_POST["email"])
			and isset($_POST["password"]))
		{
			$salt = "R4nd0m";
			$email = $_POST["email"];
			$password = crypt($_POST["password"], $salt);

			$sql = "SELECT userID, email, password " .
			"FROM rrtable_user " .
			"WHERE email='" . $email . "' " .
			"AND password='" . $password . "'";
			$result = mysql_query($sql,$conn) or
				die("Couldn't look up user information. " . mysql_error());
			if($row = mysql_fetch_array($result))
			{
				session_start();
				$_SESSION["userID"] = $row["userID"];
				redirect("index.php");
			}
			else
			{
				redirect("login.php");
			}
		}
	}
?>
<?php require_once "footer.php"; ?>