<?php

	//storageDetail.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$currentStorageId = $_GET['sid'];
	
	$_SESSION['currentStorageId'] = $currentStorageId;	
	
	$sql = "SELECT * FROM storage WHERE stor_id='$currentStorageId'";
	
	if($result = $worker->query($sql)) {
		$row = mysqli_fetch_assoc($result);
		
		extract($row);
		
		$activeStorage = ($active == 1) ? 'Yes' : 'No';
		
		echo "<h2>Storage Detail for $name</h2> <br/>";
		
		
		$company = $worker->findCompany($cmp_id, "name");
		
		$table = "<table>" .
		"<tr><td><em>Name</em></td><td>$name</td><td><a href='editStorageInfo.php?mtd=name'>Edit</a></td></tr>" .
		"<tr><td><em>Active Location?</em></td><td>$activeStorage</td><td><a href='editStorageInfo.php?mtd=active'>Edit</a></td></tr>" .
		"<tr><td><em>Company</em></td><td>$company</td><td><a href='editStorageInfo.php?mtd=cmp_id'>Edit</a></td></tr>" .
		"<tr><td><em>Address</em></td><td>$address</td><td><a href='editStorageInfo.php?mtd=address'>Edit</a></td></tr>" .
		"<tr><td><em>City</em></td><td>$city</td><td><a href='editStorageInfo.php?mtd=city'>Edit</a></td></tr>" .
		"<tr><td><em>State</em></td><td>$state</td><td><a href='editStorageInfo.php?mtd=state'>Edit</a></td></tr>" .
		"<tr><td><em>Zip</em></td><td>$zip</td><td><a href='editStorageInfo.php?mtd=zip'>Edit</a></td></tr>" .
		"</table><br/><br/>";
		
		echo "<p>$table</p>";
		
			
	} else {
			echo "Database connection error.";
	}
	 $worker->closeConnection();
	 $htmlUtils->makeFooter();
?>