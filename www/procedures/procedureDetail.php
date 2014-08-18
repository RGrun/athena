<?php

	//procedureDetail.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	echo "<div class='adminTable'>";
	
	$currentProcedure = $_GET['pid'];
	
	$_SESSION['currentProcedureId'] = $currentProcedure;
	
	//delete relationship
	if(isset($_GET['del'])) {
	
		$toDelete = $_GET['del'];
		$sql = "DELETE FROM procinsts WHERE inst_id='$toDelete' AND proc_id='$currentProcedure'";
		
		$worker->query($sql);
		
		echo "Data successfully updated.";
	}
	
	//data input from form at bottom of page
	if(isset($_POST['newinstruments'])) {
		
		$instrument = $_POST['newinstruments'];
		
		//map id to region name
		$quant = $_POST['newQuant'];
		
		$sql = "INSERT INTO procinsts (proc_id, inst_id, quant)" .
		"VALUES ('$currentProcedure', '$instrument', '$quant')";
		
		
		$worker->query($sql);
		
		echo "Data successfully updated";
	}
	
	$sql = "SELECT * FROM procs WHERE proc_id='$currentProcedure'";
	
	
	if($result = $worker->query($sql)) {
	
		$row = mysqli_fetch_assoc($result);
		
		extract($row);
	
		echo "<h2>Procedure Detail for $name</h2>";
		
		$table = "<table>" .
		"<tr><td><em>Name</em></td><td>$name</td><td><a href='editProcedureInfo.php?mtd=name'>Edit</a></td></tr>" .
		"</table>";
		
		echo "<p>$table</p>";
		
		//create procinsts table
		$sql = "SELECT * FROM procinsts WHERE proc_id='$currentProcedure'";

		if($result = $worker->query($sql)) {
		
			$instruments = "<table>" .
			"<tr><th>Contains:</th><th>Quantity</th></tr>";
			
			while ($row = mysqli_fetch_assoc($result)) {
				
				extract($row);
				
				$instName = $worker->findInstrument($inst_id, "name");
				
				$instruments .= "<tr><td>$instName</td><td>$quant</td>" .
				"<td><a href='procedureDetail.php?del=$inst_id&pid=$currentProcedure'>Remove</a></td></tr>";
				
			}
			
			$instruments .= "</table>";
			
			echo "<p>$instruments</p>";
			
		}
		
		$instrumentSelector = $worker->createSelector("instruments", "name", "inst_id");
		
		$instForm = "<form action='procedureDetail.php?pid=$proc_id' method='post'>" .
		"Add Instrument: $instrumentSelector <br/>" .
		"Quantity: <input type='text' name='newQuant' maxLength='4' /> <br/>" .
		"<input type='submit' value='Commit Changes' />  </form>";
		
		echo "<p>$instForm</p>";
		
		echo "</div>";
		
	} else {
		echo "Error connecting to database.";
	}
	
	$worker->closeConnection();
	$htmlUtils->makeFooter();
?>
		
		