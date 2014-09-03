<?php

	//editMultiSelectContents.php
	//Same as edit tray contents page, but for multi-select
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$currentTrayId = $_GET['tid'];
	if(isset($_GET['mtd']))$currentMethod = $_GET['mtd'];
	else $currentMethod = "";
	
	$index = $_GET['index'];
	
	//check to see if this page was reached from an admin page or a user's page
	if(isset($_GET['mtd'])) {
		$backLink = "<h6><a href='multiSignature.php?mtd=$currentMethod&index=$index'>Click here when finished editing.</a></h6>";
	} else {
		if($currentMethod == "dropoff") {
			$backLink = "<h6><a href='multiSignature.php?mtd=$currentMethod&index=$index'>Click here when finished editing</a></h6>";	
		} else if($currentMethod == "pickup") {
			$backLink = "<h6><a href='multiSignature.php?mtd=$currentMethod&index=$index'>Click here when finished editing</a></h6>";
		} else {
			$backLink = "";
		}
		
	}
	
	if(isset($_GET['iid'])) {
		$currentInstId = $_GET['iid'];
	}
	
	if(isset($_POST['newQuant'])) {
		$worker->editTrayContents("quant", $currentInstId, $_POST['newQuant'], $currentTrayId, $currentMethod, false);
	} if(isset($_POST['newState'])) {
		$worker->editTrayContents("state", $currentInstId, $_POST['newState'], $currentTrayId, $currentMethod, false);
	} if(isset($_POST['newComment'])) {
		$worker->editTrayContents("cmt", $currentInstId, addSlashes($_POST['newComment']), $currentTrayId, $currentMethod, false);
		//need this info for logging
		$sql = "SELECT * FROM traycont WHERE inst_id='$currentInstId' AND tray_id='$currentTrayId'";
				
		$result = $worker->query($sql);
		$row = mysqli_fetch_assoc($result);
		extract($row);
				
		$time = time();
		$time = date("Y-m-d H:i:s", $time);
		//logging
		$sql = "INSERT INTO h_traycont (asgn_id, tray_id, inst_id, quant, state, cmt, dttm) VALUES ('0', '$tray_id', '$inst_id', '$quant', '$state', '$cmt', '$time')";
		$worker->query($sql);
	}
	
	//create traycont table (tray contents)
	$sql = "SELECT * FROM traycont WHERE tray_id='$currentTrayId' AND inst_id='$currentInstId'";

		if($result = $worker->query($sql)) {
		
			$instrument = $worker->findInstrument($currentInstId, "name");
			$tray = $worker->findTray($currentTrayId, "name");
			
			echo "<div class='adminTable'>";
			
			echo "<h2>Modifying $instrument in $tray</h2>";
			
			echo $backLink;
	
			$traycont = "<table>";
			
			while ($row = mysqli_fetch_assoc($result)) {
				
				extract($row);
				
				$traycont .= "<tr><td><em>Quantity</em></td><td>$quant</td></tr>" .
				"<tr><td><em>State</em></td><td>$state</td></tr>" .
				"<tr><td><em>Comment</em></td><td>$cmt</td></tr>";
				
			}
			
			$traycont .= "</table>";
			
			echo "$traycont";
		
		$stateSelector = "<select name='newState' size='1'>" .
		"<option value='Present'>Present</option>" .
		"<option value='Missing'>Missing</option>" .
		"<option value='Removed'>Removed</option>" . 
		"<option value='Broken'>Broken</option>" .
		"<option value='Spent'>Spent</option>" .
		"</select>";
		
		$trayForm = "<form action='editMultiSelectContents.php?iid=$currentInstId&mtd=$currentMethod&tid=$currentTrayId&source=multi&index=$index' method='post'>" .
		"Quantity: <input type='text' name='newQuant' maxlength='4' /> <br/>" .
		"State of Item: $stateSelector <br />" .
		"Comment: <textarea rows='4' cols='50' name='newComment'></textarea><br/>" .
		"<input type='submit' value='Commit Changes' />  </form>";
		
		echo "<h2>Modify tray data: </h2>";
		
		echo "$trayForm";
		
		echo "</div>";
		

	}
	$htmlUtils->makeFooter();
	$worker->closeConnection();
	
?>
	