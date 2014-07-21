<?php

	//connection_info.php
	
	interface dbConnectInfo {
		
		//THESE NEED CHANGING ONCE PRODUCTION SERVER IS LIVE
		const HOST = "localhost"; 
		const USER = "root";
		const PW = "abcd1234";
		const DBNAME = "athena";
		
		public function doConnect();
		
	}
	
?>

