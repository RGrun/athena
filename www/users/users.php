<?php

	//users.php
	
	include_once("includes.php");
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	echo "<div class='adminTable'>";
	
	echo "<h2>Athena Users</h2>";
	
	echo "<em><a href='addNewUser.php'>Add New User</a></em><br/><br/>";
	
	echo "<table>" .
	"<tr><th>User ID</th><th>Active?</th><th>Team ID</th><th>First Name</th><th>Last Name</th><th>Username</th><th>Email</th><th>Phone</th><th>SMS</th><th>Permissions</th></tr>";
	
	$sql = "SELECT * FROM users";
	
	if($result = $worker->query($sql)) {
		
		//get assoc array and print table data
		while($row = mysqli_fetch_assoc($result)) {
			
			extract($row);
			
			echo "<tr>";
			
			echo "<td>$usr_id</td>";
			
			if($active == 1) echo "<td>Yes</td>";
			else echo "<td>No</td>";
			
			$team = $worker->findTeam($team_id, "name");
			
			echo "<td>$team</td>";
			echo "<td>$fname</td>";
			echo "<td>$lname</td>";
			echo "<td>$uname</td>";
			echo "<td>$email</td>";
			echo "<td>$phone</td>";
			echo "<td>$sms</td>";
			echo "<td>$perm</td>";
			echo "<td><a href='userDetail.php?uid=$usr_id'>Detail</a></td>";
			echo "<td><a href='deleteUser.php?uid=$usr_id'>Delete</a></td></tr>";
			
		}
			echo "</table>";
			
			echo "</div>";
			
	} else {
		echo "Database Connection Error";
	}
	

	
	$worker->closeConnection();
	$htmlUtils->makeFooter();
?>
	