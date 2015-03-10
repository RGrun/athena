<?php

	#TrayType.php
	
	function __autoload($class_name) {
		include $class_name . '.php';
	}
	
	class TrayType {
	
		private $gremlin;
		
		public $typeID;
		public $name;
		public $companyID; 
		public $teamID;
		
		#these are the tags that belong to the try type
		public $tags = array();
		
		public function __construct($typeID) {
		
			$this->gremlin = new Gremlin();
			
			#load ttyp's info from ID
			$sql = "SELECT * FROM ttyp WHERE ttyp_id='$typeID'";
			
			$rawData = $gremlin->query($sql):
			
			extract($rawData);
			
			$this->typeID = $typeID;
			$this->name = $name;
			$this->companyID = $cmp_id;
			$this->teamID = $team_id;
		
			loadTags();
		
		}
		
		
		public function loadTags() {
		
			$sql = "SELECT tag FROM ttyp_tag WHERE ttyp_id='$typeID'";
			
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