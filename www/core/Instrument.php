<?php

	#Instrument.php

	include_once "Gremlin.php";
	
	
	class Instrument {
	
		private $gremlin;
	
		public $instrumentID;
		public $companyID;
		public $name;
		public $partNo;
		
		public function __construct($instID) {
		
			$this->$gremlin = new Gremlin();
			
			$sql = "SELECT * FROM instruments WHERE inst_id='$instID'";
			
			$rawResult = $gremlin->query($sql);
			
			extract($rawResult);
			
			$this->instrumentID = $instID;
			$this->companyID = $cmp_id;
			$this->name = $name;
			$this->partNo = $partno;
		
		
		}
		
		function __destruct() {
		    $gremlin->closeConnection();
		}
	
	
	
	}


?>