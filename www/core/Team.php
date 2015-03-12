<?
	#Team.php
	
	include_once "Gremlin.php";
	include_once "User.php";
	
	class Team {
	
		private $gremlin;
		
		public $teamID;
		public $name;
		public $region;
		public $state;
		public $companyID; #Belongs to this company. Value of 0 indicates it belongs to no one
		public $headID; #Team Leader. Value of 0 indicates no leader is assigned
		
		
		#array holds team member's IDs
		public $members = array();
		
		
		public function __construct($teamID) {
			
			$this->gremlin = new Gremlin();
			
			#load teams's info from ID
			$sql = "SELECT * FROM teams WHERE team_id='$teamID'";
			
			$rawData = $gremlin->query($sql):
			
			extract($rawData);
			
			$this->teamID = $teamID;
			$this->name = $name;
			$this->region = $region;
			$this->state = $state;
			$this->companyID = $cmp_id;
			$this->headID = $headID;
			
			loadMembers();
		
		}
		
		
		public function loadMembers() {
		
			$sql = "SELECT usr_id FROM users WHERE team_id='$teamID'";
			
			$rawResult = $gremlin->query($sql);
			
			foreach($rawResult as $newCont) {
			
				$newUser = new User($newCont);
			
				$this->members[] = $newUser;
			
			}
		
		}
		
		function __destruct() {
		    $gremlin->closeConnection();
		}
		
	
	
	}



?>