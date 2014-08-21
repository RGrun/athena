<?php

	//instrumentDetail.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	echo "<div class='adminTable'>";
	
	$currentInstrumentId = $_GET['iid'];
	
	$_SESSION['currentInstrumentId'] = $currentInstrumentId;
	
	$sql = "SELECT * FROM instruments WHERE inst_id='$currentInstrumentId'";
	
	if($result = $worker->query($sql)) {
		$row = mysqli_fetch_assoc($result);
		
		extract($row);
		
		echo "<h2>Instrument Detail for $name</h2>";
		
		$table = "<table>" .
		"<tr><td><em>Instrument ID: </em></td><td>$inst_id</td>".
		"<tr><td><em>Name</em></td><td>$name</td><td><a href='editInstrumentInfo.php?mtd=name'>Edit</a></td></tr>" .
		"<tr><td><em>Part No: </em></td><td>$partno</td><td><a href='editInstrumentInfo.php?mtd=partno'>Edit</a></td></tr>" .
		"</table>";
		
		echo "<p>$table</p>";
		
		echo "</div>";
		
	} else {
		echo "Error connecting to database";
	}
	
	$htmlUtils->makeFooter();
	$worker->closeConnection();
	
?>