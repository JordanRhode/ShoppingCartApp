<?php //checkout.php
	require_once "conn.php";
	require_once "header.php";

	if(!isset($_POST["submit"])
		and isset($_SESSION['userID']))
	{
		$userID = $_SESSION["userID"];
		
		$addressID = 1;

		$sql = "SELECT first, last, addressID, houseNum, street, city, state, rrtable_address.zip " .
		"FROM rrtable_name, rrtable_citystate, rrtable_address " .
		"WHERE rrtable_name.userID = " . $userID .
		" AND rrtable_address.addressID = " . $addressID .
		" AND rrtable_address.userID = " . $userID .
		" AND rrtable_citystate.zip = rrtable_address.zip";
		$result = mysql_query($sql, $conn) or die(mysql_error());
		while($row=mysql_fetch_array($result))
		{
			$fname = $row["first"];
			$lname = $row["last"];
			$houseNum = $row["houseNum"];
			$street = $row["street"];
			$city = $row["city"];
			$state = $row["state"];
			$zip = $row["zip"];
			$addressID = $row["addressID"];
		}
?>

<div id="billingForm">
	<form id="addressForm" name="addressForm" method="post" action="checkout.php">
		<h3>Billing Information</h3>
        	First Name:&nbsp;&nbsp;
            <input type="text" id="bfName" name="bfName" value="<?php echo $fname; ?>" />
            <p>
            Last Name:&nbsp;&nbsp;
            <input type="text" id="blName" name="blName" value="<?php echo $lname; ?>"/>
            <p>
            House Number:&nbsp;&nbsp;
            <input type="text" id="bhouseNum" name="bhouseNum" value="<?php echo $houseNum; ?>"/>
            <p>
            Street:&nbsp;&nbsp;
            <input type="text" id="bstreet" name="bstreet" value="<?php echo $street; ?>"/>
            <p>
            City:&nbsp;&nbsp;
            <input type="text" id="bcity" name="bcity" value="<?php echo $city; ?>"/>
            <p>
            State:&nbsp;&nbsp;
            <input type="text" id="bstate" name="bstate" value="<?php echo $state; ?>"/>
            <p>
            Zip:&nbsp;&nbsp;
            <input type="text" id="bzip" name="bzip" value="<?php echo $zip; ?>"/>
            <p>
            <input type="hidden" id="baddressID" name="baddressID" value="<?php echo $addressID; ?>"/>
</div>
<div id="shippingForm">
	<h3>Shipping Information</h3>
		
		<input type="checkbox" id="checkShipping"  onclick="validate()">Same as billing?<br/>
		
		<script type="text/javascript">
			function validate(){
			if (document.getElementById('checkShipping').checked){
			          document.getElementById("sfName").value = document.getElementById("bfName").value;
			          document.getElementById("slName").value = document.getElementById("blName").value;
			          document.getElementById("shouseNum").value = document.getElementById("bhouseNum").value;
			          document.getElementById("sstreet").value = document.getElementById("bstreet").value;
			          document.getElementById("scity").value = document.getElementById("bcity").value;
			          document.getElementById("sstate").value = document.getElementById("bstate").value;
			          document.getElementById("szip").value = document.getElementById("bzip").value;
			          document.getElementById("saddressID").value = document.getElementById("baddressID").value;
			}else{
				document.getElementById("sfName").value = "";
	          	document.getElementById("slName").value = "";
	          	document.getElementById("shouseNum").value = "";
	          	document.getElementById("sstreet").value = "";
         	 	document.getElementById("scity").value = "";
	          	document.getElementById("sstate").value = "";
	          	document.getElementById("szip").value = "";
	          	document.getElementById("saddressID").value = "";
			}
			}
		</script>
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
	<input type="submit" name="submit" value="Submit"/>
	</form>
<?php
	}
	else
	{
		if($_POST["saddressID"] != ""){
			//call checkout2.php with addressID values
			echo $_POST["bfName"] . "<br/>";
			echo $_POST["blName"] . "<br/>";
			echo $_POST["bhouseNum"] . "<br/>";
			echo $_POST["bstreet"] . "<br/>";
			echo $_POST["bcity"] . "<br/>";
			echo $_POST["bstate"] . "<br/>";
			echo $_POST["bzip"] . "<br/>";

			echo $_POST["sfName"] . "<br/>";
			echo $_POST["slName"] . "<br/>";
			echo $_POST["shouseNum"] . "<br/>";
			echo $_POST["sstreet"] . "<br/>";
			echo $_POST["scity"] . "<br/>";
			echo $_POST["sstate"] . "<br/>";
			echo $_POST["szip"] . "<br/>";
		}
		else
		{
			//add new address to db
		}

	}
	require_once "footer.php";
?>