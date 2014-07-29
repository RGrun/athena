<?php

	//regionDetail.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$currentRegion = $_GET['rid'];
	
	$_SESSION['currentRegionId'] = $currentRegion;
	
	$sql = "SELECT * FROM regions WHERE reg_id='$currentRegion'";
	
	if($result = $worker->query($sql)) {
	
		$row = mysqli_fetch_assoc($result);
		
		extract($row);
		
		echo "<h2>Region Detail for $name</h2>";
		
		$table = "<table>" .
		"<tr><td><em>Region ID</em></td><td>$reg_id</td>" .
		"<tr><td><em>City</em></td><td>$city</td><td><a href='editRegionInfo.php?mtd=city'>Edit</a></td></tr>" .
		"<tr><td><em>State</em></td><td>$state</td><td><a href='editRegionInfo.php?mtd=state'>Edit</a></td></tr>" .
		"</table>";
		
		echo "<p>$table</p>";
		
		//create site-region relation table
		$sql = "SELECT * FROM site_region WHERE region='$name'";
		
		if($result = $worker->query($sql)) {
		
			$site_region = "<table>" .
			"<tr><th>Sites in region:</th></tr>";
			
			while ($row = mysqli_fetch_assoc($result)) {
				
				extract($row);
				
				$site = $worker->findSite($site_id, "name");
				
				$site_region .= "<tr><td>$site</td>" .
				"</tr>";
				
			}
			
			$site_region .= "</table>";
			
			echo "<p>$site_region</p>";
			
		}
	/*
		$sitesSelector = $worker->createSelector("sites", "name", "site_id");
		
		$sitesForm = "<form action='regionDetail.php?rid=$reg_id' method='post'>" .
		"Add Site: $sitesSelector <br/>" .
		"<input type='submit' value='Commit Changes' />  </form>";
		
		echo "<p>$sitesForm</p>";
	*/
	} else {
		echo "Error connecting to database.";
	}
	
	$worker->closeConnection();
	$htmlUtils->makeFooter();
?>
		
		