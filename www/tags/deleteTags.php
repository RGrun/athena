<?php

	//deleteTags.php
	//this page is the mechanism for deleting tags
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	if(isset($_GET['del'])) {
		$tagToDelete = $_GET['tag'];
		$companyTag = $_GET['cmp_id'];
		
		$deleteSql = "DELETE FROM tags WHERE tag='$tagToDelete' AND cmp_id='$companyTag'";
		$worker->query($deleteSql);
		
		$deleteSql = "DELETE FROM tray_tag WHERE tag='$tagToDelete'";
		$worker->query($deleteSql);
		
		$deleteSql = "DELETE FROM ttyp_tag WHERE tag='$tagToDelete'";
		$worker->query($deleteSql);
	
		$last_page = $_SERVER['HTTP_REFERER'];
	
		header("Location: $last_page");
	}
	
	
?>