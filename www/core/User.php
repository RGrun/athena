<?php

	#User.php
	#This class encapsulates both Users and Clients
	
	include_once "Gremlin.php";
	
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
		
		public static function spawnUser($userClientID, $type) {
					
			if($type == self::$TYPE_USER) {
			
				$user = self::loadUserData($userClientID);
			
				return $user;
			
			} else if($type == self::$TYPE_CLIENT) {
				
				$user = self::loadClientData($userClientID);
				
				return $user;
			
			}
				
		
		
		}
		
		public function __construct(/*$userClientID, $type*/) {
		
			/*$this->gremlin = new Gremlin();
		
			if($type == self::$TYPE_USER) {
			
				self::loadUserData($userClientID);
			
			
			} else if($type == self::$TYPE_CLIENT) {
				
				self::loadClientData($userClientID);
			
			} */
				
		
		}
		
		
		private static function loadUserData($userID) {
		
			$gremlin = new Gremlin();

			
			#load users's info from ID
			$sql = "SELECT * FROM users WHERE usr_id='$userID'";
			
			$rawData = $gremlin->query($sql);
			
			extract($rawData);
			
			$newUser = new User();
			
			$newUser->type = self::$TYPE_USER;
			$newUser->ID = $userID;
			$newUser->active = $active;
			$newUser->teamID = $team_id;
			$newUser->fname = $fname;
			$newUser->lname = $lname;
			$newUser->uname = $uname;
			$newUser->email = $email;
			$newUser->phone = $phone;
			$newUser->sms = $sms;
			
			#check permissions
			if(preg_match("/admin/i", $perm) == TRUE) { $newUser->isAdmin = TRUE; }
			else { $newUser->isAdmin = FALSE; }
			
			#figure out user's companies, to be stored in array, needed for tagging info
			$companySql = "SELECT * FROM usr_cmp WHERE usr_id='$newUser->ID'";	

			$companyResult = $gremlin->query($companySql);
			
			foreach ($companyResult as $newCompany) {
			
				$newUser->companies[] = $newCompany;
			
			}
			
			#Is this user a team leader?
			$TLSql = "SELECT team_id FROM teams WHERE head_id='$newUser->ID'";
			
			$TLResult = $gremlin->query($TLSql);
			
			if(!empty($TLResult)) {
				$newUser->isTeamLeader = TRUE;
			} else {
				$newUser->isTeamLeader = FALSE;
			}
			
			return $newUser;
		
		}
		
		
		private static function loadClientData($clientID) {
		
			$gremlin = new Gremlin();

		
			#load clients's info from ID
			$sql = "SELECT * FROM clients WHERE cli_id='$clientID'";
			
			$rawData = $gremlin->query($sql);
			
			extract($rawData);
			
			$newClient = new User();
			
			$newClient->type = self::$TYPE_CLIENT;
			$newClient->ID = $clientID;
			$newClient->active = $active;
			$newClient->teamID = -1;
			$newClient->fname = $fname;
			$newClient->lname = $lname;
			$newClient->uname = $uname;
			$newClient->email = $email;
			$newClient->phone = $phone;
			$newClient->sms = $sms;
			
			#check permissions
			if(preg_match("/admin/i", $perm) == TRUE) { $newClient->isAdmin = TRUE; }
			else { $newClient->isAdmin = FALSE; }
			
			#clients can't be team leaders
			$newClient->isTeamLeader = FALSE;
		
		
			return $newClient;
		}
		
		
		#returns a boolean. If true, password is correct.
		public static function checkPassword($username, $rawPW) {
		
			$gremlin = new Gremlin();
		
			#salting password
			$pass = "!@#$rawPW!@#";
			#all passwords should be encoded through md5()
			$pass = md5($pass);
			
			#first, look to see if person logging in is a user, and check their permissions
			$sql = "SELECT usr_id FROM users WHERE uname='$username' AND pwd='$pass'";
		
			$rawResult = $gremlin->query($sql);
			
			if(!empty($rawResult)) {
				#user found!
				return "user";						
			} else {
				#user not found, check to see if it's a client
			
				$sql = "SELECT usr_id FROM clients WHERE uname='$username' AND pwd='$pass'";
				
				$rawResult = $gremlin->query($sql);
				
				if(!empty($rawResult)) {
					#client found!
					return "client";
				} else {
					#invalid username/password
					return "not found";
				}
			
			}
		
		}
	
	
		function __destruct() {
		  
		}
	
	}
	
	
?>