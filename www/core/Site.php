<?php

	#Site.php
	
	function __autoload($class_name) {
		include $class_name . '.php';
	}
	
	class Site {
	
		private $gremlin;
		
		public $siteID;
		public $active;
		public $name;
		public $address;
		public $city;
		public $state;
		public $zip;
		public $fax;
		
		
		public function __construct($siteID) {
		
			$gremlin = new Gremlin();
			
			#load sites's info from ID
			$sql = "SELECT * FROM sites WHERE site_id='$siteID'";
			
			$rawData = $gremlin->query($sql);
			
			extract($rawData);
			
			$this->siteID = $siteID;
			$this->active = $actice;
			$this->name = $name;
			$this->address = $address;
			$this->city = $city;
			$this->state = $state;
			$this->zip = $zip;
			$this->fax = $fax;
			
		}
		
		
		function __destruct() {
		    $gremlin->closeConnection();
		}
	
	
	
	}
	
?>