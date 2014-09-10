<?php

	//regions.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	echo "<div class='adminTable'>";
	
	echo "<h2>Regions</h2>";
	
	echo "<em><a href='addNewRegion.php'>Add New Region</a></em> <br/> <br/>";
	
	echo "<table>" .
	"<tr><th>Region ID</th><th>Name</th><th>City</th><th>Primary Company</th><th>State</th></tr>";
	
	$sql = "SELECT * FROM regions";
	
	if($result = $worker->query($sql)) {
		
		//get assoc array and print table data
		while($row = mysqli_fetch_assoc($result)) {
			
			extract($row);
			
			echo "<tr>";
			
			echo "<td>$reg_id</td>";
			
			$cName = $worker->findCompany($cmp_id, "name");
			if($cName == null) $cName = "Pending";
			
			
			echo "<td>$name</td>";
			echo "<td>$city</td>";
			echo "<td>$cName</td>";
			echo "<td>$state</td>";
			echo "<td><a href='regionDetail.php?rid=$reg_id'>Detail</a></td>";
			echo "<td><a href='deleteRegion.php?rid=$reg_id'>Delete</a></td></tr>";
			
		}
		
		echo "</table>";
		
		echo "</div>";
		
	} else {
		echo "Database Connection Error";
		$worker->closeConnection();
	}
	
	$htmlUtils->makeFooter();
	$worker->closeConnection();
	
?>