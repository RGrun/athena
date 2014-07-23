<?php

	//doctorDetail.php
	
	require_once "includes.php";

	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$currentDoctorId = $_GET['did'];
	
	$_SESSION['currentDoctorId'] = $currentDoctorId;
	
	$sql = "SELECT * FROM doctors WHERE doc_id='$currentDoctorId'";
	
	if($result = $worker->query($sql)) {
		$row = mysqli_fetch_assoc($result);
		
		extract($row);
		
		$activeDoctor = ($active == 1) ? "Yes" : "No";
		
		echo "<h2>Doctor Detail for $name</h2>";
		
		$table = "<table>" .
		"<tr><td><em>Doctor ID</em></td><td>$doc_id</td></tr>" .
		"<tr><td><em>Active Doctor?</em></td><td>$activeDoctor</td><td><a href='editDoctorInfo.php?mtd=active'>Edit</a></td></tr>" .
		"<tr><td><em>Name</em></td><td>$name</td><td><a href='editDoctorInfo.php?mtd=name'>Edit</a></td></tr>" .
		"</table>";
		
		echo "<p>$table</p>";
		
	} else {
		echo "Error connecting to database";
	}
	
	$htmlUtils->makeFooter();
	$worker->closeConnection();
	
?>