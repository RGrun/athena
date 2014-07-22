<?php

	//dbConnector.php
	
	require_once("connection_info.php");
	
	class dbConnector implements dbConnectInfo {
	
		//constants from interface
		protected static $server = dbConnectInfo::HOST;
		protected static $db = dbConnectInfo::DBNAME;
		protected static $user = dbConnectInfo::USER;
		protected static $pass = dbConnectInfo::PW;
		protected $hookup;
		
		
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
	
	