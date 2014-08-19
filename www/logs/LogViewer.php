<?php

	//LogViewer.php
	//This class is meant to abstract out the common features of log pages
	//similar to how htmlUtils abstracts out the header and nav
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	class LogViewer {
	
		private $htmlUtils;
		private $worker;
		
		private $pageNo;
		private $tableName;
		
		private $pageUrl = $_SERVER['PHP_SELF'];
		private $fullLeftBtn = "<input type='button' name='left' value='&#171;'/>";
		private $leftBtn = "<input type='button' name='left' value='<'/>";
		private $fullRightBtn = "<input type='button' name='right' value='&#187;'/>";
		private $rightBtn = "<input type='button' name='right' value='>'/>";
		private $pageBox = "<textarea name='pageno' rows='1' cols='1'>$pageNo</textarea>";
		
		private $logView = "<div class='logTableNav'>" .
		"<span class='logTableName'>$tableName</span>" .
		"<div id='pageControls'><form method='get' action='$pageUrl'>" .
		"$fullLeftBtn $leftBtn $pageBox $rightBtn $fullRightBtn" .
		"</form></div>";
	
		public __construct($table, $page = 1) {
		
			$htmlUtils = new htmlUtils();
			$worker = new dbWorker();
			
			$pageNo = $page;
			$tableName = $table;
			
			$htmlUtils->makeHeader();
			
			echo $logView;
			
			
		
		}
	
	
		//unsure if I will use this later
	    /*
		private function makeTable($table, $page = 1) {
		
			$tableToPrint = "<div class='logTable'>$logView";
			
			$offset = $page * 10;
			$offsetBase = $offset - 10;
			
			if($page == 1) $sql = "SELECT * FROM $table LIMIT 10";
			else $sql = "SELECT * FROM $table LIMIT $offsetBase, $offset";
			
			$result = $worker->query($sql);
			
			while ($row = mysqli_fetch_assoc($result)) {
			
				foreach ($row as $column => $data) {
				
					
				
				
				}
			
			
			} */
		
		
		
		}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	}