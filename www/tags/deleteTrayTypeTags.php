<?php

	//deleteTrayTypeTags.php
	//script for deleting tags from tray types

	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	if(isset($_GET['del'])) {
		$tagToDelete = $_GET['tag'];
		$ttyp_id = $_GET['ttyp_id'];
		
		$deleteSql = "DELETE FROM ttyp_tag WHERE tag='$tagToDelete' AND ttyp_id='$ttyp_id'";
		$worker->query($deleteSql);
	
		$last_page = $_SERVER['HTTP_REFERER'];
	
		header("Location: $last_page");
	}
	



?>