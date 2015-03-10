<?php

	function __autoload($class_name) {
		include $class_name . '.php';
	}
	
	#This class handles all misc. DB-related stuff
	#It is primarily a bridge for queries from the rest of the system
	
	class Gremlin extends dbConnector {
	
		private $connection;
		
		public function __construct() {
		
			//establish connection to database
			$this->connection = $this->doConnect();
		}
		
			
		function __destruct() {
		    closeConnection();
		}
		
			
		public function closeConnection() {
			mysqli_close($this->connection);
		}
		
		#query wrapper
		public function query($sql) {

			$mysqliResult = mysqli_query($this->connection, $sql);
		
			return mysqli_fetch_assoc($mysqliResult);
		}
		
		
		#Writing functions
		
		
		
		
		
		#lookup functions
		
		public function findCompanyData($cid, $requestedField) {
		
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM company WHERE cmp_id='$cid'";
			$result = $this->query($sql);
			
			return $result["$requestedField"];
		}
		
		public function findRegionData($cid, $requestedField) {
		
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM regions WHERE reg_id='$cid'";
			$result = $this->query($sql);
			
			return $result["$requestedField"];
		}
		
		public function findUserData($uid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM users WHERE usr_id='$uid'";
			$result = $this->query($sql);
			
			return $result["$requestedField"];
		}
		
		public function findSiteData($uid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM sites WHERE site_id='$uid'";
			$result = $this->query($sql);
			
			return $result["$requestedField"];
		}
		
		public function findTeamData($uid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM teams WHERE team_id='$uid'";
			$result = $this->query($sql);
			
			return $result["$requestedField"];
		}
		
		public function findInstrumentData($uid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM instruments WHERE inst_id='$uid'";
			$result = $this->query($sql);
			
			return $result["$requestedField"];
		}
		
		public function findStorageData($sid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM storage WHERE stor_id='$sid'";
			$result = $this->query($sql);
			
			return $result["$requestedField"];
		}
		
		
		public function findDoctorData($uid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM doctors WHERE doc_id='$uid'";
			$result = $this->query($sql);
			
			return $result["$requestedField"];
		}
		
		public function findProcedureData($uid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM procs WHERE proc_id='$uid'";
			$result = $this->query($sql);
			
			return $result["$requestedField"];
		}
				
				
		public function findTrayData($uid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM trays WHERE tray_id='$uid'";
			$result = $this->query($sql);
			
			return $result["$requestedField"];
		}	
		
		public function findClientData($uid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM clients WHERE cli_id='$uid'";
			$result = $this->query($sql);
			
			return $result["$requestedField"];
		}
		
		public function findTrayTypeData($ttypId, $requestedField) {
		
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM ttyp WHERE ttyp_id='$ttypId'";
			$result = $this->query($sql);
			
			
			return $result["$requestedField"];
		
		
		}
	
	
	}



?>