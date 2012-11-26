<?php //header.php
	session_start();  
?>

<!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<LINK href="assets/css/styles.css" rel="stylesheet" type="text/css">
<script src="./assets/js/script.js" type="text/javascript"></script>
<html>
	<head>
		<title>Shopping Cart App</title>
	</head>

	<body>
		<div id="page_wrap">
		<div id="header">
			<div id="login">
				<nav>
					<ul>
						<?php
							if(isset($_SESSION["userID"]))
							{
								echo "<li><a href='logout.php'>Logout</a></li>";
								echo "<li><a href='modcart.php'>View Cart</a></li>";
							}
							else
							{
						?>
						<li id="register">
							<a href="register.php">Register</a>
						</li>
						<li id="login">
							<a href="login.php">Login</a>
						</li>
						<?php } ?>
					</ul>
				</nav>
			</div>
			<a href="index.php"><h2>R & R's Online Store</h2></a>
		</div>