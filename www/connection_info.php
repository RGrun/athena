<?php

	//connection_info.php
	
	interface dbConnectInfo {
		
		//THESE NEED CHANGING ONCE PRODUCTION SERVER IS LIVE
		const HOST = "localhost"; 
		const USER = "dbWorker";
		const PW = "password";
		const DBNAME = "athena";
		
		public function doConnect();
		
	}
	
?>

