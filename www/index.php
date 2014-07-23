<?php

	//index.php
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";

	
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	echo "<p>Welcome to Athena. Please select a table to view from the list.</p>";
	
	$htmlUtils->makeFooter();
	
?>