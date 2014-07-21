<?php

	//dbConnector.php
	
	include_once("connection_info.php");
	
	class dbConnector implements dbConnectInfo {
	
		//constants from interface
		private static $server = dbConnectInfo::HOST;
		private static $db = dbConnectInfo::DBNAME;
		private static $user = dbConnectInfo::USER;
		private static $pass = dbConnectInfo::PW;
		private $hookup;
		
		
		//returns active db connection
		public function doConnect() {
			
			$hookup = mysqli_connect(self::$server, self::$user, self::$pass, self::$db);
			
			if(mysqli_connect_error($hookup)) {	
				echo("Databse connection failure. Reason: " . mysqli_connect_error());
			}
			
			return $hookup;
		}
		
	}
?>
	
	