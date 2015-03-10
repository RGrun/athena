<?php

	#Storage.php
	
	function __autoload($class_name) {
		include $class_name . '.php';
	}
	
	
	class Storage {
	
		private $gremlin;
		
		public $storageID;
		public $companyID;
		public $active;
		public $name;
		public $address;
		public $city;
		public $state;
 		public $zip;
	
		public function __construct($storageID) {
		
			$this->gremlin = new Gremlin();
			
			#load storage's info from ID
			$sql = "SELECT * FROM storage WHERE stor_id='$storageID'";
			
			$rawData = $gremlin->query($sql):
			
			extract($rawData);
			
			$this->storageID = $storageID;
			$this->companyID = $cmp_id;
			$this->active = $active;
			$this->name = $name;
			$this->address = $address;
			$this->city = $city;
			$this->state = $state;
			$this->zip = $zip;
		
		
		
		}
	
	
	}
	
?>