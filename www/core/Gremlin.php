<?php

	include_once "dbConnector.php";
	
	#This class handles all misc. DB-related stuff
	#It is primarily a bridge for queries from the rest of the system
	
	class Gremlin extends dbConnector {
	
		private $connection;
		
		public function __construct() {
		
			//establish connection to database
			$this->connection = $this->doConnect();
		}
		
			
		function __destruct() {
		    $this->closeConnection();
		}
		
			
		public function closeConnection() {
			mysqli_close($this->connection);
		}
		
		#query wrapper
		public function query($sql) {

			$mysqliResult = mysqli_query($this->connection, $sql);
		
			if($mysqliResult == false) {
				return array();
			
			} else {
				
				return mysqli_fetch_assoc($mysqliResult);
			}
		}
		
		#HTML helper functions
		
		public function defend() {
		
			#No non-logged-in users allowed
			if (!isset($_SESSION['loggedIn'])) {
			
				header("Location: index.php");
				die();
			
			}
		
		
		}
		
		public function spawnPage($ID, $userType) {
			
			#logged-in users only
			$this->defend();
	
			$user = User::spawnUser($ID, $userType);
	
			return $user;
		
		}
		
		

		#MUST BE CALLED AFTER session_start() ON PAGE
		public function buildMenu($pageName) {
				
			#We need HTML headers first
			#this also handles the opening <body> tag for the page
			$headers = "<!DOCTYPE HTML>";
			$headers .= "<head>";
			$headers .= "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
			$headers .= "<meta content='utf-8' http-equiv='encoding'>";
			$headers .= "<title>Athena System | $pageName</title>";
			$headers .= "<link rel='stylesheet' type='text/css' href='core/styles.css'>";
			$headers .= "<script src='jquery-2-1-3.js'></script>";
			$headers .= "</head><body>";
			
		
			$menu = "<div class='navMenu'>"; #open menu
			
			#use inline-block in CSS for these buttons
			#left-aligned buttons
			$menu .= "<a href='home.php'><div class='navMenuButtonLogo'><img height='42' width='133' class='navMenuLogo'
			src='core/images/athena-logo.png'/> </div></a>";
			
			
			######DUMMY: calendar button is 'selected' for demo, rest are unselected
			$menu .= "<a href='home.php'><div class='navMenuButtonLeft navSelected'><span class='navMenuText'><b>Calendar</b></span></div></a>";
			
			
			$menu .= "<a href='trays.php'><div class='navMenuButtonLeft navUnselected'><span class='navMenuText'><b>Trays</b></span></div></a>";
			
			$menu .= "<a href='notifications.php'><div class='navMenuButtonLeft navUnselected'><span class='navMenuText'><b>Notifications</b></span></div></a>";
			
			$menu .= "<a href='teamActivity.php'><div class='navMenuButtonLeft navUnselected'><span class='navMenuText'><b>Team Activity</b></span></div></a>";
			
			$menu .= "<a href='newCase.php'><div class='navMenuButtonLeft navUnselected'><span class='navMenuText'><b>New Case</b></span></div></a>";
			
			
			#right-aligned buttons
			#add profile image?
			$menu .= "<a href='settings.php'><div class='navMenuButtonRight navUnselected'><span class='navMenuText'><b>Setttings</b></span></div></a>";
			
			$menu .= "<a href='help.php'><div class='navMenuButtonRight navUnselected'><span class='navMenuText'><b>Help</b></span></div></a>";
			
			$menu .= "</div>"; #end menu
			
			$menu .= "<div id='mainContentWrapper'>"; //open mainContentWrapper
			
			
			#make Gremlin object availible on every page
			$gremlin = new Gremlin();
			
			#return header + menu
			return $headers . $menu;
		}
		
		public function buildFooter() {
		
			return "</div></body></html>";
		
		
		
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