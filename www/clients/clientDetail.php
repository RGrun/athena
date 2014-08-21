<?php

	//clientDetail.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	echo "<div class='adminTable'>";
	
	$currentClientId = $_GET['cid'];
	
	$_SESSION['currentClientId'] = $currentClientId;
	
	//delete relationship
	if(isset($_GET['del'])) {
	
		$toDelete = $_GET['del'];
		$sql = "DELETE FROM cli_site WHERE site_id='$toDelete' AND cli_id='$currentClientId'";
		
		$worker->query($sql);
		
		echo "Data successfully updated.";
	}
	
	//data input from form at bottom of page
	if(isset($_POST['newsites'])) {
		
		$site = $_POST['newsites'];
		
		$sql = "INSERT INTO cli_site (cli_id, site_id)" .
		"VALUES ('$currentClientId', '$site')";
		
		$worker->query($sql);
		
		echo "Data successfully updated";
	}
	
	$sql = "SELECT * FROM clients WHERE cli_id='$currentClientId'";
	
	if($result = $worker->query($sql)) {
		$row = mysqli_fetch_assoc($result);
		
		extract($row);
		
		$activeClient = ($active == 1) ? "Yes" : "No";
		
		echo "<h2>Client Detail for $uname</h2>";
		
		$table = "<table>" .
		"<tr><td><em>Active Client?</em></td><td>$activeClient</td><td><a href='editClientInfo.php?mtd=active'>Edit</a></td></tr>" .
		"<tr><td><em>First Name</em></td><td>$fname</td><td><a href='editClientInfo.php?mtd=fname'>Edit</a></td></tr>" .
		"<tr><td><em>Last Name</em></td><td>$lname</td><td><a href='editClientInfo.php?mtd=lname'>Edit</a></td></tr>" .
		"<tr><td><em>Email</em></td><td>$email</td><td><a href='editClientInfo.php?mtd=email'>Edit</a></td></tr>" .
		"<tr><td><em>Phone</em></td><td>$phone</td><td><a href='editClientInfo.php?mtd=phone'>Edit</a></td></tr>" .
		"<tr><td><em>SMS</em></td><td>$sms</td><td><a href='editClientInfo.php?mtd=sms'>Edit</a></td></tr>" .
		"<tr><td><em>Permissions</em></td><td>$perm</td><td><a href='editClientInfo.php?mtd=perm'>Edit</a></td></tr>" .
		"</table><br/><br/>";
		
		echo $table;
		
		//create client-site relation table
		$sql = "SELECT * FROM cli_site WHERE cli_id='$currentClientId'";

		if($result = $worker->query($sql)) {
		
			$client_site = "<table>" .
			"<tr><th>Client Works At:</th></tr>";
			
			while ($row = mysqli_fetch_assoc($result)) {
				
				extract($row);
				
				$site = $worker->findSite($site_id, "name");
				
				$client_site .= "<tr><td>$site</td>" .
				"<td><a href='clientDetail.php?del=$site_id&cid=$currentClientId'>Remove</a></td></tr>";
				
			}
			
			$client_site .= "</table>";
			
			echo "$client_site";
			
		}
		
		$siteSelector = $worker->createSelector("sites", "name", "site_id");
		
		$siteForm = "<form action='clientDetail.php?cid=$currentClientId' method='post'>" .
		"Add Site: $siteSelector <br/>" .
		"<input type='submit' value='Commit Changes' />  </form>";
		
		echo "$siteForm";
		
		echo "</div>";
		
	} else {
		echo "Error connecting to database";
	}
	
	$htmlUtils->makeFooter();
	$worker->closeConnection();
	
?>
		
		
