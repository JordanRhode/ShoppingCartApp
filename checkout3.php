<!--  Checkout3.php -->
<?php
	require_once 'header.php';
	require_once 'conn.php';
	
	if(isset($_SESSION['userID'])){

		//  Set up Variables
		$userID = $_SESSION['userID'];
		$bAddressID = $_POST['baddressID'];
		$sAddressID = $_POST['saddressID'];
		
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
		
		//Get all the address information for both billing and shipping
		// Billing
		$sql = "SELECT houseNum, street, zip FROM rrtable_address
				WHERE addressID = '$bAddressID'";
		$result = mysql_query($sql, $conn) or die('Billing Address error: ' . mysql_error());
		$row = mysql_fetch_array($result);
		
		//set hN, st, and zip
		$bHouseNumber = $row['houseNum'];
		$bStreet = $row['street'];
		$bZip = $row['zip'];
		
		//get / set city and state
		$sql = "SELECT city, state FROM rrtable_citystate
				WHERE zip = '$bZip'";
		$result = mysql_query($sql, $conn) or die('Billing Address error: ' . mysql_error());
		$row = mysql_fetch_array($result);
		$bCity = $row['city'];
		$bState = $row['state'];
		
		// Shipping
		$sql = "SELECT houseNum, street, zip FROM rrtable_address
				WHERE addressID = '$sAddressID'";
		$result = mysql_query($sql, $conn) or die('Shipping Address error: ' . mysql_error());
		$row = mysql_fetch_array($result);
		
		//set hN, st, and zip
		$sHouseNumber = $row['houseNum'];
		$sStreet = $row['street'];
		$sZip = $row['zip'];
		
		//get / set city and state
		$sql = "SELECT city, state FROM rrtable_citystate
				WHERE zip = '$sZip'";
		$result = mysql_query($sql, $conn) or die('Shipping Address error: ' . mysql_error());
		$row = mysql_fetch_array($result);
		$sCity = $row['city'];
		$sState = $row['state'];
		
		echo "Billing: <br/>";
		echo $bHouseNumber . " " . $bStreet . "<br/>";
		echo $bCity . " " . $bState . " " . $bZip . "<br/>";
		echo "Shipping: <br/>";
		echo $sHouseNumber . " " . $sStreet . "<br/>";
		echo $sCity . " " . $sState . " " . $sZip;
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