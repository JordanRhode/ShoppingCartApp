<?php //index.php
	require_once "header.php";
?>
	<div id="content">
		<table id="product_list_table">
			<?php
				$xml = simplexml_load_file("assets/xml/productList.xml")
					or die("Unable to lad XML file");

				foreach ($xml->product as $product) {
					$name = $product->name;
					$price = $product->price;
					$thumbnail = $product->thumbnail;
					$description = $product->description;
					echo "<tr>";
					echo "<td><img src='" . $thumbnail . "' alt='" . $name . "' height='100' width='100'/></td>";
					echo "<td class='product_name'><a href='getprod.php?name=" . $name . "'>" . $name . "</a></td>";
					//echo "<td><p>" . $description . "</p></td>";
					echo "<td><p>$" . $price . "</p></td>";
					echo "</tr>"; 
				}
			?>
		</table>
	</div>
<?php
	require_once "footer.php";
?>