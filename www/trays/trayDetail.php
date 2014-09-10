<?php

	//trayDetail.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$currentTrayId = $_GET['tid'];
	
	$error = "";
	
	$_SESSION['currentTrayId'] = $currentTrayId;
	
	$userCompanies = $_SESSION['userCompanies'];
	
	//delete relationship
	if(isset($_GET['del'])) {
	
		$toDelete = $_GET['del'];
		$sql = "DELETE FROM traycont WHERE inst_id='$toDelete' AND tray_id='$currentTrayId'";
		
		$worker->query($sql);
		
		echo "Data successfully updated.";
	}
	
	//data input from form at bottom of page (for instruments)
	if(isset($_POST['newinstruments'])) {
		
		$inst = $_POST['newinstruments'];
		$quant = $_POST['newQuant'];
		$state = $_POST['newState'];
		$cmt = addslashes($_POST['newComment']);

		
		//check to see if the instrument is already in this tray
		$sql = "SELECT tray_id, inst_id FROM traycont WHERE tray_id='$currentTrayId' AND inst_id='$inst'";
		

		//$result = $worker->query($sql);
			
		if(null !==($result = $worker->query($sql))) {
		
		$sql = "INSERT INTO traycont (tray_id, inst_id, quant, state, cmt)" .
		"VALUES ('$currentTrayId', '$inst', '$quant', '$state', '$cmt')";
		$worker->query($sql);
		
		$time = time();
		$time = date("Y-m-d H:i:s", $time);
		//log changes
		$sql = "INSERT INTO h_traycont (asgn_id, tray_id, inst_id, quant, state, cmt, dttm) VALUES ('0', '$currentTrayId', '$inst', '$quant', '$state', '$cmt', '$time')";
		//echo $sql;
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
		
		echo "<div class='adminTable'>";
		
		echo "<h2>Tray Detail</h2>";
		
		//echo "<span class='error'>$error</span>";
		
		$company = $worker->findCompany($cmp_id, "name");
		$team = $worker->findTeam($team_id, "name");
		$site = $worker->findSite($site_id, "name");
		$loanTeam = $worker->findTeam($loan_team, "name");
		$storage = $worker->findStorage($stor_id, "name");
		
		if($loanTeam == null) $loanTeam = "None";
		
		if($atnow == "usr") $status = "With user";
		if($atnow == "site") $status = "At site";
		if($atnow == "stor") $status = "In storage";
		if($atnow == "unk") $status = "Unknown";
		
		$table = "<table>" .
		"<tr><td><em>Tray ID:</em></td><td>$tray_id</td></tr>" .
		"<tr><td><em>Name:</em></td><td>$name</td><td><a href='editTrayInfo.php?mtd=name'>Edit</a></td></tr>" .
		"<tr><td><em>Belongs To:</em></td><td>$company</td><td><a href='editTrayInfo.php?mtd=company'>Edit</a></td></tr>" .
		"<tr><td><em>Responsible Team:</em></td><td>$team</td><td><a href='editTrayInfo.php?mtd=team'>Edit</a></td></tr>" .
		"<tr><td><em>Current Location:</em></td><td>$site</td><td><a href='editTrayInfo.php?mtd=site'>Edit</a></td></tr>" .
		"<tr><td><em>Loaned To:</em></td><td>$loanTeam</td><td><a href='editTrayInfo.php?mtd=loanTeam'>Edit</a></td></tr>" .
		"<tr><td><em>Storage Location:</em></td><td>$storage</td><td><a href='editTrayInfo.php?mtd=stor_id'>Edit</a></td></tr>" .
		"<tr><td><em>Status:</em></td><td>$status</td><td><a href='editTrayInfo.php?mtd=atnow'>Edit</a></td></tr>" .
		"</table>";
		
		echo "$table";
		
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
				"<td><a href='editTrayContents.php?su=1&iid=$inst_id'>Modify</a></td>" .
				"<td><a href='trayDetail.php?del=$inst_id&tid=$currentTrayId'>Remove</a></td></tr>";
				
			}
			
			$traycont .= "</table>";
			
			echo "$traycont";
			
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
		
		echo "$trayForm";
		
		echo "</div>"; //end adminTable
		
		
		//display tags here
		
		$tagSql = "SELECT tag FROM tray_tag WHERE tray_id='$currentTrayId'";
		//echo $tagSql;
		$tagResult = $worker->query($tagSql);
		$tagTable = "<div class='tagTable'>"; //open tagTable
		$tagTable .= "<div class='tagsView'>"; //open tagsView
		$tagTable .= "<h2>Tags: </h2><br/>";
		
		while ($tagRow = mysqli_fetch_array($tagResult)) {
		
			$tagName = $tagRow[0];
			$tagTable .= "<div class='tag'>";
			$tagTable .= "<div class='tagName'>$tagName</div><div class='tagX'><a href='/athena/www/tags/deleteTrayTags.php?del=1&tray_id=$tray_id&tag=$tagName'><img src='/athena/www/utils/images/blackX.png' height='16' width='16' /></a></div></div>";
		
		
		}
		
		$tagTable .= "</div>"; //close tagsView
		
		//add tags form
		$tagSql = "SELECT tag, cmp_id FROM tags";
		$tagResult = $worker->query($tagSql);
		
		$tagSelector = "<select name='newTag' size='1'>";
		while($tagRow = mysqli_fetch_array($tagResult)) {

		
			if(in_array($tagRow[1], $userCompanies) || $tagRow[1] == "0")
				$tagSelector .= "<option value='$tagRow[0]'>$tagRow[0]</option>";

		}
		
		$tagSelector .= "</select>";
		
		$tagTable .= "<p>Select new tags: </p>";
		
		$tagForm = "<form method='post' action='/athena/www/tags/addTags.php'>$tagSelector <br/> <input type='submit' value='Add Tag' /><input type='hidden' name='tray' value='$tray_id' /></form>";
		
		
		$tagTable .= $tagForm;
		
		$tagTable .= "</div>"; //close tagTable
		
		echo $tagTable;
	
		
		echo "</div>"; //close landingview
		
		
		
	} else {
		echo "Error connecting to database";
	}
	
	$htmlUtils->makeFooter();
	$worker->closeConnection();
	
?>