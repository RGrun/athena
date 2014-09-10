<?php

	//deleteTrayTags.php
	//for deleting tags from trays
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	if(isset($_GET['del'])) {
	
		$tag = $_GET['tag'];
		$tray = $_GET['tray_id'];
		
		$sql = "DELETE FROM tray_tag WHERE tray_id='$tray' AND tag='$tag'";
		echo $sql;
		$worker->query($sql);
		
		$last_page = $_SERVER['HTTP_REFERER'];
	
		header("Location: $last_page");
	
	}
	
	
	
?>