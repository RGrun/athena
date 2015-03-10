<?php

	#Doctor.php
	
	function __autoload($class_name) {
		include $class_name . '.php';
	}
	
	class Doctor {
	
		private $gremlin;
		
		public $docID;
		public $active;
		public $name;
		
		#companies doc works for
		public $companies = array();
		
		#sites doc works at
		public $sites = array();
		
		public function __construct($docID) {
		
			$this->gremlin = new Gremlin();
			
			#load doc's info from ID
			$sql = "SELECT * FROM doctors WHERE doc_id='$docID'";
			
			$rawData = $gremlin->query($sql):
			
			extract($rawData);
		
			$this->docID = $docID;
			$this->actice = $active;
			$this->name = $name;
			
			loadCompanies();
			loadSites();
		}
		
		public function loadCompanies() {
		
			$sql = "SELECT cmp_id FROM doc_cmp WHERE doc_id='$docID'";
			
			$rawResult = $gremlin->query($sql);
			
			foreach($rawResult as $newCont) {
			
				$newComp = new Company($newCont);
			
				$this->companies[] = $newComp;
			
			}
		
		
		}
		
		public function loadSites() {
		
			$sql = "SELECT site_id FROM doc_site WHERE doc_id='$docID'";
			
			$rawResult = $gremlin->query($sql);
			
			foreach($rawResult as $newCont) {
			
				$newComp = new Site($newCont);
			
				$this->sites[] = $newComp;
			
			}
		
		
		}
	
	
		function __destruct() {
		    $gremlin->closeConnection();
		}
	
	}
	
?>