<?php

	//detail.php
	
	include_once("htmlUtils.php");
	include_once("dbConnector.php");
	
	//establish db connection
	$database = new dbConnector();
	$connection = $database->doConnect();
	
	$htmlUtils = new htmlUtils();
	$htmlUtils->makeHeader();
	
	$detailedCompany = $_GET['cid'];

	
?>



<table>
<?php 
	
	$sql = "SELECT * FROM company WHERE cmp_id=$detailedCompany";
	
	if($result = mysqli_query($connection, $sql)) {
		
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
		echo "<tr><td><em>Zip Code</em></td><td>$zip</td><td><a href='editCompanyInfo.php?mtd=zip'>Edit</a></td></tr>";
	}
?>

</table>

<?php
	$htmlUtils->makeFooter();
	mysqli_close($connection);
?>

