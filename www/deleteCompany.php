<?php

	//deleteCompany.php
	
	include_once("htmlUtils.php");
	include_once("dbConnector.php");
	
	//establish connection to db
	$database = new dbConnector();
	$connection = $database->doConnect();
	
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$companyToDelete = $_GET['cid'];
	
	$sql = "DELETE FROM company WHERE cmp_id='$companyToDelete'";
	
	mysqli_query($connection, $sql);
	
	header( "Location: companies.php" );
	mysqli_close($connection);
	die();
?>
	