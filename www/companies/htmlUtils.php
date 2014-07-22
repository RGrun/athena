<?php

	//htmlUtils.php
	
	//include_once("dbConnector.php");
	
	class htmlUtils {
	
		//function prints html header and opening <body> tag
		public function makeHeader() {
		
		session_start();
			
			$header = <<<_END
<!DOCTYPE html>
<html>
	<head>
		<title>Athena System</title>
	</head>	
	<body>
		<h1>Athena header</h1>
		<br />
		<br />
_END;
			echo $header;
		}
		
		//closes up the page
		public function makeFooter() {
		
			$footer = <<<_END
	</body>
</html>
_END;
			echo $footer;
		}
		
	}
	
?>