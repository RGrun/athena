<?php
	
	//dropoff.php
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeScriptHeader();
	
	$pageTitle = "<div class='pagetitle'><div class='wrapper'><span id='titleicon'>&#x21f2;</span><span id='title'>DROP OFF TRAYS</span></div></div>";
	
	echo $pageTitle;
	
	$userStr = $_SESSION['user'];
	$userId = $_SESSION['userId'];
	
	$method = "dropoff";
	
	$usersTeamId = $worker->findUser($userId, "team_id");

	$landingDropdown = $worker->createLandingDropdown($userId, $method);
	
	$filterForm = "<div class='filterform'>Filter trays: <br/>$landingDropdown" .
	"</div>";
	
	echo $filterForm;
	
	$htmlUtils->timestampLegend();

	//these are for debugging javascript
	//echo "<p id='js'></p>";
	//echo "<p id='js2'></p>";
	//echo "<p id='js3'></p>";
	
	echo "<div class='landingview'>";
	
	//default display is "all" view
	
	//print sites tables
	//for dropoff page: show only trays related to users team and in storage or unknown
	$sql = "SELECT * FROM trays WHERE (team_id='$usersTeamId' OR loan_team='$usersTeamId')";// AND (atnow='stor' OR atnow='unk')";
	
	$result = $worker->query($sql);
	
	if($result->num_rows > 0) {
		//print tables
		while($row = mysqli_fetch_assoc($result)) {
			
			echo $worker->makeDropoffSitesTrayTables($row, $usersTeamId, $userId);
		
		}
	
	}
	
	echo "</div>";
	
	$htmlUtils->makeFooter();
	$worker->closeConnection();
?>