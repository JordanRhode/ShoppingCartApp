<!--  Checkout2.php  -->
<?php
	require_once 'header.php';
	require_once 'conn.php';
?>
<p>Step 1 - Please Enter Billing and Shipping Information <br/>
<b>Step 2 - Please Verify Accuracy and Make Any Neccessary Changes </b><br/>
Step 3 - Order Confirmation and Receipt<br/>

<!--  Get address id's for billing and shipping, then set variables  -->
<?php
	if(isset($_SESSION["userID"])
		and isset($_SESSION["baddressID"])
		and isset($_SESSION["saddressID"]))
	{
		$userID = $_SESSION["userID"];
		$baddressID = $_SESSION["baddressID"];
		$saddressID = $_SESSION["saddressID"];
		echo $baddressID . " " . $saddressID;
		unset($_SESSION["baddressID"]);
		unset($_SESSION["saddressID"]);

		$sql = "SELECT first, last, addressID, houseNum, street, city, state, rrtable_address.zip " .
		"FROM rrtable_name, rrtable_citystate, rrtable_address " .
		"WHERE rrtable_name.userID = " . $userID .
		" AND rrtable_address.addressID = " . $baddressID .
		" AND rrtable_address.userID = " . $userID .
		" AND rrtable_citystate.zip = rrtable_address.zip";
		$result = mysql_query($sql, $conn) or die(mysql_error());
		while($row=mysql_fetch_array($result))
		{
			$bfname = $row["first"];
			$blName = $row["last"];
			$bhouseNum = $row["houseNum"];
			$bstreet = $row["street"];
			$bcity = $row["city"];
			$bstate = $row["state"];
			$bzip = $row["zip"];
		}

		$sql = "SELECT first, last, addressID, houseNum, street, city, state, rrtable_address.zip " .
		"FROM rrtable_name, rrtable_citystate, rrtable_address " .
		"WHERE rrtable_name.userID = " . $userID .
		" AND rrtable_address.addressID = " . $saddressID .
		" AND rrtable_address.userID = " . $userID .
		" AND rrtable_citystate.zip = rrtable_address.zip";
		$result = mysql_query($sql, $conn) or die(mysql_error());
		while($row=mysql_fetch_array($result))
		{
			$sfname = $row["first"];
			$slName = $row["last"];
			$shouseNum = $row["houseNum"];
			$sstreet = $row["street"];
			$scity = $row["city"];
			$sstate = $row["state"];
			$szip = $row["zip"];
		}
	}
?>

<div id="billingForm">
	<form id="addressForm" name="addressForm" method="post" action="#">
		<h3>Billing Information</h3>
        	First Name:&nbsp;&nbsp;
            <input type="text" id="bfName" name="bfName" value="<?php echo $bfname; ?>" />
            <p>
            Last Name:&nbsp;&nbsp;
            <input type="text" id="blName" name="blName" value="<?php echo $blName; ?>"/>
            <p>
            House Number:&nbsp;&nbsp;
            <input type="text" id="bhouseNum" name="bhouseNum" value="<?php echo $bhouseNum; ?>"/>
            <p>
            Street:&nbsp;&nbsp;
            <input type="text" id="bstreet" name="bstreet" value="<?php echo $bstreet; ?>"/>
            <p>
            City:&nbsp;&nbsp;
            <input type="text" id="bcity" name="bcity" value="<?php echo $bcity; ?>"/>
            <p>
            State:&nbsp;&nbsp;
            <input type="text" id="bstate" name="bstate" value="<?php echo $bstate; ?>"/>
            <p>
            Zip:&nbsp;&nbsp;
            <input type="text" id="bzip" name="bzip" value="<?php echo $bzip; ?>"/>
            <p>
            <input type="hidden" id="baddressID" name="baddressID" value="<?php echo $baddressID; ?>"/>
</div>
<div id="shippingForm">
	<h3>Shipping Information</h3>
		
			First Name:&nbsp;&nbsp;
            <input type="text" id="sfName" name="sfName" value="<?php echo $sfname; ?>" />
            <p>
            Last Name:&nbsp;&nbsp;
            <input type="text" id="slName" name="slName" value="<?php echo $slName; ?>" />
            <p>
            House Number:&nbsp;&nbsp;
            <input type="text" id="shouseNum" name="shouseNum" value="<?php echo $shouseNum; ?>" />
            <p>
            Street:&nbsp;&nbsp;
            <input type="text" id="sstreet" name="sstreet" value="<?php echo $sstreet; ?>" />
            <p>
            City:&nbsp;&nbsp;
            <input type="text" id="scity" name="scity" value="<?php echo $scity; ?>" />
            <p>
            State:&nbsp;&nbsp;
            <input type="text" id="sstate" name="sstate" value="<?php echo $sstate; ?>" />
            <p>
            Zip:&nbsp;&nbsp;
            <input type="text" id="szip" name="szip" value="<?php echo $szip; ?>"/>
            <p>
            <input type="hidden" id="saddressID" name="saddressID" value="<?php echo $saddressID; ?>"/>
</div>
	
    <?php
    //display all items in cart
	 	$userID = $_SESSION["userID"];
		$sql = "SELECT prodID, quantity " .
				"FROM rrTable_cart " .
				"WHERE userID=" . $userID;
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
				echo "<td><form name='product".$id."' action='modcart.php' method='post'>";
				echo $row['quantity'];
				
				}
			}
		}
	
	echo "<tr><td></td><td></td><td>Total before shipping:</td>";
	echo "<td>$" . $total . "</td>";
	//modify cart
	echo '<td><a href="modcart.php">Modify Cart</a></td>';
	echo "</table>";
?>
    <input type="submit" name="submit" value="Send order"/>
	</form>
<?php require_once 'footer.php';?>