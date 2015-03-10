<?php

	#User.php
	#This class encapsulates both Users and Clients
	
	function __autoload($class_name) {
		include $class_name . '.php';
	}
	
	class User {
	
		public static $TYPE_USER = 0;
		public static $TYPE_CLIENT = 1;
	
		private $gremlin;
	
		public $type; #Either $TYPE_USER or $TYPE_CLIENT
		public $ID;
		public $active;
		public $teamID; #-1 for clients (clients have no teams)
		public $fname;
		public $lname;
		public $uname;
		public $email;
		public $phone;
		public $sms;
		public $perm;
		
		#array holding a user's companies. Will be empty if user is a client
		public $companies = array();
		
		#booleans
		public $isTeamLeader;
		public $isAdmin;
		
		
		public function __construct($userClientID, $type) {
		
			$this->gremlin = new Gremlin();
		
			if($type == self::$TYPE_USER) {
			
				loadUserData($userClientID);
			
			
			} else if($type == self::$TYPE_CLIENT) {
				
				loadClientData($userClientID);
			
			}
				
		
		}
		
		
		private function loadUserData($userID) {
			
			#load users's info from ID
			$sql = "SELECT * FROM users WHERE usr_id='$userID'";
			
			$rawData = $gremlin->query($sql):
			
			extract($rawData);
			
			$this->type = self::$TYPE_USER;
			$this->ID = $userID;
			$this->active = $active;
			$this->teamID = $team_id;
			$this->fname = $fname;
			$this->lname = $lname;
			$this->uname = $uname;
			$this->email = $email;
			$this->phone = $phone;
			$this->sms = $sms;
			
			#check permissions
			if(preg_match("/admin/i", $perm) == TRUE) { $this->isAdmin = TRUE; }
			else { $this->isAdmin = FALSE; }
			
			#figure out user's companies, to be stored in array, needed for tagging info
			$companySql = "SELECT * FROM usr_cmp WHERE usr_id='$ID'";	

			$companyResult = $gremlin->query($companySql);
			
			foreach ($companyResult as $newCompany) {
			
				$this->companies[] = $newCompany;
			
			}
			
			#Is this user a team leader?
			$TLSql = "SELECT team_id FROM teams WHERE head_id='$ID'";
			
			$TLResult = $gremlin->query($TLSql);
			
			if(!empty($TLResult)) {
				$this->isTeamLeader = TRUE;
			} else {
				$this->isTeamLeader = FALSE;
			}
		
		}
		
		
		private function loadClientData($clientID) {
		
			#load clients's info from ID
			$sql = "SELECT * FROM clients WHERE cli_id='$clientID'";
			
			$rawData = $gremlin->query($sql):
			
			extract($rawData);
			
			$this->type = self::$TYPE_CLIENT;
			$this->ID = $clientID;
			$this->active = $active;
			$this->teamID = -1;
			$this->fname = $fname;
			$this->lname = $lname;
			$this->uname = $uname;
			$this->email = $email;
			$this->phone = $phone;
			$this->sms = $sms;
			
			#check permissions
			if(preg_match("/admin/i", $perm) == TRUE) { $this->isAdmin = TRUE; }
			else { $this->isAdmin = FALSE; }
			
			#clients can't be team leaders
			$this->isTeamLeader = FALSE;
		
		}
		
		
		#returns a boolean. If true, password is correct.
		public static function checkPassword($userID, $rawPW) {
		
			$gremlin = new Gremlin();
		
			#salting password
			$pass = "!@#$rawPW!@#";
			#all passwords should be encoded through md5()
			$pass = md5($pass);
			
			#first, look to see if person logging in is a user, and check their permissions
			$sql = "SELECT uname FROM users WHERE uname='$userID' AND pwd='$pass'";
		
			$rawResult = $gremlin->query($sql);
			
			if(!empty($rawResult)) {
				#user found!
				return TRUE;						
			} else {
				#user not found, check to see if it's a client
			
				$sql = "SELECT uname FROM clients WHERE uname='$userID' AND pwd='$pass'";
				
				$rawResult = $gremlin->query($sql);
				
				if(!empty($rawResult)) {
					#client found!
					return TRUE;
				} else {
					#invalid username/password
					return FALSE;
				}
			
			}
		
		}
	
	
		function __destruct() {
		    $gremlin->closeConnection();
		}
	
	}
	
	
?>