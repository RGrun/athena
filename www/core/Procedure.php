<?php

	#Procedure.php
	
	include_once "Gremlin.php";
	include_once "Tag.php";
	
	class Procedure {
	
		private $gremlin;
		
		public $procedureID;
		public $companyID;
		public $name;
		
		#tags this procedure has
		public $tags = array();
		
		public function __construct($procedureID) {
		
			$this->gremlin = new Gremlin();
			
			#load proc's info from ID
			$sql = "SELECT * FROM procs WHERE proc_id='$procedureID'";
			
			$rawData = $gremlin->query($sql);
			
			extract($rawData);
			
			$this->procedureID = $procedureID;
			$this->companyID = $companyID;
			$this->name = $name;
		
			loadTags();
		
		}
		
		
		public function loadTags() {
		
			$sql = "SELECT tag FROM proc_tag WHERE proc_id='$procedureID'";
			
			$rawResult = $gremlin->query($sql);
			
			foreach($rawResult as $newTag) {
			
				$this->tags[] = new Tag($tag);
			}
		
		}
		
		
		
		function __destruct() {
		    $gremlin->closeConnection();
		}
	
	
	
	
	}
	
	
?>