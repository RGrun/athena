<?php

	//detail.php
	
	require_once "includes.php";
	
	
	//establish db connection
	$worker = new dbWorker();
	
	$htmlUtils = new htmlUtils();
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	echo "<div class='adminTable'>";
	
	$detailedCompany = $_GET['cid'];
	
	//delete relationship
	if(isset($_GET['del'])) {
	
		$toDelete = $_GET['del'];
		$sql = "DELETE FROM dst_cmp WHERE dst_id='$toDelete' AND cmp_id='$detailedCompany' ";

		$worker->query($sql);
		
		echo "Data successfully updated.";
	}
	
	//data input from form at bottom of page
	if(isset($_POST['newcompany'])) {
		
		$company = $_POST['newcompany'];
		
		$sql = "INSERT INTO dst_cmp (dst_id, cmp_id)" .
		"VALUES ('$company', '$detailedCompany')";
		
		$worker->query($sql);
		
		echo "Data successfully updated";
	}
	
	$sql = "SELECT * FROM company WHERE cmp_id=$detailedCompany";
	
	if($result = $worker->query($sql)) {
	
		echo "<table>";
		
		//get assoc array and print each field as a row
		
		$row = mysqli_fetch_assoc($result);
		
		extract($row);
		
		echo "<h2>Detail View for $name</h2>";
		
		$_SESSION['currentCompany'] = $cmp_id;
		
		$activeComapny = ($active == 1) ? 'Yes' : 'No';
		

		echo "<tr><td><em>Active Company?</em></td><td>$activeComapny</td><td><a href='editCompanyInfo.php?mtd=active'>Edit</a></td></tr>";

		echo "<tr><td><em>Company Name</em></td><td>$name</td><td><a href='editCompanyInfo.php?mtd=name'>Edit</a></td></tr>";
		echo "<tr><td><em>Company Address</em></td><td>$address</td><td><a href='editCompanyInfo.php?mtd=address'>Edit</a></td></tr>";
		echo "<tr><td><em>City</em></td><td>$city</td><td><a href='editCompanyInfo.php?mtd=city'>Edit</a></td></tr>";
		echo "<tr><td><em>State</em></td><td>$state</td><td><a href='editCompanyInfo.php?mtd=state'>Edit</a></td></tr>";
		echo "<tr><td><em>Zip Code</em></td><td>$zip</td><td><a href='editCompanyInfo.php?mtd=zip'>Edit</a></td></tr> </table>";
		
		//create distributor-company relation table
		//"Distributor" table
		$sql = "SELECT * FROM dst_cmp WHERE cmp_id='$detailedCompany'";

		if($result = $worker->query($sql)) {
		
			$dst_cmp = "<table>" .
			"<tr><th>Distributors</th></tr>";
			
			while ($row = mysqli_fetch_assoc($result)) {
				
				extract($row);
				
				$company = $worker->findCompany($dst_id, "name");
				
				$dst_cmp .= "<tr><td>$company</td>" .
				"<td><a href='companyDetail.php?del=$dst_id&cid=$detailedCompany'>Remove</a></td></tr>";
				
			}
			
			$dst_cmp .= "</table>";
			
			echo "<br />";
			echo "<p>$dst_cmp</p>";
			
		}
		
	
		//this form is for adding new companies to the users profile
		$companiesSelector = $worker->createSelector("company", "name", "cmp_id");
		
		$companiesForm = "<form action='companyDetail.php?cid=$cmp_id' method='post'>" .
		"Add Distributor: $companiesSelector <br/>" .
		"<input type='submit' value='Commit Changes' />  </form>";
		
		echo "<p>$companiesForm</p>";
			
		echo "</div>";	
	} else {
			echo "Database connection error.";
	}
		

?>

</table>

<?php
	echo "<p><a href='companies.php'>Back to companies list</a></p>";
	$htmlUtils->makeFooter();
	$worker->closeConnection();
?>

