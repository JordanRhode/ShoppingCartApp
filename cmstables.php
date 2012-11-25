<?php //cmstables.php
	require_once "conn.php";

	$sql = <<<EOS
	CREATE TABLE IF NOT EXISTS rrTable_user (
		user-id INT(10) NOT NULL auto_increment default '0',
		email VARCHAR(255) NOT NULL,
		password VARCHAR(50) NOT NULL,
		phone VARCHAR(15) default '000-000-0000'
		PRIMARY KEY (user-id)
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
		user-id INT(10) NOT NULL default '0',
		zip INT(5) NOT NULL default '12345',
		PRIMARY KEY (user-id),
		FOREIGN KEY (user-id) REFERENCES rrTable_user(user-id),
		FOREIGN KEY (zip) REFERENCES rrTable_cityState(zip)
		)
EOS;
		$result = mysql_query($sql) or
			die(mysql_error());

	$sql = <<<EOS
	CREATE TABLE IF NOT EXISTS rrTable_name (
		user-id INT(10) NOT NULL default '0',
		first VARCHAR(50) NOT NULL,
		last VARCHAR(50) NOT NULL,
		PRIMARY KEY (user-id),
		FOREIGN KEY (user-id) REFERENCES rrTable_user(user-id)
		)
EOS;
		$result = mysql_query($sql) or
			die(mysql_error());

	$sql = <<<EOS
	CREATE TABLE IF NOT EXISTS rrTable_address (
		address-id INT(10) NOT NULL default '0' auto_increment,
		user-id INT(10) NOT NULL default '0',
		houseNum VARCHAR(30) NOT NULL,
		street VARCHAR(50) NOT NULL,
		PRIMARY KEY (address-id),
		FOREIGN KEY (user-id) REFERENCES rrTable_user(user-id) 
		)
EOS;
		$result = mysql_query($sql) or
			die(mysql_error());

	$sql = <<<EOS
	CREATE TABLE IF NOT EXISTS rrTable_cart (
		user-id INT(10) NOT NULL default '0',
		prod-id INT(10) NOT NULL default '0',
		quantity INT(5) NOT NULL default '0',
		PRIMARY KEY (user-id, prod-id),
		FOREIGN KEY (user-id) REFERENCES rrTable_user(user-id),
		)
EOS;
		$result = mysql_query($sql) or
			die(mysql_error());

	$sql = <<<EOS
	CREATE TABLE IF NOT EXISTS rrTable_order (
		order-id INT(10) NOT NULL default '0' auto_increment,
		trans-id INT(10) NOT NULL default '0',
		order-date DATE(10) NOT NULL default '00-00-0000',
		sAddress-id INT(10) NOT NULL default '0',
		sZip INT(5) NOT NULL default '12345',
		bAddress-id INT(10) NOT NULL default '0',
		bZip INT(5) NOT NULL default '12345',
		subtotal FLOAT NOT NULL default '0',
		ship-cost FLOAT NOT NULL default '0',
		tax FLOAT NOT NULL default '0',
		total FLOAT NOT NULL default '0',
		PRIMARY KEY (order-id, trans-id),
		FOREIGN KEY (sAddress-id) REFERENCES rrTable_address(address-id),
		FOREIGN KEY (sZip) REFERENCES rrTable_cityState(zip),
		FOREIGN KEY (bAddress-id) REFERENCES rrTable_address(address-id),
		FOREIGN KEY (bZip) REFERENCES rrTable_cityState(zip)
		)
EOS;
		$result = mysql_query($sql) or
			die(mysql_error());

	$sql = <<<EOS
	CREATE TABLE IF NOT EXISTS rrTable_billing (
		bill-id INT(10) NOT NULL default '0' auto_increment,
		order-id INT(10) NOT NULL default '0',
		PRIMARY KEY (bill-id),
		FOREIGN KEY (order-id) REFERENCES rrTable_order(order-id)
		)
EOS;
		$result = mysql_query($sql) or
			die(mysql_error());

	$sql = <<<EOS
	CREATE TABLE IF NOT EXISTS rrTable_shipping (
		ship-id INT(10) NOT NULL default '0' auto_increment,
		order-id INT(10) NOT NULL default '0',
		date-shipped DATE(10) NOT NULL default '00-00-0000',
		PRIMARY KEY(ship-id),
		FOREIGN KEY(order-id) REFERENCES rrTable_order(order-id)
		)
EOS;
		$result = mysql_query($sql) or
			die(mysql_error());

	$sql = <<<EOS
	CREATE TABLE IF NOT EXISTS rrTable_transactions (
		trans-id INT(10) NOT NULL default '0',
		line-num INT(10) NOT NULL default '0',
		user-id INT(10) NOT NULL default '0',
		prod-id INT(10) NOT NULL default '0',
		quantity INT(5) NOT NULL default '0',
		PRIMARY KEY(order-id, line-num, user-id),
		FOREIGN KEY (user-id) REFERENCES rrTable_user(user-id),
		FOREIGN KEY (order-id) REFERENCES rrTable_order(order-id)
		)
EOS;
		$result = mysql_query($sql) or
			die(mysql_error());
