<?php

	//siteDetail.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$currentSite = $_GET['sid'];
	
	$_SESSION['currentSiteId'] = $currentSite;
	
	//delete relationship
	if(isset($_GET['del'])) {
	
		$toDelete = $_GET['del'];
		$sql = "DELETE FROM site_region WHERE region='$toDelete' AND site_id='$currentSite'";
		
		$worker->query($sql);
		
		echo "Data successfully updated.";
	}
	
	//data input from form at bottom of page
	if(isset($_POST['newregions'])) {
		
		$region = $_POST['newregions'];
		
		//map id to region name
		$region = $worker->findRegion($region, "name");
		
		
		$sql = "INSERT INTO site_region (site_id, region)" .
		"VALUES ('$currentSite', '$region')";
		
		$worker->query($sql);
		
		echo "Data successfully updated";
	}
	
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
		
		//create site-region relation table
		$sql = "SELECT * FROM site_region WHERE site_id='$currentSite'";

		if($result = $worker->query($sql)) {
		
			$site_region = "<table>" .
			"<tr><th>Serviced Regions</th></tr>";
			
			while ($row = mysqli_fetch_assoc($result)) {
				
				extract($row);
				
				$site_region .= "<tr><td>$region</td>" .
				"<td><a href='siteDetail.php?del=$region&sid=$currentSite'>Remove</a></td></tr>";
				
			}
			
			$site_region .= "</table>";
			
			echo "<p>$site_region</p>";
			
		}
		
		$regionSelector = $worker->createSelector("regions", "name", "reg_id");
		
		$regionForm = "<form action='siteDetail.php?sid=$site_id' method='post'>" .
		"Add Region: $regionSelector <br/>" .
		"<input type='submit' value='Commit Changes' />  </form>";
		
		echo "<p>$regionForm</p>";
		
	} else {
		echo "Error connecting to database.";
	}
	
	$worker->closeConnection();
	$htmlUtils->makeFooter();
?>
		
		