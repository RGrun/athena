<?php

	//sites.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	echo "<h2>Sites</h2>";
	
	echo "<em><a href='addNewSite.php'>Add New Site</a></em> <br/> <br/>";
	
	echo "<table>" .
	"<tr><th>Site ID</th><th>Active?</th><th>Name</th><th>Address</th><th>City</th><th>State</th><th>Zip</th><th>Fax</th></tr>";
	
	$sql = "SELECT * FROM sites";
	
	if($result = $worker->query($sql)) {
		
		//get assoc array and print table data
		while($row = mysqli_fetch_assoc($result)) {
			
			extract($row);
			
			echo "<tr>";
			
			echo "<td>$site_id</td>";
			
			if($active == 1) echo "<td>Yes</td>";
			else echo "<td>No</td>";
			
			echo "<td>$name</td>";
			echo "<td>$address</td>";
			echo "<td>$city</td>";
			echo "<td>$state</td>";
			echo "<td>$zip</td>";
			echo "<td>$fax</td>";
			echo "<td><a href='siteDetail.php?sid=$site_id'>Detail</a></td>";
			echo "<td><a href='deleteSite.php?sid=$site_id'>Delete</a></td></tr>";
			
		}
		
		echo "</table>";
		
	} else {
		echo "Database Connection Error";
		$worker->closeConnection();
	}
	
	$htmlUtils->makeFooter();
	$worker->closeConnection();
	
?>