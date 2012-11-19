<?php //getprod.php
	require_once "header.php";
?>
	<div id="content">
		<div id="product_info">
			<?php
				if(isset($_GET["name"]))
				{
					echo "<p>" . $_GET["name"] . "</p>";
					$xml = simplexml_load_file("assets/xml/productList.xml")
					or die("Unable to lad XML file");
				
			?>		
		</div>
		<div id="product_image">
		</div>
		<?php } 
			require_once "footer.php";
		?>
	</div>