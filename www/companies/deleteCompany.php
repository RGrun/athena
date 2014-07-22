<?php

	//deleteCompany.php
	
	include_once("includes.php");
	
	//establish connection to db
	$database = new dbConnector();
	$connection = $database->doConnect();
	
	$companyToDelete = $_GET['cid'];
	
	$sql = "DELETE FROM company WHERE cmp_id='$companyToDelete'";
	
	mysqli_query($connection, $sql);
	
	header( "Location: companies.php" );
	mysqli_close($connection);
	die();
?>
	