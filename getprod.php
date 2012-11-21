<?php //getprod.php
	require_once "header.php";
?>
	<div id="content">
		<div id="product_info">
			<?php
				if(isset($_GET["name"]))
				{
					$prodName = $_GET['name'];
					echo "<p>" . $prodName . "</p>";
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
					echo "<br/>" . $description;
					echo "<br/>$" . $price;
			?>		
		</div>
		<div id="product_image">
        	<?php
				echo "<img src='" . $largeImg . "' alt='" . $prodName . "' height='400' width='400'/>";
			?>
		</div>
		<?php } 
			require_once "footer.php";
		?>
	</div>