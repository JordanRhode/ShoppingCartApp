<?php //getprod.php
	require_once "header.php";
?>
	<div id="content">
		<div id="product_info">
			<?php
				if(isset($_GET["name"]))
				{
					$prodName = $_GET['name'];
					
					$xml = simplexml_load_file("assets/xml/productList.xml")
					or die("Unable to lad XML file");
				
					foreach ($xml->product as $product) {
						if($prodName == $product->name){
							$price = $product->price;
							$description = $product->description;
							$quan = $product->quantity;
							$largeImg = $product->large;
						}
					}
					
			?>		
		
		<div id="product_image">
        	<?php
				echo "<img src='" . $largeImg . "' alt='" . $prodName . "' height='400' width='400'/>";
			?>
		</div>
		<div id="product_text">
			<?php
				echo "<h2>" . $prodName . "</h2>";
				echo "<br/>" . $description;
				echo "<br/>$" . $price;
			?>
			<form name="product" action="#" method="post">
					<?php
						if($prodName == "Solution Rock Shoes"){
							echo "Size: <select>";
							for($size = 5; $size <= 14; $size++){
								echo "<option value='" . $size . "'>" . $size . "</option>";
							}
							echo "</select><br/>";
						}
					?>
				Quantity: 
				<select>
					<?php
						for($q = 0; $q <= $quan; $q++){
							echo "<option value='" . $q . "'>" . $q . "</option>";
						}
					?>
				</select>
				<input type="submit" value="Add to cart">
			</form>
		</div>
		</div>
		<?php } 
			require_once "footer.php";
		?>
	</div>