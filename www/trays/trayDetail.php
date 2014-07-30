<?php

	//trayDetail.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$currentTrayId = $_GET['tid'];
	
	$error = "";
	
	$_SESSION['currentTrayId'] = $currentTrayId;
	
	
	//delete relationship
	if(isset($_GET['del'])) {
	
		$toDelete = $_GET['del'];
		$sql = "DELETE FROM traycont WHERE inst_id='$toDelete' AND tray_id='$currentTrayId'";
		
		$worker->query($sql);
		
		echo "Data successfully updated.";
	}
	
	//data input from form at bottom of page
	if(isset($_POST['newinstruments'])) {
		
		$inst = $_POST['newinstruments'];
		$quant = $_POST['newQuant'];
		$state = $_POST['newState'];
		$cmt = $_POST['newComment'];

		
		//check to see if the instrument is already in this tray
		$sql = "SELECT tray_id, inst_id FROM traycont WHERE tray_id='$currentTrayId' AND inst_id='$inst'";


		//$result = $worker->query($sql);
			
		if(null !==($result = $worker->query($sql))) {
		
		$sql = "INSERT INTO traycont (tray_id, inst_id, quant, state, cmt)" .
		"VALUES ('$currentTrayId', '$inst', '$quant', '$state', '$cmt')";
		
		$worker->query($sql);
		
		//echo "Data successfully updated";
		} else {
			//$error = "Invalid value entered";
		}
	}
	
	//content starts here
	$sql = "SELECT * FROM trays WHERE tray_id='$currentTrayId'";
	
	if($result = $worker->query($sql)) {
		$row = mysqli_fetch_assoc($result);
		
		extract($row);
		
		echo "<h2>Tray Detail</h2>";
		
		//echo "<span class='error'>$error</span>";
		
		$company = $worker->findCompany($cmp_id, "name");
		$team = $worker->findTeam($team_id, "name");
		$site = $worker->findSite($site_id, "name");
		$loanTeam = $worker->findTeam($loan_team, "name");
		
		$table = "<table>" .
		"<tr><td><em>Tray ID</em></td><td>$tray_id</td></tr>" .
		"<tr><td><em>Name</em></td><td>$name</td><td><a href='editTrayInfo.php?mtd=name'>Edit</a></td></tr>" .
		"<tr><td><em>Belongs To:</em></td><td>$company</td><td><a href='editTrayInfo.php?mtd=company'>Edit</a></td></tr>" .
		"<tr><td><em>Responsible Team:</em></td><td>$team</td><td><a href='editTrayInfo.php?mtd=team'>Edit</a></td></tr>" .
		"<tr><td><em>Current Location</em></td><td>$site</td><td><a href='editTrayInfo.php?mtd=site'>Edit</a></td></tr>" .
		"<tr><td><em>Loaned To</em></td><td>$loanTeam</td><td><a href='editTrayInfo.php?mtd=loanTeam'>Edit</a></td></tr>" .
		"<tr><td><em>Status</em></td><td>$status</td><td><a href='editTrayInfo.php?mtd=status'>Edit</a></td></tr>" .
		"</table>";
		
		echo "<p>$table</p>";
		
		//create traycont table (tray contents)
		$sql = "SELECT * FROM traycont WHERE tray_id='$currentTrayId'";

		if($result = $worker->query($sql)) {
		
			$traycont = "<table>" .
			"<tr><th>Tray Contents:</th></tr>" .
			"<tr><th>Instrument</th><th>Quantity</th><th>State</th><th>Comment</th></tr>";
			
			while ($row = mysqli_fetch_assoc($result)) {
				
				extract($row);
				
				$instrument = $worker->findInstrument($inst_id, "name");
				
				$traycont .= "<tr><td>$instrument</td>" .
				"<td>$quant</td><td>$state</td><td>$cmt</td>" .
				"<td><a href='editTrayContents.php?iid=$inst_id'>Modify</a></td>" .
				"<td><a href='trayDetail.php?del=$inst_id&tid=$currentTrayId'>Remove</a></td></tr>";
				
			}
			
			$traycont .= "</table>";
			
			echo "<p>$traycont</p>";
			
		}
		
		$instrumentSelector = $worker->createSelector("instruments", "name", "inst_id");
		
		$stateSelector = "<select name='newState' size='1'>" .
		"<option value='Present'>Present</option>" .
		"<option value='Missing'>Missing</option>" .
		"<option value='Removed'>Removed</option>" . 
		"<option value='Broken'>Broken</option>" .
		"<option value='Spent'>Spent</option>" .
		"</select>";
		
		$trayForm = "<form action='trayDetail.php?tid=$currentTrayId' method='post'>" .
		"Add instrument: $instrumentSelector <br/>" .
		"Quantity: <input type='text' name='newQuant' maxlength='4' /> <br/>" .
		"State of Item: $stateSelector <br />" .
		"Comment: <textarea rows='4' cols='50' name = 'newComment'></textarea><br/>" .
		"<input type='submit' value='Commit Changes' />  </form>";
		
		echo "<p>$trayForm</p>";
		
		
	} else {
		echo "Error connecting to database";
	}
	
	$htmlUtils->makeFooter();
	$worker->closeConnection();
	
?>