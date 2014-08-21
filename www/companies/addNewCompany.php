<?php
	//addNewCompany.php
	
	require_once "includes.php";
	
	//establish connection to db
	$database = new dbConnector();
	$connection = $database->doConnect();
	
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	if(isset($_POST['isActive'])) {
	
		extract($_POST);
	
		$sql = "INSERT INTO company (active, name, address, city, state, zip)" .
		"VALUES ('$isActive', '$newName', '$newAddress', '$newCity', '$newState', '$newZip')";
		
		mysqli_query($connection, $sql);
		mysqli_close($connection);
		
		header( "Location: companies.php" );
		die();
	}

	
	$form = "<form action='addNewCompany.php' method='post'>" .
	"<table>" .
	"<tr><td>New Company&#39;s Name: </td><td><input type='text' name='newName' /> </td></tr>" .
	"<tr><td>New Company&#39;s Address:</td><td> <input type='text' name='newAddress' /> </td></tr>" .
	"<tr><td>New Company&#39;s City: </td><td><input type='text' name='newCity' /> </td></tr>" .
	"<tr><td>New Company&#39;s State: </td><td><input type='text' name='newState' maxLength='2' /> </td></tr>" .
	"<tr><td>New Company&#39;s Zip Code: </td><td><input type='text' name='newZip' maxLength='5' /> </td></tr>" .
	"<tr><td>Is this company currently active? </td>" .
	"<td>Yes <input type='radio' name='isActive' value='1' checked='checked' />" .
	"No <input type='radio' name='isActive' value='0' /> </td></tr>" .
	"</table>" .
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo $form;
	mysqli_close($connection);
	$htmlUtils->makeFooter();
?>