 <?php

	//addProcTags.php
	//for adding new tags to procedures
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	if(isset($_POST['newTag'])) {
	
		$tag = $_POST['newTag'];
		$tray = $_POST['procedure'];
		
		$sql = "INSERT INTO proc_tag (tag, proc_id) VALUES ('$tag', '$tray')";
		$worker->query($sql);
		
		$last_page = $_SERVER['HTTP_REFERER'];
	
		header("Location: $last_page");
	
	}
	
	
	
?>