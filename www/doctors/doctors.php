<?php

	//doctors.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	echo "<div class='adminTable'>";
	
	echo "<h2>Athena Doctors</h2>";
	
	echo "<em><a href='addNewDoctor.php'>Add New Doctor</a></em>";
	
	$sql = "SELECT * FROM doctors";
	
	if($result = $worker->query($sql)) {
	
		$table = "<table>" .
		"<tr><th>Doctor ID</th><th>Is Active?</th><th>Name</th></tr>"; 
		
		while($row = mysqli_fetch_assoc($result)) {			
			
			extract($row);
			
			$isActive = ($active == 1) ? "Yes" : "No";
	
			$table .= ("<tr><td>$doc_id</td><td>$isActive</td><td>$name</td>" .
			"<td><a href='doctorDetail.php?did=$doc_id'>Detail</a></td><td><a href='deleteDoctor.php?did=$doc_id'>Delete</a></td>");

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