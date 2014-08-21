<?php

	//settings.php
	//this page is like the user editing page, but stripped down
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	echo "<div class='adminTable'>";
	
	$currentUserId = $_SESSION['userId'];

	$isClient = $_SESSION['isClient'];
	$isAdmin = $_SESSION['isAdmin'];
	
	if($isAdmin) $adminInfo = "<p>You can modify your personal details here.</p><p>To modify more advanced settings, such as user permissions and teams, use the admin panel.</p>";
	else $adminInfo = "<p>You can modify your personal details here.</p>";
	
	$pageTitle = "<div class='pagetitle'><div class='wrapper'><span id='titleicon'>&#x2699;</span><span id='title'>SETTINGS</span></div></div>";
	
	echo $pageTitle;
	
	echo $adminInfo;
	
	//if user is a user, display this page
	if(!$isClient) {
	
		//delete relationship
		if(isset($_GET['del'])) {
		
			$toDelete = $_GET['del'];
			$sql = "DELETE FROM usr_cmp WHERE cmp_id='$toDelete' AND usr_id='$currentUserId'";
			
			$worker->query($sql);
			
			echo "Data successfully updated.";
		}
		
		//data input from form at bottom of page
		if(isset($_POST['newcompany'])) {
			
			$company = $_POST['newcompany'];
			$rel = $_POST['newRel'];
			
			$sql = "INSERT INTO usr_cmp (usr_id, cmp_id, rel)" .
			"VALUES ('$currentUserId', '$company', '$rel')";
			
			$worker->query($sql);
			
			echo "Data successfully updated";
		}
		
		
		$sql = "SELECT * FROM users WHERE usr_id='$currentUserId'";
		
		if($result = $worker->query($sql)) {
			$row = mysqli_fetch_assoc($result);
			
			extract($row);
			
			$activeUser = ($active == 1) ? 'Yes' : 'No';
			
			echo "<h2>User Detail for $uname</h2> ";
			
			$team = $worker->findTeam($team_id, "name");
			
			$table = "<table>" .
			"<tr><td><em>First Name:</em></td><td>$fname</td><td><a href='editSettings.php?mtd=fname'>Edit</a></td></tr>" .
			"<tr><td><em>Last Name:</em></td><td>$lname</td><td><a href='editSettings.php?mtd=lname'>Edit</a></td></tr>" .
			"<tr><td><em>Team:</em></td><td>$team</td></tr>" .
			"<tr><td><em>Email:</em></td><td>$email</td><td><a href='editSettings.php?mtd=email'>Edit</a></td></tr>" .
			"<tr><td><em>Phone:</em></td><td>$phone</td><td><a href='editSettings.php?mtd=phone'>Edit</a></td></tr>" .
			"<tr><td><em>SMS:</em></td><td>$sms</td><td><a href='editSettings.php?mtd=sms'>Edit</a></td></tr>" .
			"<tr><a href='editSettings.php?mtd=pwd'>Change Password</a></tr>" .
			"</table><br/><br/>";
			
			echo "<p>$table</p>";
			
			
			
			//create user-company relation table
			$sql = "SELECT * FROM usr_cmp WHERE usr_id='$currentUserId'";

			if($result = $worker->query($sql)) {
			
				$usr_cmp = "<table>" .
				"<tr><th>Works For</th><th>Relationship</th></tr>";
				
				while ($row = mysqli_fetch_assoc($result)) {
					
					extract($row);
					
					$company = $worker->findCompany($cmp_id, "name");
					
					$usr_cmp .= "<tr><td>$company</td><td>$rel</td>" .
					"<td><a href='settings.php?del=$cmp_id&uid=$currentUserId'>Remove</a></td></tr>";
					
				}
				
				$usr_cmp .= "</table>";
				
				echo "$usr_cmp";
				
			}
		
			//this form is for adding new companies to the users profile
			$companiesSelector = $worker->createSelector("company", "name", "cmp_id");
			
			$companiesForm = "<form action='settings.php?uid=$usr_id' method='post'>" .
			"Add Company: $companiesSelector <br/>" .
			"Relationship to Company: <select name='newRel'>" .
			"<option value='Employee'>Employee</option>" .
			"<option value='Distributor'>Distributor</option>" .
			"<option value='Other'>Other</option></select> <br />" .
			"<input type='submit' value='Commit Changes' />  </form>";
			
			echo "<p>$companiesForm</p>";
			
			echo "</div>";
				
		} else {
			echo "Database connection error.";
		}
		
		
	} else if($isClient) {
	
		//if its a client, display this page
		//delete relationship
	if(isset($_GET['del'])) {
	
		$toDelete = $_GET['del'];
		$sql = "DELETE FROM cli_site WHERE site_id='$toDelete' AND cli_id='$currentUserId'";
		
		$worker->query($sql);
		
		echo "Data successfully updated.";
	}
	
	//data input from form at bottom of page
	if(isset($_POST['newsites'])) {
		
		$site = $_POST['newsites'];
		
		$sql = "INSERT INTO cli_site (cli_id, site_id)" .
		"VALUES ('$currentUserId', '$site')";
		
		$worker->query($sql);
		
		echo "Data successfully updated";
	}
	
	$sql = "SELECT * FROM clients WHERE cli_id='$currentUserId'";
	
	if($result = $worker->query($sql)) {
		$row = mysqli_fetch_assoc($result);
		
		extract($row);
		
		$activeClient = ($active == 1) ? "Yes" : "No";
		
		echo "<h2>Client Detail for $uname</h2>";
		
		$table = "<table>" .
		"<tr><td><em>First Name:</em></td><td>$fname</td><td><a href='editSettings.php?mtd=fname'>Edit</a></td></tr>" .
		"<tr><td><em>Last Name:</em></td><td>$lname</td><td><a href='editSettings.php?mtd=lname'>Edit</a></td></tr>" .
		"<tr><td><em>Email:</em></td><td>$email</td><td><a href='editSettings.php?mtd=email'>Edit</a></td></tr>" .
		"<tr><td><em>Phone:</em></td><td>$phone</td><td><a href='editSettings.php?mtd=phone'>Edit</a></td></tr>" .
		"<tr><td><em>SMS:</em></td><td>$sms</td><td><a href='editSettings.php?mtd=sms'>Edit</a></td></tr>" .
		"<tr><a href='editSettings.php?mtd=pwd'>Change Password</a></tr>" .
		"</table><br/><br/>";
		
		echo $table;
		
		//create client-site relation table
		$sql = "SELECT * FROM cli_site WHERE cli_id='$currentUserId'";

		if($result = $worker->query($sql)) {
		
			$client_site = "<table>" .
			"<tr><th>Client Works At:</th></tr>";
			
			while ($row = mysqli_fetch_assoc($result)) {
				
				extract($row);
				
				$site = $worker->findSite($site_id, "name");
				
				$client_site .= "<tr><td>$site</td>" .
				"<td><a href='settings.php?del=$site_id&cid=$currentUserId'>Remove</a></td></tr>";
				
			}
			
			$client_site .= "</table>";
			
			echo "$client_site";
			
		}
		
		$siteSelector = $worker->createSelector("sites", "name", "site_id");
		
		$siteForm = "<form action='settings.php?cid=$currentUserId' method='post'>" .
		"Add Site: $siteSelector <br/>" .
		"<input type='submit' value='Commit Changes' />  </form>";
		
		echo "$siteForm";
		
		echo "</div>";
		
	} else {
		echo "Error connecting to database";
	}
	
	
	
	}
	 $worker->closeConnection();
	 $htmlUtils->makeFooter();
?>
	