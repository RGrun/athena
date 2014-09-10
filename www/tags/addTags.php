<?php

	//addTags.php
	//for adding new tags to trays
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	if(isset($_POST['newTag'])) {
	
		$tag = $_POST['newTag'];
		$tray = $_POST['tray'];
		
		$sql = "INSERT INTO tray_tag (tag, tray_id) VALUES ('$tag', '$tray')";
		$worker->query($sql);
		
		$last_page = $_SERVER['HTTP_REFERER'];
	
		header("Location: $last_page");
	
	}
	
	
	
?>