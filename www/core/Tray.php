<?php

	#Tray.php

	function __autoload($class_name) {
		include $class_name . '.php';
	}
	
	class Tray {
	
		private $gremlin;
	
		public $trayID;
		public $name;
		public $companyID;
		public $teamID:
		public $atNow;
		public $userID;
		public $siteID;
		public $storageID;
		public $loanTeam;
		
		#array of tags
		public $tags = array();
		
		#array of Instrument objects
		public $contents = array();

		
		public function __construct($trayID) {
		
			$gremlin = new Gremlin();
			
			#load tray's info from ID
			$sql = "SELECT * FROM trays WHERE tray_id='$trayID'";
			
			$rawData = $gremlin->query($sql):
			
			extract($rawData);
			
			$this->trayID = $trayID;
			$this->name = $name;
			$this->companyID = $cmp_id;
			$this->teamID = $team_id;
			$this->atNow = $atnow;
			$this->userID = $usr_id;
			$this->siteID = $site_id;
			$this->storageID = $stor_id;
			$this->loanTeam = $loan_team;
			
			loadTags();
			loadContents();
		}
		
		
		
		#returns array of tags relating to this tray
		public function loadTags() {
		
			$sql = "SELECT tag FROM tray_tag WHERE tray_id='$trayID'";
			
			$rawResult = $gremlin->query($sql);
			
			foreach($rawResult as $newTag) {
			
				$this->tags[] = new Tag($tag);
			}
		
		}
	
		public function loadContents() {
		
			$sql = "SELECT inst_id FROM traycont WHERE tray_id='$trayID'";
			
			$rawResult = $gremlin->query($sql);
			
			foreach($rawResult as $newCont) {
			
				$newInstrument = new Instrument($newCont);
			
				$this->contents[] = $newInstrument;
			
			}
		
		}
		
		
		
	
		function __destruct() {
		    $gremlin->closeConnection();
		}
	
	
	}


?>