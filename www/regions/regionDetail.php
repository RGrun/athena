<?php

	//regionDetail.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	echo "<div class='adminTable'>";
	
	$currentRegion = $_GET['rid'];
	
	$_SESSION['currentRegionId'] = $currentRegion;
	
	//add new site to region
	if(isset($_POST['addNew'])) {
	
		$site = $_POST['newsites'];
	
		$sql = "INSERT INTO site_region(site_id, reg_id) VALUES ($site, $currentRegion)";
		$result = $worker->query($sql);
	
	}
	
	//delete site from region
	if(isset($_GET['delete'])) {
		$toDelete = $_GET['sid'];
		
		$sql = "DELETE FROM site_region WHERE site_id='$toDelete' AND reg_id='$currentRegion'";
		$result = $worker->query($sql);
	
	}
	
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
		$sql = "SELECT * FROM site_region WHERE reg_id='$currentRegion'";
		
		if($result = $worker->query($sql)) {
		
			$site_region = "<table>" .
			"<tr><th>Sites in region:</th></tr>";
			
			while ($row = mysqli_fetch_assoc($result)) {
				
				extract($row);
				
				$site = $worker->findSite($site_id, "name");
				
				$site_region .= "<tr><td>$site</td><td><a href='regionDetail.php?delete=1&sid=$site_id&rid=$currentRegion'>Detele</a></td>" .
				"</tr>";
				
			}
			
			$site_region .= "</table>";
			
			echo "<p>$site_region</p>";
			
		}
	
	
		$sitesSelector = $worker->createSelector("sites", "name", "site_id");
		
		$sitesForm = "<form action='regionDetail.php?rid=$reg_id' method='post'>" .
		"Add Site: $sitesSelector <br/>" .
		"<input type='hidden' value='1' name='addNew' />" .
		"<input type='submit' value='Commit Changes' />  </form>";
		
		echo "<p>$sitesForm</p>";
	
	
		echo "</div>";
	
	} else {
		echo "Error connecting to database.";
	}
	
	$worker->closeConnection();
	$htmlUtils->makeFooter();
?>
		
		