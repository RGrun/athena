<?php

	//instruments.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	echo "<div class='adminTable'>";
	
	echo "<h2>Athena Instruments</h2>";
	
	echo "<em><a href='addNewInstrument.php'>Add New Instrument</a></em>";
	
	$sql = "SELECT * FROM instruments";
	
	if($result = $worker->query($sql)) {
	
		$table = "<table>" .
		"<tr><th>Instrument ID</th><th>Name</th><th>Part No</th></tr>"; 
		
		while($row = mysqli_fetch_assoc($result)) {			
			
			extract($row);
	
			$table .= ("<tr><td>$inst_id</td><td>$name</td><td>$partno</td>" .
			"<td><a href='instrumentDetail.php?iid=$inst_id'>Detail</a></td><td><a href='deleteInstrument.php?iid=$inst_id'>Delete</a></td>");

		}
		
		$table .= "</table>";
		
		echo "<p>$table</p>";
		
		echo "</div>";
		
	} else {
		echo "Error connecting to database.";
	}
	
	$worker->closeConnection();
	$htmlUtils->makeFooter();
	
?>