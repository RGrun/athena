<?php

	//Companies.html
	
	require_once "includes.php";
	
	//establish connection to db
	$database = new dbConnector();
	$connection = $database->doConnect();
	
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
   
	
	echo" <h2>Companies</h2>";

	echo "<em><a href='addNewCompany.php'>Add New Company</a></em><br/><br/>";

	echo "<table>" .
			"<tr>" .
			"	<th>Company ID</th>" .
			"	<th>Active?</th>" .
			"	<th>Name</th>" .
			"	<th>Address</th> ".
			"	<th>City</th>" .
			"	<th>State</th>" .
			"	<th>Zip Code</th>" .
			"</tr>";


	$sql = "SELECT * FROM company";
	
	if($result = mysqli_query($connection, $sql)) {
		
		//get associative array and print table data
		while($row = mysqli_fetch_assoc($result)) {
		
			extract($row);
		
			echo "<tr><td>$cmp_id</td>";
			
			if($active == 1) {
				echo "<td>Yes</td>";
			} else {
				echo "<td>No</td>";
			}
			
			echo "<td>$name</td>" .
			"<td>$address</td>" .
			"<td>$city</td>" .
			"<td>$state</td>" .
			"<td>$zip</td>" .
			"<td><a href='companyDetail.php?cid=$cmp_id'>Detail</a></td>" .
			"<td><a href='deleteCompany.php?cid=$cmp_id'>Delete</a></td></tr>";
		}
		
		echo "</table>";
	} else {
		echo "Connection to database failed.";
	}

	$htmlUtils->makeFooter();
	mysqli_close($connection);
?>
		
