<?php
	//addNewCompany.php
	
	include_once("htmlUtils.php");
	include_once("dbConnector.php");
	
	//establish connection to db
	$database = new dbConnector();
	$connection = $database->doConnect();
	
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	if(isset($_POST['newName'])) {
	
		extract($_POST);
	
		$sql = "INSERT INTO company (active, name, address, city, state, zip)" .
		"VALUES ('$isActive', '$newName', '$newAddress', '$newCity', '$newState', '$newZip')";
		
		mysqli_query($connection, $sql);
		mysqli_close($connection);
		
		header( "Location: companies.php" );
		die();
	}

	
	$form = "<form action='addNewCompany.php' method='post'>" .
	"New Company&#39;s Name: <input type='text' name='newName' /> <br/>" .
	"New Company&#39;s Address: <input type='text' name='newAddress' /> <br/>" .
	"New Company&#39;s City: <input type='text' name='newCity' /> <br />" .
	"New Company&#39;s State: <input type='text' name='newState' /> <br />" .
	"New Company&#39;s Zip Code: <input type='text' name='newZip' /> <br />" .
	"Is this company currently active? <br />" .
	"Yes <input type='radio' name='isActive' value='1' checked='checked' /> <br />" .
	"No <input type='radio' name='isActive' value='0' /> <br />" .
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo $form;
	mysqli_close($connection);
	$htmlUtils->makeFooter();
?>