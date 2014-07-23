<?php

	//clientDetail.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$currentClientId = $_GET['cid'];
	
	$_SESSION['currentClientId'] = $currentClientId;
	
	$sql = "SELECT * FROM clients WHERE cli_id='$currentClientId'";
	
	if($result = $worker->query($sql)) {
		$row = mysqli_fetch_assoc($result);
		
		extract($row);
		
		$activeClient = ($active == 1) ? "Yes" : "No";
		
		echo "<h2>Client Detail for $uname</h2>";
		
		$table = "<table>" .
		"<tr><td><em>Active Client?</em></td><td>$activeClient</td><td><a href='editClientInfo.php?mtd=active'>Edit</a></td></tr>" .
		"<tr><td><em>First Name</em></td><td>$fname</td><td><a href='editClientInfo.php?mtd=fname'>Edit</a></td></tr>" .
		"<tr><td><em>Last Name</em></td><td>$lname</td><td><a href='editClientInfo.php?mtd=lname'>Edit</a></td></tr>" .
		"<tr><td><em>Email</em></td><td>$email</td><td><a href='editClientInfo.php?mtd=email'>Edit</a></td></tr>" .
		"<tr><td><em>Phone</em></td><td>$phone</td><td><a href='editClientInfo.php?mtd=phone'>Edit</a></td></tr>" .
		"<tr><td><em>SMS</em></td><td>$sms</td><td><a href='editClientInfo.php?mtd=sms'>Edit</a></td></tr>" .
		"</table>";
		
		echo "<p>$table</p>";
		
	} else {
		echo "Error connecting to database";
	}
	
	$htmlUtils->makeFooter();
	$worker->closeConnection();
	
?>
		
		
