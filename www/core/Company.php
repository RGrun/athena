<?php

	#Company.php
	
	include_once "Gremlin.php";
	include_once "User.php";
	
	
	class Company {
	
		private $gremlin;
		
		public $companyID;
		public $active;
		public $name;
		public $address;
		public $city;
		public $state;
		public $zip;
		
		#users who belong to this company
		public $usersInCompany = array();
		
		#distributors who work for this company
		public $distributors = array();
		
		
		public function __construct($companyID) {
		
			$this->gremlin = new Gremlin();
			
			#load company's info from ID
			$sql = "SELECT * FROM company WHERE cmp_id='$companyID'";
			
			$rawData = $gremlin->query($sql);
			
			extract($rawData);
		
			$this->companyID = $companyID;
			$this->active = $active;
			$this->name = $name;
			$this->address = $address;
			$this->city = $city;
			$this->state = $state;
			$this->zip = $zip;
		
			loadUsers();
			loadDistributors();
		
		}
		
		
		function __destruct() {
		    $gremlin->closeConnection();
		}
		
		
		#populates $usersInCompany array with users who belong to this company
		private function loadUsers() {
		
			$sql = "SELECT usr_id FROM usr_cmp WHERE cmp_id='$companyID'";
			
			$rawResult = $gremlin->query($sql);
			
			foreach($rawResult as $newCont) {
			
				$newUser = new User($newCont);
			
				$this->usersInCompany[] = $newUser;
			
			}
		
		}
		
		#populates the $distributors array with distributors who work for this company
		private function loadDistributors() {
		
			$sql = "SELECT dst_id FROM dst_cmp WHERE cmp_id='$companyID'";
			
			$rawResult = $gremlin->query($sql);
			
			foreach($rawResult as $newCont) {
			
				$newDist = new Company($newCont);
			
				$this->distributors[] = $newDist;
			
			}
		
		}
	
	
	
	}


?>