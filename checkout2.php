<!--  Checkout2.php  -->
<?php
	require_once "header.php";
	require_once "conn.php";
	require_once "http.php";
?>
<div id="cart_info">
<p>Step 1 - Please Enter Billing and Shipping Information <br/>
<b>Step 2 - Please Verify Accuracy and Make Any Neccessary Changes </b><br/>
Step 3 - Order Confirmation and Receipt<br/>

<!--  Get address id's for billing and shipping, then set variables  -->
<?php
	if(!isset($_POST["submit"])
		and isset($_SESSION["userID"])
		and isset($_SESSION["baddressID"])
		and isset($_SESSION["saddressID"]))
	{
		$userID = $_SESSION["userID"];
		$baddressID = $_SESSION["baddressID"];
		$saddressID = $_SESSION["saddressID"];

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
	
?>

<div id="billingForm">
	<form id="addressForm" onSubmit="return validateCheckout()" name="addressForm" method="post" action="#">
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
	$_SESSION["subtotal"] = $total;
	//modify cart
	echo '<td><a href="modcart.php">Modify Cart</a></td>';
	echo "</table>";
?>
    <input type="submit" name="submit" value="Send order"/>
	</form></div>
<?php 
		}
		else 
		{
			$userID = $_SESSION["userID"];
			$sfName = $_POST["sfName"];
			$bfName = $_POST["bfName"];
			$blName = $_POST["blName"];
			$slName = $_POST["slName"];
			$shouseNum = $_POST["shouseNum"];
			$bhouseNum = $_POST["bhouseNum"];
			$sstreet = $_POST["sstreet"];
			$bstreet = $_POST["bstreet"];
			$scity = $_POST["scity"];
			$bcity = $_POST["bcity"];
			$sstate = $_POST["sstate"];
			$bstate = $_POST["bstate"];
			$szip = $_POST["szip"];
			$bzip = $_POST["bzip"];
			$saddressID = $_POST["saddressID"];
			$baddressID = $_POST["baddressID"];

			//check if billing address is in db, if not add it 
			$sql = "SELECT first, last, addressID, houseNum, street, city, state, rrtable_address.zip " .
			"FROM rrtable_name, rrtable_citystate, rrtable_address " .
			"WHERE rrtable_name.userID = " . $userID .
			" AND rrtable_address.userID = " . $userID .
			" AND rrtable_address.houseNum =" . $bhouseNum .
			" AND rrtable_address.street = '" . $bstreet .
			"' AND rrtable_address.zip =" . $bzip;
			$result = mysql_query($sql, $conn) or die("billing error. " . mysql_error());
			$rows = mysql_fetch_array($result);
			if($rows["addressID"] == "")
			{
				
				$sql = "INSERT IGNORE INTO rrtable_cityState (zip, city, state)
				VALUES ('$bzip', '$bcity', '$bstate')";
				$result = mysql_query($sql, $conn)
					or die('Error with city and state:  ' . mysql_error());

				$sql = "INSERT IGNORE INTO rrtable_address (userID, houseNum, street, zip)
				VALUES ('$userID', '$bhouseNum', '$bstreet', '$bzip')";
				$result = mysql_query($sql, $conn)
					or die('Error with house number and street:  ' . mysql_error());	
				
				//get new address id value
				$sql = "SELECT * " .
				"FROM rrtable_address " .
				"WHERE userID =" . $userID .
				" AND houseNum =" . $bhouseNum .
				" AND street ='" . $bstreet . "'";
				$result = mysql_query($sql, $conn) or die("shipping error. " .mysql_error());
				while($row=mysql_fetch_array($result))
				{
					$baddressID = $row["addressID"];
				}

			}

			//check if shipping address is in db, if not add it
			

			$sql = "SELECT first, last, addressID, houseNum, street, city, state, rrtable_address.zip " .
			"FROM rrtable_name, rrtable_citystate, rrtable_address " .
			"WHERE rrtable_name.userID = " . $userID .
			" AND rrtable_address.userID = " . $userID .
			" AND rrtable_address.houseNum =" . $shouseNum .
			" AND rrtable_address.street = '" . $sstreet .
			"' AND rrtable_address.zip =" . $szip;
			$result = mysql_query($sql, $conn) or die(mysql_error());
			$rows = mysql_fetch_array($result);
			if($rows["addressID"] == "")
			{
					
				$sql = "INSERT IGNORE INTO rrtable_cityState (zip, city, state)
					VALUES ('$szip', '$scity', '$sstate')";
				$result = mysql_query($sql, $conn)
					or die('Error with city and state:  ' . mysql_error());

				$sql = "INSERT IGNORE INTO rrtable_address (userID, houseNum, street, zip)
				VALUES ('$userID', '$shouseNum', '$sstreet', '$szip')";
				$result = mysql_query($sql, $conn)
					or die('Error with house number and street:  ' . mysql_error());
				
				//get new address id value
				$sql = "SELECT * " .
				"FROM rrtable_address " .
				"WHERE userID =" . $userID .
				" AND houseNum =" . $shouseNum .
				" AND street ='" . $sstreet . "'";
				$result = mysql_query($sql, $conn) or die("shipping error. " .mysql_error());
				while($row=mysql_fetch_array($result))
				{
					$saddressID = $row["addressID"];
				}

			}
			
			
			//call checkout3.php with addressID values passed in session
			unset($_SESSION["baddressID"]);
			unset($_SESSION["saddressID"]);
			$_SESSION["baddressID"] = $baddressID;
			$_SESSION["saddressID"] = $saddressID;
			redirect("checkout3.php");
		}
require_once 'footer.php';?>