<?php
	
	#Tag.php
	
	function __autoload($class_name) {
		include $class_name . '.php';
	}
	
	class Tag {
	
		private $gremlin;
		
		public $tag;
		public $name; #alias for tag
		public $companyID; #ID of company tag belongs to. If == 0, tag is global
		
		public function __construct($tag) {
		
			$this->gremlin = new Gremlin();
			
			#load tags's info from ID
			$sql = "SELECT * FROM tags WHERE tag='$tag'";
			
			$rawData = $gremlin->query($sql):
			
			extract($rawData);
			
			$this->tag = $tag;
			$this->name = $this->tag;
			$this->companyID = $cmp_id;
		
		
		}
		
		function __destruct() {
		    $gremlin->closeConnection();
		}
	
	
	}
	
	
?>