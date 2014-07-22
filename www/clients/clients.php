<?php

	//clients.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	echo "<h2>Athena Clients</h2>";
	
	echo "<em><a href='addNewClient.php'>Add New Client</a></em>";
	
	$sql = "SELECT * FROM clients";
	
	if($result = $worker->query($sql)) {
	
		$table = "<table>" .
		"<tr><th>Client ID</th><th>Is Active?</th><th>First Name</th><th>Last Name</th><th>Username</th><th>Email</th><th>Phone</th><th>SMS</th></tr>"; 
		
		while($row = mysqli_fetch_assoc($result)) {			
			
			extract($row);
			
			$isActive = ($active == 1) ? "Yes" : "No";
	
			$table .= ("<tr><td>$cli_id</td><td>$isActive</td><td>$fname</td><td>$lname</td><td>$uname</td>" .
			"<td>$email</td><td>$phone</td><td>$sms</td></td>" .
			"<td><a href='clientDetail.php?cid=$cli_id'>Detail</a></td><td><a href='editClientInfo.php?cid=$cli_id'>Delete</a></td>");

		}
		
		$table .= "</table>";
		
		echo "<p>$table</p>";
		
	} else {
		echo "Error connecting to database.";
	}
	
	$worker->closeConnection();
	$htmlUtils->makeFooter();
	
?>