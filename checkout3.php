<!--  Checkout3.php -->
<?php
	require_once 'header.php';
	require_once 'conn.php';
	
	if(isset($_SESSION['userID'])){

		//  Set up Variables
		$userID = $_SESSION['userID'];
		$bAddressID = $_SESSION['baddressID'];
		$sAddressID = $_SESSION['saddressID'];
		$subtotal = $_SESSION['subtotal'];
		$totQuan = 0;
		$shipCost = 0;
		$totalCost = 0;
		
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
			$totQuan += $quan;
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
		
		//Calculate shipping cost
		$shipCost = $totQuan * 4.95;
		
		//Get Date
		$orderDate = date ("Y-m-d", time());
		
		//Calculate Total
		$totalCost = $subtotal + $shipCost;
		
		//INSERT obtained info into order table
		$sql = "INSERT INTO rrtable_order (transID, orderDate, subtotal, shipCost, total)
				VALUES ('$transID', '$orderDate', '$subtotal', '$shipCost', '$totalCost')";
		mysql_query($sql, $conn) or die('Order Input error: ' . mysql_error());	
			
		//Get order id
		$sql = "SELECT orderID FROM rrtable_order
				WHERE transID = '$transID' AND
					orderDate = '$orderDate'";
		$result = mysql_query($sql, $conn) or die('Order ID error: ' . mysql_error());
		$row = mysql_fetch_array($result);
		$orderID = $row['orderID'];
		
		//Insert info into billing table
		$sql = "INSERT INTO rrtable_billing (addressID, orderID)
				VALUES ('$bAddressID', '$orderID')";
		mysql_query($sql, $conn) or die('Billing Input error: ' . mysql_error());
				
		//Insert info into shipping table
		$sql = "INSERT INTO rrtable_shipping (addressID, orderID)
				VALUES ('$sAddressID', '$orderID')";
		mysql_query($sql, $conn) or die('Shipping Input error: ' . mysql_error());
		
		//Get shipping ID
		$sql = "SELECT shipID FROM rrtable_shipping
				WHERE orderID = '$orderID'";
		$result = mysql_query($sql, $conn) or die('Shipping ID error: ' . mysql_error());
		$row = mysql_fetch_array($result);
		$shipID = $row['shipID'];
		
		//Get billing ID
		$sql = "SELECT billID FROM rrtable_billing
				WHERE orderID = '$orderID'";
		$result = mysql_query($sql, $conn) or die('Billing ID error: ' . mysql_error());
		$row = mysql_fetch_array($result);
		$billID = $row['billID'];
		
		//INSERT all info into order table
		$sql = "UPDATE rrtable_order SET shipID = '$shipID', billID = '$billID' 
				WHERE orderID = '$orderID'";
		mysql_query($sql, $conn) or die('Could not update order info: ' . mysql_error());
		
?>
<p>Step 1 - Please Enter Billing and Shipping Information <br/>
Step 2 - Please Verify Accuracy and Make Any Neccessary Changes<br/>
<b>Step 3 - Order Confirmation and Receipt</b><br/>
<p>
Here is a recap of your order:
</p>
<?php
	echo '<p>';
	echo 'Order Date: ' . $orderDate . '<br/>';
	echo 'Order Number: ' . $orderID . '<br/>';
	echo 'Bill To: <br/>';
	echo $bHouseNumber . " " . $bStreet . "<br/>";
	echo $bCity . " " . $bState . " " . $bZip . "<br/>";
	echo '<br/><br/>';
	echo 'Ship To: <br/>';
	echo $sHouseNumber . " " . $sStreet . "<br/>";
	echo $sCity . " " . $sState . " " . $sZip;
	echo '<br/><br/>__________________________________________<br/><br/>';
	
	//get prods
	//display all items in cart
		/*$sql = "SELECT prodID, quantity " .
				"FROM rrTable_transactions " .
				"WHERE userID=" . $userID . "AND
				transID=3";
		$result = mysql_query($sql, $conn) or
			die("Couldn't retrieve items in cart. " . mysql_error());
		
		$xml = simplexml_load_file("assets/xml/productList.xml")
				or die("Unable to lad XML file");

		echo "<table id='modcart_table'>";
		echo "<tr><td>Item Image</td><td>Item Name</td><td>Price Each</td><td>Extended Price</td><td>Quantity</td></tr>";
		$total = 0;
				
		while($row = mysql_fetch_array($result)){
			foreach ($xml->product as $product) {
				$id = $product->attributes()->id;
				$name = $product->name;
				$price = $product->price;
				$thumbnail = $product->thumbnail;
				$quan = $product->quantity;
					

			if($id == $row["prodID"]){

				$total += ($price * $row["quantity"]);
				echo "<tr>";
				echo "<td><img src='" . $thumbnail . "' alt='" . $name . "' height='100' width='100'/></td>";
				echo "<td class='product_name'>" . $name . "</td>";
				echo "<td><p>$" . $price . "</p></td>";
				echo "<td><p>$" . $price * $row["quantity"] . "</p></td>";
				echo $row['quantity'];
				}
			}
		*///}
	
	echo 'Your total before shipping is:  $' . $subtotal . '<br/>';
	echo 'Shipping Costs:  $' . $shipCost . '<br/>';
	echo 'Your final total is:  $' . $totalCost;

	}else{
		echo 'Sorry but there was an error:  userID lost.<br/>';
		echo 'Please <a href="index.php">go back to the main page </a> and try again.';
	}		
	require_once 'footer.php';
?>