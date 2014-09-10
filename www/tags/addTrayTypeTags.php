<?php

	//addTrayTypeTags.php
	//this script is for adding new tags to tray types
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	if(isset($_POST['newTag'])) {
	
		$tag = $_POST['newTag'];
		$ttyp = $_POST['ttyp_id'];
		
		$sql = "INSERT INTO ttyp_tag (tag, ttyp_id) VALUES ('$tag', '$ttyp')";
		$worker->query($sql);
		
		$last_page = $_SERVER['HTTP_REFERER'];
	
		header("Location: $last_page");
	
	}
	
	
	
	
	
?>