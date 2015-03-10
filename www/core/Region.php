<?php

	#Region.php

	function __autoload($class_name) {
		include $class_name . '.php';
	}
	
	
	class Region {
	
		private $gremlin;
		
		public $regionID;
		public $companyID;
		public $name;
		public $city;
		public $state;
		
		#array of sites within region
		public $sitesInRegion = array();
		
		
		public function __construct($regionID) {
			
			$gremlin = new Gremlin();
			
			#load region's info from ID
			$sql = "SELECT * FROM regions WHERE reg_id='$regionID'";
			
			$rawData = $gremlin->query($sql):
			
			extract($rawData);
			
			$this->regionID = $regionID;
			$this->companyID = $cmp_id;
			$this->name = $name;
			$this->city = $city;
			$this->state = $state;
		
			loadSites();
		}
		
		function __destruct() {
		    $gremlin->closeConnection();
		}
		
		private function loadSites() {
		
			$sql = "SELECT site_id FROM site_region WHERE reg_id='$regionID'";
			
			$rawResult = $gremlin->query($sql);
			
			foreach($rawResult as $newCont) {
			
				$newSite = new Site($newCont);
			
				$this->sitesInRegion[] = $newSite;
			
			}
		
		}
		
	
	}
	
	
	
	

?>