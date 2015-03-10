<?php

	#AthenaCase.php
	
	function __autoload($class_name) {
		include $class_name . '.php';
	}
	
	
	class AthenaCase {
	
		private $gremlin;
		
		public $caseID;
		public $teamID;
		public $docID;
		public $procID;
		public $siteID;
		public $status;
		public $dttm;
		public $cmt;
		
		#Tray types needed for case
		public $neededTypes = array();
		
		#assignments this case is part of
		public $activeAssignments = array();
		
		public function __construct($caseID) {
		
			$this->gremlin = new Gremlin();
			
			#load case's info from ID
			$sql = "SELECT * FROM cases WHERE case_id='$caseID'";
			
			$rawData = $gremlin->query($sql):
			
			extract($rawData);
			
			$this->caseID = $caseID;
			$this->teamID = $team_id;
			$this->docID = $doc_id;
			$this->procID = $proc_id;
			$this->siteID = $site_id;
			$this->status = $status;
			$this->dttm = $dttm;
			$this->cmt = $cmt;
		
			loadTypes();
			loadActiveAssignments();
		
		}
		
		public function loadTypes() {
		
			$sql = "SELECT ttyp_id FROM case_ttyp WHERE case_id='$caseID'";
			
			$rawResult = $gremlin->query($sql);
			
			foreach($rawResult as $newType) {
			
				$this->neededTypes[] = new TrayType($newType);
			}
		
		}
		
		public function loadActiveAssignments() {
			
			$sql = "SELECT asgn_id FROM assigns WHERE case_id='$caseID' AND NOT status='complete'";
			
			$rawResult = $gremlin->query($sql);
			
			foreach($rawResult as $newType) {
			
				$this->activeAssignments[] = new Assignment($newType);
			}
		
		
		}
	
		function __destruct() {
		    $gremlin->closeConnection();
		}
	
	}
	
	
?>