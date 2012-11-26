<!--  Checkout2.php  -->
<?php
	require_once 'header.php';
	require_once 'conn.php';
?>
<p>Step 1 - Please Enter Billing and Shipping Information <br/>
<h5>Step 2 - Please Verify Accuracy and Make Any Neccessary Changes </h5>
Step 3 - Order Confirmation and Receipt<br/><br/>

<!--  Get address id's for billing and shipping, then set variables  -->

<div id="billingForm">
	<form id="addressForm" name="addressForm" method="post" action="checkout.php">
		<h3>Billing Information</h3>
        	First Name:&nbsp;&nbsp;
            <input type="text" id="bfName" name="bfName" value="" />
            <p>
            Last Name:&nbsp;&nbsp;
            <input type="text" id="blName" name="blName" value=""/>
            <p>
            House Number:&nbsp;&nbsp;
            <input type="text" id="bhouseNum" name="bhouseNum" value=""/>
            <p>
            Street:&nbsp;&nbsp;
            <input type="text" id="bstreet" name="bstreet" value=""/>
            <p>
            City:&nbsp;&nbsp;
            <input type="text" id="bcity" name="bcity" value=""/>
            <p>
            State:&nbsp;&nbsp;
            <input type="text" id="bstate" name="bstate" value=""/>
            <p>
            Zip:&nbsp;&nbsp;
            <input type="text" id="bzip" name="bzip" value=""/>
            <p>
            <input type="hidden" id="baddressID" name="baddressID" value=""/>
</div>
<div id="shippingForm">
	<h3>Shipping Information</h3>
		
			First Name:&nbsp;&nbsp;
            <input type="text" id="sfName" name="sfName"/>
            <p>
            Last Name:&nbsp;&nbsp;
            <input type="text" id="slName" name="slName"/>
            <p>
            House Number:&nbsp;&nbsp;
            <input type="text" id="shouseNum" name="shouseNum" />
            <p>
            Street:&nbsp;&nbsp;
            <input type="text" id="sstreet" name="sstreet"/>
            <p>
            City:&nbsp;&nbsp;
            <input type="text" id="scity" name="scity"/>
            <p>
            State:&nbsp;&nbsp;
            <input type="text" id="sstate" name="sstate"/>
            <p>
            Zip:&nbsp;&nbsp;
            <input type="text" id="szip" name="szip"/>
            <p>
            <input type="hidden" id="saddressID" name="saddressID"/>
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
				echo "<td class='product_name'><a href='getprod.php?name=" . $name . "'>" . $name . "</a></td>";
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