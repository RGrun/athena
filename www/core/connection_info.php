<?php

	//connection_info.php
	
	interface dbConnectInfo {
		
		//THESE NEED CHANGING ONCE PRODUCTION SERVER IS LIVE
		const HOST = "localhost"; 
		const USER = "xxx";
		const PW = "xxxxx";
		const DBNAME = "athena";
		
		public function doConnect();
		
	}
	
?>
