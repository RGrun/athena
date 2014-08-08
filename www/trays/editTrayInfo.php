<?php
	
	//editTrayInfo.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	if(isset($_GET['mtd'])){
		$selectedMethod = $_GET['mtd'];
		$_SESSION['selectedMethod'] = $selectedMethod;
	} else {
		$selectedMethod = $_SESSION['selectedMethod'];
	}
	$currentTray = $_SESSION['currentTrayId'];
	
	if($selectedMethod == "company") $selectedMethod = "cmp_id";
	if($selectedMethod == "team") $selectedMethod = "team_id";
	if($selectedMethod == "site") $selectedMethod = "site_id";
	if($selectedMethod == "loanTeam") $selectedMethod = "loan_team";
	
	echo "<h2>Edit Tray Info: </h2>";
	
	//These all lead back to the main list view
	if(isset($_POST['newData'])) {
		$worker->editTrayDatabase($selectedMethod, $currentTray, $_POST['newData']);
		$worker->closeConnection();
	} elseif (isset($_POST['newcompany'])) {
		$worker->editTrayDatabase($selectedMethod, $currentTray, $_POST['newcompany']);
		$worker->closeConnection();
	} else if (isset($_POST['newteams'])) {
		$worker->editTrayDatabase($selectedMethod, $currentTray, $_POST['newteams']);
		$worker->closeConnection();
	} else if (isset($_POST['newsites'])) {
		$worker->editTrayDatabase($selectedMethod, $currentTray, $_POST['newsites']);
		$worker->closeConnection();
	} else if(isset($_POST['newStatus'])) {
		$worker->editTrayDatabase($selectedMethod, $currentTray, $_POST['newStatus']);
		$worker->closeConnection();
	} elseif (isset($_POST['newstorage'])) {
		$worker->editTrayDatabase($selectedMethod, $currentTray, $_POST['newstorage']);
		$worker->closeConnection();
	} else {

		$companySelector = $worker->createSelector("company", "name", "cmp_id");
		$teamSelector = $worker->createSelector("teams", "name", "team_id");
		$siteSelector = $worker->createSelector("sites", "name", "site_id");
		$storageSelector = $worker->createSelector("storage", "name", "stor_id");
		
		$storageForm = "<form method='post' action='editTrayInfo.php'>$storageSelector <br/> <br/>" .
		"<input type='submit' value='Commit Changes' /> </form>";
		$companyForm = "<form method='post' action='editTrayInfo.php'>$companySelector <br /> <br/>" .
		"<input type='submit' value='Commit Changes' /> </form>";
		$teamForm = "<form method='post' action='editTrayInfo.php'>$teamSelector <br/> <br/>" .
		"<input type='submit' value='Commit Changes' /> </form>";
		$siteForm = "<form method='post' action='editTrayInfo.php'>$siteSelector <br/> <br/> " .
		"<input type='submit' value='Commit Changes' /> </form>";
		
		$statusSelector = "<select name='newStatus' size='1'>" .
		"<option value='stor'>In Storage</option>" .
		"<option value='usr'>With User</option>" .
		"<option value='site'>At Site</option>" .
		"<option value='unk'>Unkown</option>" .
		"</select>";
		
		$statusForm = "<form method='post' action='editTrayInfo.php'>" .
		"$statusSelector<br />" .
		"<input type='submit' value='Commit Changes' /></form> <br/>";
		


		
		$sql = "SELECT $selectedMethod FROM trays WHERE tray_id='$currentTray'";
		
		
		if($result = $worker->query($sql)) {
			
			$row = mysqli_fetch_array($result);
			
			$currentData = $row[0];
			
			$form = "<form method='post' action='editTrayInfo.php'>" .
			"<textarea name='newData' cols='20' rows='5'>$currentData</textarea><br />" .
			"<input type='submit' value='Commit Changes' /></form> <br/>";
		
			
			if($selectedMethod == "cmp_id") {
				$company = $worker->findCompany($currentData, "name");
				echo "$company <br/>";
				echo "<p>$companyForm</p>";
			} elseif(($selectedMethod == "team_id") || $selectedMethod == "loan_team") {
				$team = $worker->findTeam($currentData, "name");
				echo "$team <br />";
				echo "<p>$teamForm</p>";
			} elseif($selectedMethod == "site_id") {
				$site = $worker->findSite($currentData, "name");
				echo "$site <br/>";
				echo "<p>$siteForm</p>";
			} elseif($selectedMethod == "atnow") {
				if($currentData == "usr") $currentData = "With user";
				if($currentData == "site") $currentData = "At site";
				if($currentData == "stor") $currentData = "In storage";
				if($currentData == "unk") $currentData = "Unknown";
				echo $currentData;
				echo "<p>$statusForm</p>";
			} elseif($selectedMethod == "stor_id") {
				echo $currentData;
				echo "$storageForm";
			} else {
				echo $form;
			}
			
		}
		
		$htmlUtils->makeFooter();
		$worker->closeConnection();
	}
?>