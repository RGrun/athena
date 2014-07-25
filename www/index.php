<?php

	//index.php
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";

	
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	if(isset($_GET['a'])) {
		echo "Login error, please try again";
	} else {
		echo "Welcome to Athena, please select a table from the list to view it.";
	}
	
	
	$htmlUtils->makeFooter();
	
?>