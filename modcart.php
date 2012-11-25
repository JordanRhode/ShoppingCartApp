<?php //modcart.php
	require_once "conn.php";

	//add new item to cart
	if(isset($_POST["prod-id"])
		and isset($_POST["quantity"])
		and isset($_SESSION["user-id"]))
	{
		$prod_id = $_POST["prod-id"];
		$quantity = $_POST["quantity"];
		$user_id = $_SESSION["user-id"];
		$sql = "SELECT prod-id, quantity " .
				"FROM rrTable_cart " .
				"WHERE user-id=" . $_SESSION("user-id");
		$result = mysql_query($sql, $conn) or
			die("Couldn't retrieve items in cart. " . mysql_error());
		$contains = false;
		while($row = mysql_fetch_array($result))
		{
			if($row["prod-id"] == $prod_id){
				$contains = true;
				$sql2 = "UPDATE rrTable_cart " .
						"SET quantity=" . $quantity .
						"WHERE prod-id=" . $prod_id;
				mysql_query($sql2,$conn) or
					die("couldn't add items in cart. " . mysql_error());
			}
		}
		if($contains == false)
		{
			$sql = "INSERT INTO rrTable_cart " .
				"VALUES ('$user_id', '$prod_id', $quantity')";
				mysql_query($sql,$conn) or
					die("couldn't add items in cart. " . mysql_error());
		}
	}

	//display all items in cart
	if(isset($_SESSION("user-id")))
	{
		$sql = "SELECT prod-id, quantity " .
				"FROM rrTable_cart " .
				"WHERE user-id=" . $_SESSION("user-id");
		$result = mysql_query($sql, $conn) or
			die("Couldn't retrieve items in cart. " . mysql_error());
		if(mysql_num_rows($result) == 0)
		{
			echo "There are currently no items in your cart."
		}
		else
		{
			$xml = simplexml_load_file("assets/xml/productList.xml")
					or die("Unable to lad XML file");

			echo "You currently have " . mysql_num_rows($result) . " product(s) in your cart.";
			echo "<table id='modcart_table'>";
			echo "<tr><td>Quantity</td><td>Item Image</td><td>Item Name</td><td>Price Each</td><td>Extended Price</td></tr>";
			$total;
			foreach ($xml->product as $product) {
				$id = $product->id;
				$name = $product->name;
				$price = $product->price;
				$thumbnail = $product->thumbnail;
				$quan = $product->quantity;
			
				while($row = mysql_fetch_array($result))
				{
					if($id == $row["prod-id"])
					{
						$total += ($price * $row["quantity"]);
						echo "<tr>";
						echo "<td><select>";
						for($q = 0; $q <= $quan; $q++)
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
						echo "</select></td>";
						echo "<td><img src='" . $thumbnail . "' alt='" . $name . "' height='100' width='100'/></td>";
						echo "<td class='product_name'><a href='getprod.php?name=" . $name . "'>" . $name . "</a></td>";
						echo "<td><p>$" . $price . "</p></td>";
						echo "<td><p>$" . $price * $row["quantity"] . "</p></td>";
						//change quantity
						//delete item
						
					}
				}
			}
			echo "<tr><td></td><td></td><td></td><td>Your total before shipping is:</td>";
			echo "<td>$" . $total . "</td>";
			//empty cart
			echo "</table>";
		}
	}
	else 
	{
		echo "Please <a href=#>Login</a> to view your cart.";
	}
?>