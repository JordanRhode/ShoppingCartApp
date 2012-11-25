<?php //cmstables.php
	require_once "conn.php";

	$sql = <<<EOS
	CREATE TABLE IF NOT EXISTS rrTable_user (
		userID INT(10) NOT NULL auto_increment UNIQUE,
		email VARCHAR(255) NOT NULL UNIQUE,
		password VARCHAR(50) NOT NULL,
		phone VARCHAR(15) default '000-000-0000',
		PRIMARY KEY (userID)
		)
EOS;
		$result = mysql_query($sql) or
			die(mysql_error());

	$sql = <<<EOS
	CREATE TABLE IF NOT EXISTS rrTable_cityState (
		zip INT(5) NOT NULL default '12345',
		city VARCHAR(255) NOT NULL,
		state VARCHAR(255) NOT NULL,
		PRIMARY KEY (zip)
		)
EOS;
		$result = mysql_query($sql) or 
			die(mysql_error());

	$sql = <<<EOS
	CREATE TABLE IF NOT EXISTS rrTable_zip (
		userID INT(10) NOT NULL default '0',
		zip INT(5) NOT NULL default '12345',
		PRIMARY KEY (userID),
		FOREIGN KEY (userID) REFERENCES rrTable_user(userID),
		FOREIGN KEY (zip) REFERENCES rrTable_cityState(zip)
		)
EOS;
		$result = mysql_query($sql) or
			die(mysql_error());

	$sql = <<<EOS
	CREATE TABLE IF NOT EXISTS rrTable_name (
		userID INT(10) NOT NULL default '0',
		first VARCHAR(50) NOT NULL,
		last VARCHAR(50) NOT NULL,
		PRIMARY KEY (userID),
		FOREIGN KEY (userID) REFERENCES rrTable_user(userID)
		)
EOS;
		$result = mysql_query($sql) or
			die(mysql_error());

	$sql = <<<EOS
	CREATE TABLE IF NOT EXISTS rrTable_address (
		addressID INT(10) NOT NULL auto_increment,
		userID INT(10) NOT NULL default '0',
		houseNum VARCHAR(30) NOT NULL,
		street VARCHAR(50) NOT NULL,
		PRIMARY KEY (addressID),
		FOREIGN KEY (userID) REFERENCES rrTable_user(userID) 
		)
EOS;
		$result = mysql_query($sql) or
			die(mysql_error());

	$sql = <<<EOS
	CREATE TABLE IF NOT EXISTS rrTable_cart (
		userID INT(10) NOT NULL default '0',
		prodID INT(10) NOT NULL default '0',
		quantity INT(5) NOT NULL default '0',
		PRIMARY KEY (userID, prodID),
		FOREIGN KEY (userID) REFERENCES rrTable_user(userID)
		)
EOS;
		$result = mysql_query($sql) or
			die(mysql_error());

	$sql = <<<EOS
	CREATE TABLE IF NOT EXISTS rrTable_order (
		orderID INT(10) NOT NULL auto_increment,
		transID INT(10) NOT NULL default '0',
		orderDate DATE NOT NULL default '00-00-0000',
		sAddressID INT(10) NOT NULL default '0',
		sZip INT(5) NOT NULL default '12345',
		bAddressID INT(10) NOT NULL default '0',
		bZip INT(5) NOT NULL default '12345',
		subtotal FLOAT NOT NULL default '0',
		shipCost FLOAT NOT NULL default '0',
		tax FLOAT NOT NULL default '0',
		total FLOAT NOT NULL default '0',
		PRIMARY KEY (orderID, transID),
		FOREIGN KEY (sAddressID) REFERENCES rrTable_address(addressID),
		FOREIGN KEY (sZip) REFERENCES rrTable_cityState(zip),
		FOREIGN KEY (bAddressID) REFERENCES rrTable_address(addressID),
		FOREIGN KEY (bZip) REFERENCES rrTable_cityState(zip)
		)
EOS;
		$result = mysql_query($sql) or
			die(mysql_error());

	$sql = <<<EOS
	CREATE TABLE IF NOT EXISTS rrTable_billing (
		billID INT(10) NOT NULL auto_increment,
		orderID INT(10) NOT NULL default '0',
		PRIMARY KEY (billID),
		FOREIGN KEY (orderID) REFERENCES rrTable_order(orderID)
		)
EOS;
		$result = mysql_query($sql) or
			die(mysql_error());

	$sql = <<<EOS
	CREATE TABLE IF NOT EXISTS rrTable_shipping (
		shipID INT(10) NOT NULL auto_increment,
		orderID INT(10) NOT NULL default '0',
		dateShipped DATE NOT NULL default '00-00-0000',
		PRIMARY KEY(shipID),
		FOREIGN KEY(orderID) REFERENCES rrTable_order(orderID)
		)
EOS;
		$result = mysql_query($sql) or
			die(mysql_error());

	$sql = <<<EOS
	CREATE TABLE IF NOT EXISTS rrTable_transactions (
		transID INT(10) NOT NULL default '0',
		lineNum INT(10) NOT NULL default '0',
		userID INT(10) NOT NULL default '0',
		prodID INT(10) NOT NULL default '0',
		quantity INT(5) NOT NULL default '0',
		PRIMARY KEY(transID, lineNum, userID),
		FOREIGN KEY (userID) REFERENCES rrTable_user(userID)
		)
EOS;
		$result = mysql_query($sql) or
			die(mysql_error());
