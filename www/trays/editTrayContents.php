<?php

	//editTrayContents.php
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$currentTrayId = $_SESSION['currentTrayId'];
	
	//check to see if this page was reached from an admin page or a user's page
	if(isset($_GET['su'])) {
		$backLink = "<h6><a href='trayDetail.php?tid=$currentTrayId'>Back to tray admin page.</a></h6>";
	} else {
		$backLink = "<h6><a href='/athena/www/viewTrayDetail.php?tid=$currentTrayId'>Click here when finished editing</a></h6>";	
	}
	
	if(isset($_GET['iid'])) {
		$currentInstId = $_GET['iid'];
	}
	
	if(isset($_POST['newQuant'])) {
		$worker->editTrayContents("quant", $currentInstId, $_POST['newQuant'], $currentTrayId);
	} if(isset($_POST['newState'])) {
		$worker->editTrayContents("state", $currentInstId, $_POST['newState'], $currentTrayId);
	} if(isset($_POST['newComment'])) {
		$worker->editTrayContents("cmt", $currentInstId, addSlashes($_POST['newComment']), $currentTrayId);
	}
	
	//create traycont table (tray contents)
	$sql = "SELECT * FROM traycont WHERE tray_id='$currentTrayId' AND inst_id='$currentInstId'";

		if($result = $worker->query($sql)) {
		
			$instrument = $worker->findInstrument($currentInstId, "name");
			$tray = $worker->findTray($currentTrayId, "name");
			
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
			
			echo "<p>$traycont</p>";
		
		$stateSelector = "<select name='newState' size='1'>" .
		"<option value='Present'>Present</option>" .
		"<option value='Missing'>Missing</option>" .
		"<option value='Removed'>Removed</option>" . 
		"<option value='Broken'>Broken</option>" .
		"<option value='Spent'>Spent</option>" .
		"</select>";
		
		$trayForm = "<form action='editTrayContents.php?iid=$currentInstId' method='post'>" .
		"Quantity: <input type='text' name='newQuant' maxlength='4' /> <br/>" .
		"State of Item: $stateSelector <br />" .
		"Comment: <textarea rows='4' cols='50' name='newComment'></textarea><br/>" .
		"<input type='submit' value='Commit Changes' />  </form>";
		
		echo "<h2>Modify tray data: </h2>";
		
		echo "<p>$trayForm</p>";
		

	}
	$htmlUtils->makeFooter();
	$worker->closeConnection();
	
?>
	