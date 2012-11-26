<?php //logout.php
	require_once "conn.php";
	require_once "http.php";
	session_start();
	session_unset();
	session_destroy();
	redirect("index.php");
?>