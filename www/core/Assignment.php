<?php

	#Assignment.php
	
	function __autoload($class_name) {
		include $class_name . '.php';
	}
	
	class Assignment {
	
		private $gremlin;
		
		public $assignmentID;
		public $caseID;
		public $trayID;
		public $doUsr; #User dropping off tray. If == 0, any team member can drop off
		public $puUsr; #User picking up tray. If == 0, any team member can pick up
		public $cliSig; #Name that is entered in the drop off page signature field;
		public $doDTTM; #Time of dropoff
		public $puDTTM; #Time of pickup
		public $status;
		public $cmt;
		
		
		
		public function __construct($assignmentID) {
		
			$this->gremlin = new Gremlin();
			
			#load assignment's info from ID
			$sql = "SELECT * FROM assigns WHERE asgn_id='$assignmentID'";
			
			$rawData = $gremlin->query($sql):
			
			extract($rawData);
			
			$this->assignmentID = $assignmentID;
			$this->caseID = $case_id;
			$this->trayID = $tray_id;
			$this->doUsr = $do_usr;
			$this->puUsr = $pu_usr;
			$this->cliSig = $cli_nm;
			$this->doDTTM = $do_dttm;
			$this->puDTTM = $pu_dttm;
			$this->status = $status;
			$this->cmt = $cmt;
		
		}
	
	
		function __destruct() {
		    $gremlin->closeConnection();
		}
	
	
	
	}
	
	
?>