<?php

	//storage.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	echo "<div class='adminTable'>";
	
	echo "<h2>Storage Sites</h2>";
	
	echo "<em><a href='addNewStorage.php'>Add New Storage Location</a></em>";
	
	$sql = "SELECT * FROM storage";
	
	if($result = $worker->query($sql)) {
	
		$table = "<table>" .
		"<tr><th>Company</th><th>Name</th><th>Address</th><th>City</th><th>State</th><th>Zip</th><th>Active?</th></tr>"; 
		
		while($row = mysqli_fetch_assoc($result)) {			
			
			extract($row);
			
			$company = $worker->findCompany($cmp_id, "name");
			if($active == 1) $activeLabel = "Yes";
			else $activeLabel = "No";
	
			$table .= ("<tr><td>$company</td><td>$name</td><td>$address</td><td>$city</td><td>$state</td>" .
			"<td>$zip</td><td>$activeLabel</td>" .
			"<td><a href='storageDetail.php?sid=$stor_id'>Detail</a></td><td><a href='deleteStorage.php?sid=$stor_id'>Delete</a></td>");

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