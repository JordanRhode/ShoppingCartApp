<?php //modcart.php
	require_once "conn.php";
	require_once "header.php";
?>
<div id="cart_info">
<?php
	//add new item to cart
	if(isset($_POST["prodID"])
		and isset($_POST["quantity"])
		and isset($_SESSION["userID"]))
	{
		$prodID = $_POST["prodID"];
		$quantity = $_POST["quantity"];
		$userID = $_SESSION["userID"];

		$sql = "SELECT prodID, quantity " .
				"FROM rrTable_cart " .
				"WHERE userID=" . $userID;
		$result = mysql_query($sql, $conn) or
			die("Couldn't retrieve items in cart. " . mysql_error());
		$contains = false;
		while($row = mysql_fetch_array($result))
		{
			if($row["prodID"] == $prodID){
				$contains = true;
				if($quantity == 0){
					$sql = "DELETE FROM rrTable_cart " .
							"WHERE (userID=".$userID.") and (prodID=".$prodID.")";
					mysql_query($sql,$conn) or
						die("Couldn't delete item from cart. " . mysql_error());
					echo "Item removed from cart.<br/>";
				}
				else
				{
					$sql = "UPDATE rrTable_cart " .
						"SET quantity=" . $quantity .
						" WHERE (userID=".$userID.") and (prodID=".$prodID.")";
			
					mysql_query($sql,$conn) or
						die("couldn't update items in cart. " . mysql_error());
					echo "Cart Updated.<br/>";
				}
			}
		}
		if($contains == false)
		{
			$sql = "INSERT INTO rrTable_cart " .
				"VALUES ('$userID', '$prodID', '$quantity')";
				mysql_query($sql,$conn) or
					die("couldn't add items in cart. " . mysql_error());
			echo "Cart Updated.<br/>";
		}
	}

	//display all items in cart
	 if(isset($_SESSION["userID"]))
	 {
	 	echo "<a href='index.php'><-- Back to products</a>";
	 	$userID = $_SESSION["userID"];
		$sql = "SELECT prodID, quantity " .
				"FROM rrTable_cart " .
				"WHERE userID=" . $userID;
		$result = mysql_query($sql, $conn) or
			die("Couldn't retrieve items in cart. " . mysql_error());
		if(mysql_num_rows($result) == 0)
		{
			echo "<p>There are currently no items in your cart.</p>";
		}
		else
		{
			$xml = simplexml_load_file("assets/xml/productList.xml")
					or die("Unable to lad XML file");

			echo "<p>You currently have " . mysql_num_rows($result) . " product(s) in your cart.</p>";
			echo "<table id='modcart_table'>";
			echo "<tr><td>Item Image</td><td>Item Name</td><td>Price Each</td><td>Extended Price</td><td>Quantity</td></tr>";
			$total = 0;
				
				while($row = mysql_fetch_array($result))
				{
					foreach ($xml->product as $product) {
						$id = $product->attributes()->id;
						$name = $product->name;
						$price = $product->price;
						$thumbnail = $product->thumbnail;
						$quan = $product->quantity;
					

					if($id == $row["prodID"])
					{
						$total += ($price * $row["quantity"]);
						echo "<tr>";
						echo "<td><img src='" . $thumbnail . "' alt='" . $name . "' height='100' width='100'/></td>";
						echo "<td class='product_name'><a href='getprod.php?name=" . $name . "'>" . $name . "</a></td>";
						echo "<td><p>$" . $price . "</p></td>";
						echo "<td><p>$" . $price * $row["quantity"] . "</p></td>";
						echo "<td><form name='product".$id."' action='modcart.php' method='post'>";
						echo "<input type='hidden' name='prodID' value='".$id."'/>";
						echo "<select id='quantity_select' name='quantity'>";

						for($q = 1; $q <= $quan; $q++)
						{
							if($q == $row["quantity"])
							{
								echo "<option selected='selected' value='" . $q . "'>" . $q . "</option>";
							}
							else 
							{
								echo "<option value='" . $q . "'>" . $q . "</option>";
							}
						}
						echo "</select><br/><input type='submit' value='Update Quantity'/></form>";
						echo "<form name='deleteItem' action='modcart.php' method='post'>";
						echo "<input type='hidden' name='prodID' value='".$id."'/>";
						echo "<input type='hidden' name='quantity' value='0'/>";
						echo "<input type='submit' value='Delete Item'/></form></td>";
					}
				}
			}
			echo "<tr><td></td><td></td><td>Total before shipping:</td>";
			echo "<td>$" . $total . "</td>";
			//empty cart
			echo "<td><form action='emptycart.php' method='post'>";
			echo "<input type='submit' value='Empty Cart'/></form></td>";
			echo "</table>";

			echo "<div id='checkoutBtn1'><a href='selectaddress.php'>Proceed to checkout</a></div>";
		}
	}
	 else 
	 {
	 	echo "Please <a href=#>Login</a> to view or add items to your cart.";
	 }
?>
</div>
<?php
	require_once "footer.php";
?>