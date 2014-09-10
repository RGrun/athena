<?php

	//doctorDetail.php
	
	require_once "includes.php";

	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	echo "<div class='adminTable'>";
	
	$currentDoctorId = $_GET['did'];
	
	$_SESSION['currentDoctorId'] = $currentDoctorId;
	
	//delete relationship
	if(isset($_GET['del'])) {
		
		$toDelete = $_GET['del'];
		
		if(!isset($_GET['mtd'])) $sql = "DELETE FROM doc_site WHERE site_id='$toDelete' AND doc_id='$currentDoctorId'";
		else $sql = "DELETE FROM doc_cmp WHERE cmp_id='$toDelete' AND doc_id='$currentDoctorId'";
		
		$worker->query($sql);
		
		echo "Data successfully updated.";
	}
	
	//data input from form at bottom of page
	if(isset($_POST['newsites'])) {
		
		$site = $_POST['newsites'];
		
		$sql = "INSERT INTO doc_site (doc_id, site_id)" .
		"VALUES ('$currentDoctorId', '$site')";
		
		$worker->query($sql);
		
		echo "Data successfully updated";
	}
	
	if(isset($_POST['newcompany'])) {
	
		$company = $_POST['newcompany'];
		
		$sql = "INSERT INTO doc_cmp (doc_id, cmp_id) VALUES ('$currentDoctorId', '$company')";
	
		$worker->query($sql);
		
		echo "Data successfully updated";
	
	}
	
	$sql = "SELECT * FROM doctors WHERE doc_id='$currentDoctorId'";
	
	if($result = $worker->query($sql)) {
		$row = mysqli_fetch_assoc($result);
		
		extract($row);
		
		$activeDoctor = ($active == 1) ? "Yes" : "No";
		
		echo "<h2>Doctor Detail for $name</h2>";
		
		$table = "<table>" .
		"<tr><td><em>Doctor ID</em></td><td>$doc_id</td></tr>" .
		"<tr><td><em>Active Doctor?</em></td><td>$activeDoctor</td><td><a href='editDoctorInfo.php?mtd=active'>Edit</a></td></tr>" .
		"<tr><td><em>Name</em></td><td>$name</td><td><a href='editDoctorInfo.php?mtd=name'>Edit</a></td></tr>" .
		"</table>";
		
		echo "<p>$table</p>";
		
		//create doctor-site relation table
		$sql = "SELECT * FROM doc_site WHERE doc_id='$currentDoctorId'";

		if($result = $worker->query($sql)) {
		
			$doc_site = "<table>" .
			"<tr><th>Works at:</th></tr>";
			
			while ($row = mysqli_fetch_assoc($result)) {
				
				extract($row);
				
				$site = $worker->findSite($site_id, "name");
				
				$doc_site .= "<tr><td>$site</td>" .
				"<td><a href='doctorDetail.php?del=$site_id&did=$currentDoctorId'>Remove</a></td></tr>";
				
			}
			
			$doc_site .= "</table>";
			
			
		}
		
		//create doctor-company relation table
		$sql = "SELECT * FROM doc_cmp WHERE doc_id='$currentDoctorId'";

		if($result = $worker->query($sql)) {
		
			$doc_site .= "<table>" .
			"<tr><th>Works For:</th></tr>";
			
			while ($row = mysqli_fetch_assoc($result)) {
				
				extract($row);
				
				$company = $worker->findCompany($cmp_id, "name");
				
				$doc_site .= "<tr><td>$company</td>" .
				"<td><a href='doctorDetail.php?del=$cmp_id&mtd=company&did=$currentDoctorId'>Remove</a></td></tr>";
				
			}
			
			$doc_site .= "</table>";
			
			echo "$doc_site";
			
		}
		
		$siteSelector = $worker->createSelector("sites", "name", "site_id");
		
		$siteForm = "<form action='doctorDetail.php?did=$currentDoctorId' method='post'>" .
		"Add Site: $siteSelector <br/>" .
		"<input type='submit' value='Commit Changes' />  </form>";
		
		$companySelector = $worker->createSelector("company", "name", "cmp_id");
		
		$companyForm = "<form action='doctorDetail.php?did=$currentDoctorId' method='post'>" .
		"Add Company: $companySelector <br/>" .
		"<input type='submit' value='Commit Changes' />  </form>";
		
		
		echo "<div style='margin-bottom: 10px;'>$siteForm</div>";
		
		echo "<div style='margin-bottom: 10px;'>$companyForm</div>";
		
		echo "</div>";
		
	} else {
		echo "Error connecting to database";
	}
	
	$htmlUtils->makeFooter();
	$worker->closeConnection();
	
?>