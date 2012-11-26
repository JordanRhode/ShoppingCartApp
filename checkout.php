<?php //checkout.php
	require_once "conn.php";
	require_once "header.php";
	require_once "http.php";
?>

<p><b>Step 1 - Please Enter Billing and Shipping Information</b><br/>
Step 2 - Please Verify Accuracy and Make Any Neccessary Changes<br/>
Step 3 - Order Confirmation and Receipt<br/>
<?php

	if(!isset($_POST["submit"])
		and isset($_SESSION['userID']))
	{
		$userID = $_SESSION["userID"];
		$addressID = $_POST["addressID"];

		//gets selected address from db and puts it in the billing form
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
		
		<!-- This script is used to disable/enable the shipping  form as well as auto fill the info -->
		<script type="text/javascript">
			function validate()
			{
				if (document.getElementById('checkShipping').checked)
				{
				          document.getElementById("sfName").value = document.getElementById("bfName").value;
				          document.getElementById("slName").value = document.getElementById("blName").value;
				          document.getElementById("shouseNum").value = document.getElementById("bhouseNum").value;
				          document.getElementById("sstreet").value = document.getElementById("bstreet").value;
				          document.getElementById("scity").value = document.getElementById("bcity").value;
				          document.getElementById("sstate").value = document.getElementById("bstate").value;
				          document.getElementById("szip").value = document.getElementById("bzip").value;
				          document.getElementById("saddressID").value = document.getElementById("baddressID").value;
				          document.getElementById("sfName").disabled = true;
				          document.getElementById("slName").disabled = true;
				          document.getElementById("shouseNum").disabled = true;
				          document.getElementById("sstreet").disabled = true;
				          document.getElementById("scity").disabled = true;
				          document.getElementById("sstate").disabled = true;
				          document.getElementById("szip").disabled = true;
				}
				else
				{
					document.getElementById("sfName").value = "";
		          	document.getElementById("slName").value = "";
		          	document.getElementById("shouseNum").value = "";
		          	document.getElementById("sstreet").value = "";
	         	 	document.getElementById("scity").value = "";
		          	document.getElementById("sstate").value = "";
		          	document.getElementById("szip").value = "";
		          	document.getElementById("saddressID").value = "";
		          	document.getElementById("sfName").disabled = false;
				    document.getElementById("slName").disabled = false;
				    document.getElementById("shouseNum").disabled = false;
				    document.getElementById("sstreet").disabled = false;
				    document.getElementById("scity").disabled = false;
				    document.getElementById("sstate").disabled = false;
				    document.getElementById("szip").disabled = false;
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
			if($saddressID == "")
			{

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
			}
			
			//call checkout2.php with addressID values passed in session
			$_SESSION["baddressID"] = $baddressID;
			$_SESSION["saddressID"] = $saddressID;
			redirect("checkout2.php");

	}
	require_once "footer.php";
?>