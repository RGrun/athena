<?php

	//deleteProcTags.php
	//this page is the mechanism for deleting procedure tags
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	if(isset($_GET['del'])) {
		$tagToDelete = $_GET['tag'];
		$proc_id = $_GET['proc_id'];
		
		$deleteSql = "DELETE FROM proc_tag WHERE tag='$tagToDelete' AND proc_id='$proc_id'";
		$worker->query($deleteSql);
	
		$last_page = $_SERVER['HTTP_REFERER'];
	
		header("Location: $last_page");
	}
	
	
?>