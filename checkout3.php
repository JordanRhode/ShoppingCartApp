<!--  Checkout3.php -->
<?php
	require_once 'header.php';
	require_once 'conn.php';
	
	if(isset($_SESSION['userID'])){
		//  Set up Variables
		$userID = $_SESSION['userID'];
		//get user's transactions
		$sql = "SELECT numTransactions FROM rrtable_user
				WHERE userID = '$userID'";
		$result = mysql_query($sql, $conn) or die('User Transactions error: ' . mysql_error());
		$row = mysql_fetch_array($result);
		$usersTransactions = $row['numTransactions'];
		
		//create transID from it
		$transID = $usersTransactions + 1;
		//get information from cart
		$sql = "SELECT prodID, quantity FROM rrtable_cart
				WHERE userID = '$userID'";
		$result = mysql_query($sql, $conn) or die('Cart Information error: ' . mysql_error());
		while($row = mysql_fetch_array($result)){
			//Input information into transactions table
			$prodID = $row['prodID'];
			$quan = $row['quantity'];
			$sql = "INSERT INTO rrtable_transactions (transID, userID, prodID, quantity)
					VALUES ('$transID', '$userID', '$prodID', '$quan')";
			mysql_query($sql, $conn) or die('Record Transaction error: ' . mysql_error());
		}
		//Once the data has been recorded, the cart is emptied for that user, and their account should
		//	show that they have made the transaction
		$sql = "UPDATE rrtable_user SET numTransactions = '$transID' 
				WHERE userID = '$userID'";
		mysql_query($sql, $conn) or die('Could not update user account: ' . mysql_error());
		//cart
		$sql = "DELETE FROM rrtable_cart WHERE userID = '$userID'";
		mysql_query($sql, $conn) or die('Could not delete cart contents:  ' . mysql_error());
?>
<p>Step 1 - Please Enter Billing and Shipping Information <br/>
Step 2 - Please Verify Accuracy and Make Any Neccessary Changes<br/>
<b>Step 3 - Order Confirmation and Receipt</b><br/>
<p>
Here is a recap of your order:
</p>


<?php 
	}else{
		echo 'Sorry but there was an error:  userID lost.<br/>';
		echo 'Please <a href="index.php">go back to the main page </a> and try again.';
	}		
	require_once 'footer.php';
?>