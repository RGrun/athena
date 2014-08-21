<?php

	//userDetail.php 
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	echo "<div class='adminTable'>";
	
	$currentUsrId = $_GET['uid'];
	
	$_SESSION['currentUserId'] = $currentUsrId;
	
	//delete relationship
	if(isset($_GET['del'])) {
	
		$toDelete = $_GET['del'];
		$sql = "DELETE FROM usr_cmp WHERE cmp_id='$toDelete' AND usr_id='$currentUsrId'";
		
		$worker->query($sql);
		
		echo "Data successfully updated.";
	}
	
	//data input from form at bottom of page
	if(isset($_POST['newcompany'])) {
		
		$company = $_POST['newcompany'];
		$rel = $_POST['newRel'];
		
		$sql = "INSERT INTO usr_cmp (usr_id, cmp_id, rel)" .
		"VALUES ('$currentUsrId', '$company', '$rel')";
		
		$worker->query($sql);
		
		echo "Data successfully updated";
	}
	
	
	$sql = "SELECT * FROM users WHERE usr_id='$currentUsrId'";
	
	if($result = $worker->query($sql)) {
		$row = mysqli_fetch_assoc($result);
		
		extract($row);
		
		$activeUser = ($active == 1) ? 'Yes' : 'No';
		
		echo "<h2>User Detail for $uname</h2> <br/>";
		
		$team = $worker->findTeam($team_id, "name");
		
		$table = "<table>" .
		"<tr><td><em>Active User?</em></td><td>$activeUser</td><td><a href='editUserInfo.php?mtd=active'>Edit</a></td></tr>" .
		"<tr><td><em>First Name</em></td><td>$fname</td><td><a href='editUserInfo.php?mtd=fname'>Edit</a></td></tr>" .
		"<tr><td><em>Last Name</em></td><td>$lname</td><td><a href='editUserInfo.php?mtd=lname'>Edit</a></td></tr>" .
		"<tr><td><em>Team ID</em></td><td>$team</td><td><a href='editUserInfo.php?mtd=team_id'>Edit</a></td></tr>" .
		"<tr><td><em>Email</em></td><td>$email</td><td><a href='editUserInfo.php?mtd=email'>Edit</a></td></tr>" .
		"<tr><td><em>Phone</em></td><td>$phone</td><td><a href='editUserInfo.php?mtd=phone'>Edit</a></td></tr>" .
		"<tr><td><em>SMS</em></td><td>$sms</td><td><a href='editUserInfo.php?mtd=sms'>Edit</a></td></tr>" .
		"<tr><td><em>Permissions</em></td><td>$perm</td><td><a href='editUserInfo.php?mtd=perm'>Edit</a></td></tr>" .
		"</table><br/><br/>";
		
		echo "$table";
		
		//create user-company relation table
		$sql = "SELECT * FROM usr_cmp WHERE usr_id='$currentUsrId'";

		if($result = $worker->query($sql)) {
		
			$usr_cmp = "<table>" .
			"<tr><th>Works For</th><th>Relationship</th></tr>";
			
			while ($row = mysqli_fetch_assoc($result)) {
				
				extract($row);
				
				$company = $worker->findCompany($cmp_id, "name");
				
				$usr_cmp .= "<tr><td>$company</td><td>$rel</td>" .
				"<td><a href='userDetail.php?del=$cmp_id&uid=$currentUsrId'>Remove</a></td></tr>";
				
			}
			
			$usr_cmp .= "</table>";
			
			echo "$usr_cmp";
			
		}
	
		//this form is for adding new companies to the users profile
		$companiesSelector = $worker->createSelector("company", "name", "cmp_id");
		
		$companiesForm = "<form action='userDetail.php?uid=$usr_id' method='post'>" .
		"Add Company: $companiesSelector <br/>" .
		"Relationship to Company: <select name='newRel'>" .
		"<option value='Employee'>Employee</option>" .
		"<option value='Distributor'>Distributor</option>" .
		"<option value='Other'>Other</option></select> <br />" .
		"<input type='submit' value='Commit Changes' />  </form>";
		
		echo "$companiesForm";
		
		echo "</div>";
			
	} else {
			echo "Database connection error.";
	}
	 $worker->closeConnection();
	 $htmlUtils->makeFooter();
?>