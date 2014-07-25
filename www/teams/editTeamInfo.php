<?php

	//editTeamInfo.php
	
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
	$currentTeam = $_SESSION['currentTeamId'];
	
	if($selectedMethod == "company") $selectedMethod = "cmp_id";
	if($selectedMethod == "leader") $selectedMethod = "head_id";
	
	echo "<h2>Edit Team Info: </h2>";
	
	if(isset($_POST['newData'])) {
		$worker->editTeamDatabase($selectedMethod, $currentTeam, $_POST['newData']);
		$worker->closeConnection();
	} elseif (isset($_POST['newcompany'])) {
		$worker->editTeamDatabase($selectedMethod, $currentTeam, $_POST['newcompany']);
		$worker->closeConnection();
	} else if (isset($_POST['newusers'])) {
		$worker->editTeamDatabase($selectedMethod, $currentTeam, $_POST['newusers']);
		$worker->closeConnection();
	} else if (isset($_POST['newregions'])) {
		$region = $worker->findRegion($_POST['newregions']);
		$worker->editTeamDatabase($selectedMethod, $currentTeam, $region);
		$worker->closeConnection();
	} else {
		$companySelector = $worker->createSelector("company", "name", "cmp_id");
		$leaderSelector = $worker->createSelector("users", "uname", "usr_id");
		$regionSelector = $worker->createSelector("regions", "name", "reg_id");
		
		$companyForm = "<form method='post' action='editTeamInfo.php'>$companySelector <br /> <br/>" .
		"<input type='submit' value='Commit Changes' /> </form>";
		$leaderForm = "<form method='post' action='editTeamInfo.php'>$leaderSelector <br/> <br/>" .
		"<input type='submit' value='Commit Changes' /> </form>";
			
		$regionForm = "<form method='post' action='editTeamInfo.php'>$regionSelector <br/> <br/>" .
		"<input type='submit' value='Commit Changes' /> </form>";
			

		
		$sql = "SELECT $selectedMethod FROM teams WHERE team_id='$currentTeam'";
		
		
		if($result = $worker->query($sql)) {
			
			$row = mysqli_fetch_array($result);
			
			$currentData = $row[0];
			
			$form = "<form method='post' action='editTeamInfo.php'>" .
			"<textarea name='newData' cols='20' rows='5'>$currentData</textarea><br />" .
			"<input type='submit' value='Commit Changes' /></form> <br/>";
		
			
			if($selectedMethod == "cmp_id") {
				$company = $worker->findCompany($currentData, "name");
				echo "<p>$companyForm</p>";
			} else if($selectedMethod == "head_id") {
				$leader = $worker->findUser($currentData, "uname");
				echo "<p>$leaderForm</p>";
			} else if($selectedMethod== "region") {
				echo "<p>$regionForm</p>";
			} else {
				echo $form;
			}
			
		}
		
		$htmlUtils->makeFooter();
		$worker->closeConnection();
	}
?>