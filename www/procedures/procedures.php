<?php

	//procedures.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	echo "<h2>Athena Procedures</h2>";
	
	echo "<em><a href='addNewProcedure.php'>Add New Procedure</a></em>";
	
	$sql = "SELECT * FROM procs";
	
	if($result = $worker->query($sql)) {
	
		$table = "<table>" .
		"<tr><th>Procedure ID</th><th>Name</th></tr>"; 
		
		while($row = mysqli_fetch_assoc($result)) {			
			
			extract($row);
	
			$table .= ("<tr><td>$proc_id</td><td>$name</td>" .
			"<td><a href='procedureDetail.php?pid=$proc_id'>Detail</a></td><td><a href='deleteProcedure.php?pid=$proc_id'>Delete</a></td>");

		}
		
		$table .= "</table>";
		
		echo "<p>$table</p>";
		
	} else {
		echo "Error connecting to database.";
	}
	
	$worker->closeConnection();
	$htmlUtils->makeFooter();
	
?>