<?php

	//siteDetail.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$currentSite = $_GET['sid'];
	
	$_SESSION['currentSiteId'] = $currentSite;
	
	$sql = "SELECT * FROM sites WHERE site_id='$currentSite'";
	
	if($result = $worker->query($sql)) {
	
		$row = mysqli_fetch_assoc($result);
		
		extract($row);
		
		$activeSite = ($active == 1) ? 'Yes' : 'No';
	
		echo "<h2>Site Detail for $name</h2>";
		
		$table = "<table>" .
		"<tr><td><em>Active Site?</em></td><td>$activeSite</td><td><a href='editSiteInfo.php?mtd=active'>Edit</a></td></tr>" .
		"<tr><td><em>Address</em></td><td>$address</td><td><a href='editSiteInfo.php?mtd=address'>Edit</a></td></tr>" .
		"<tr><td><em>City</em></td><td>$city</td><td><a href='editSiteInfo.php?mtd=city'>Edit</a></td></tr>" .
		"<tr><td><em>State</em></td><td>$state</td><td><a href='editSiteInfo.php?mtd=state'>Edit</a></td></tr>" .
		"<tr><td><em>Zip Code</em></td><td>$zip</td><td><a href='editSiteInfo.php?mtd=zip'>Edit</a></td></tr>" .
		"<tr><td><em>Fax</em></td><td>$fax</td><td><a href='editSiteInfo.php?mtd=fax'>Edit</a></td></tr>" .
		"</table>";
		
		echo "<p>$table</p>";
	} else {
		echo "Error connecting to database.";
	}
	
	$worker->closeConnection();
	$htmlUtils->makeFooter();
?>
		
		