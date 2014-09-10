<?php

	//procedureDetail.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	$userCompanies = $_SESSION['userCompanies'];
	
	echo "<div class='adminTable'>";
	
	$currentProcedure = $_GET['pid'];
	
	$_SESSION['currentProcedureId'] = $currentProcedure;
	
	//delete relationship
	if(isset($_GET['del'])) {
	
		$toDelete = $_GET['del'];
		$sql = "DELETE FROM proc_inst WHERE inst_id='$toDelete' AND proc_id='$currentProcedure'";
		
		$worker->query($sql);
		
		echo "Data successfully updated.";
	}
	
	//data input from form at bottom of page
	if(isset($_POST['newinstruments'])) {
		
		$instrument = $_POST['newinstruments'];
		
		//map id to region name
		$quant = $_POST['newQuant'];
		
		$sql = "INSERT INTO proc_inst (proc_id, inst_id, quant)" .
		"VALUES ('$currentProcedure', '$instrument', '$quant')";
		
		
		$worker->query($sql);
		
		echo "Data successfully updated";
	}
	
	$sql = "SELECT * FROM procs WHERE proc_id='$currentProcedure'";
	
	
	if($result = $worker->query($sql)) {
	
		$row = mysqli_fetch_assoc($result);
		
		extract($row);
	
		echo "<h2>Procedure Detail for $name</h2>";
		
		$company = $worker->findCompany($cmp_id, "name");
		if($company == null) $company = "Pending";
		
		$table = "<table>" .
		"<tr><td><em>Name:</em></td><td>$name</td><td><a href='editProcedureInfo.php?mtd=name'>Edit</a></td></tr>" .
		"<tr><td><em>Company:</em></td><td>$company</td><td><a href='editProcedureInfo.php?mtd=company'>Edit</a></td></tr>" .
		"</table>";
		
		echo "$table";
		
		//create procinsts table
		$sql = "SELECT * FROM proc_inst WHERE proc_id='$currentProcedure'";

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
			
			echo "$instruments";
			
		}
		
		$instrumentSelector = $worker->createSelector("instruments", "name", "inst_id");
		
		$instForm = "<form action='procedureDetail.php?pid=$proc_id' method='post'>" .
		"Add Instrument: $instrumentSelector <br/>" .
		"Quantity: <input type='text' name='newQuant' maxLength='4' /> <br/>" .
		"<input type='submit' value='Commit Changes' />  </form>";
		
		echo "$instForm";
		
		echo "</div>";
		
		echo "<div class='landingview'>"; //open landingview
		
		//add tags here
		
		$tagSql = "SELECT tag FROM proc_tag WHERE proc_id='$proc_id'";
		//echo $tagSql;
		$tagResult = $worker->query($tagSql);
		$tagTable = "<div class='tagTable'>"; //open tagTable
		$tagTable .= "<div class='tagsView'>"; //open tagsView
		$tagTable .= "<h2>Tags: </h2><br/>";
		
		while ($tagRow = mysqli_fetch_array($tagResult)) {
		
			$tagName = $tagRow[0];
			$tagTable .= "<div class='tag'>";
			$tagTable .= "<div class='tagName'>$tagName</div><div class='tagX'><a href='/athena/www/tags/deleteProcTags.php?del=1&proc_id=$proc_id&tag=$tagName'><img src='/athena/www/utils/images/blackX.png' height='16' width='16' /></a></div></div>";
		
		
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
		
		$tagForm = "<form method='post' action='/athena/www/tags/addProcTags.php'>$tagSelector <br/> <input type='submit' value='Add Tag' /><input type='hidden' name='procedure' value='$proc_id' /></form>";
		
		
		$tagTable .= $tagForm;
		
		$tagTable .= "</div>"; //close tagTable
		
		echo $tagTable;
	
		
		echo "</div>"; //close landingview
		
	} else {
		echo "Error connecting to database.";
	}
	
	$worker->closeConnection();
	$htmlUtils->makeFooter();
?>
		
		