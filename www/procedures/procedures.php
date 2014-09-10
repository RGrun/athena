<?php

	//procedures.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	echo "<div class='adminTable'>";
	
	echo "<h2>Athena Procedures</h2>";
	
	echo "<em><a href='addNewProcedure.php'>Add New Procedure</a></em>";
	
	$sql = "SELECT * FROM procs";
	
	if($result = $worker->query($sql)) {
	
		$table = "<table>" .
		"<tr><th>Procedure ID</th><th>Name</th><th>Company</th></tr>"; 
		
		while($row = mysqli_fetch_assoc($result)) {			
			
			extract($row);
			
			$company = $worker->findCompany($cmp_id, "name");
			if($company == null) $company = "Pending";
			
	
			$table .= ("<tr><td>$proc_id</td><td>$name</td><td>$company</td>" .
			"<td><a href='procedureDetail.php?pid=$proc_id'>Detail</a></td><td><a href='deleteProcedure.php?pid=$proc_id'>Delete</a></td>");

		}
		
		$table .= "</table>";
		
		echo "$table";
		
		echo "</div>";
		
	} else {
		echo "Error connecting to database.";
	}
	
	$worker->closeConnection();
	$htmlUtils->makeFooter();
	
?>