<!--  New User  -->
<?php 
	require_once 'header.php';
	require_once 'conn.php';
	
	//if form is not yet submitted
	//display form
	if (!isset($_POST['submit'])){
?>
 
 <h1>Register</h1>
 <h3>Please fill in the information below.  Fields marked with * are required.</h3>       

<form method="post" name="register_form" onSubmit="return validateRegister()"  action="register.php">
        	*First Name:&nbsp;&nbsp;
            <input type="text" name="fName" id="fName" />
            <p>
            *Last Name:&nbsp;&nbsp;
            <input type="text" name="lName" id="lName" />
            <p>
            *Email (this will act as your username):&nbsp;&nbsp;
            <input type="text" name="email" id="email" />
            <p>
            Phone:&nbsp;&nbsp;
            <input type="text" name="phone" id="phone"/>
            <p>Enter an address so you can use it later for billing or shipping.</p>
            <p>
            *House Number:&nbsp;&nbsp;
            <input type="text" name="houseNum" id="houseNum"/>
            <p>
            *Street:&nbsp;&nbsp;
            <input type="text" name="street" id="street"/>
            <p>
            *City:&nbsp;&nbsp;
            <input type="text" name="city" id="city"/>
            <p>
            *State:&nbsp;&nbsp;
            <input type="text" name="state" id="state"/>
            <p>
            *Zip:&nbsp;&nbsp;
            <input type="text" name="zip" id="zip"/>
            <p>
            *Password:&nbsp;&nbsp;
            <input type="password" name="password" id="password"/>
            <p>
            *Re-Enter Password:&nbsp;&nbsp;
            <input type="password" name="password2"  id="password2"/>
            <p>
            <input type="submit" name="submit" value="Register" />
</form>
        
<?php
	//if form is submitted
	//check login credentials
	//against database
	}else{
		//required
		$fName = $_POST['fName'];
		$lName = $_POST['lName'];
		$email = $_POST['email'];
		$houseNum = $_POST['houseNum'];
		$street = $_POST['street'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zip = $_POST['zip'];
		$password = $_POST['password'];
		$confirmPass = $_POST['password2'];
				
		//check input (very simple)
		if (empty($fName)){
			die('ERROR:  Please enter your first name.');
		}
		if (empty($lName)){
			die('ERROR:  Please enter your Last name.');
		}
		if (empty($email)){
			die('ERROR:  Please enter your email.');
		}
		if (empty($houseNum)){
			die('ERROR:  Please enter your house number.');
		}
		if (empty($street)){
			die('ERROR:  Please enter your street.');
		}
		if (empty($city)){
			die('ERROR:  Please enter your city.');
		}
		if (empty($state)){
			die('ERROR:  Please enter your state.');
		}
		if (empty($zip)){
			die('ERROR:  Please enter your zip.');
		}
				
		if (empty($password)){
			die('ERROR:  Please enter your password.');
		}
				
		if (empty($confirmPass)){
			die('ERROR:  Please re-enter your password.');
		}
				
		if ($password != $confirmPass){
			die('ERROR:  Passwords must match.');
		}
				
		$salt = "R4nd0m";
				
		//check if email exists
		$sql = "SELECT email FROM rrtable_user WHERE email = '$email'";
		$result = mysql_query($sql, $conn)
			or die('Could not look up information: ' . mysql_error());		
		if (mysql_num_rows($result) > 0){
			die("Sorry, email already exists.  Please enter a different email.");
		}else{
			//insert data into DB
			$password = crypt($password, $salt);
			
			//add phone if it's set
			if(isset($_POST['phone'])){
				$phone = $_POST['phone'];
			}
			if(!empty($phone)){
				$sql = "INSERT INTO rrtable_user (email, password, phone)
					VALUES ('$email', '$password', '$phone')";
				$result = mysql_query($sql, $conn)
					or die("Could not create account, error with email, password, and phone:  " . mysql_error());
			}else{
				$sql = "INSERT INTO rrtable_user (email, password)
						VALUES ('$email', '$password')";
					
				$result = mysql_query($sql, $conn)
					or die("Could not create account, error with email and password:  " . mysql_error());
			}
		}
		//insert names and address
		$userID = 0;
		$sql = "SELECT userID FROM rrtable_user WHERE email='$email'";
		$result = mysql_query($sql, $conn)
			or die('Could not look up user id:  ' . mysql_error());	
		if($row = mysql_fetch_array($result)){
			$userID = $row['userID'];
		}
		if($userID != 0){
			//name
			$sql = "INSERT INTO rrtable_name (userID, first, last)
				VALUES ('$userID', '$fName', '$lName')";
			$result = mysql_query($sql, $conn)
				or die('Error with name:  ' . mysql_error());
			
			//address	
				
			$sql = "INSERT INTO rrtable_cityState (zip, city, state)
				VALUES ('$zip', '$city', '$state')";
			$result = mysql_query($sql, $conn)
				or die('Error with city and state:  ' . mysql_error());

			$sql = "INSERT INTO rrtable_address (userID, houseNum, street, zip)
				VALUES ('$userID', '$houseNum', '$street', '$zip')";
			$result = mysql_query($sql, $conn)
				or die('Error with house number and street:  ' . mysql_error());
			
		}
	
		echo '<h3>Your account has been created!  Happy Shopping!</h3>';
		echo '<br/><a href="index.php"> Back to products.</a>';		
	}
	require_once 'footer.php';
?>