<?php

	//addNewProcedure.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	$isAdmin = $_SESSION['isAdmin'];
	if(!$isAdmin) header("Location: /athena/www/landing.php");
	
	if(isset($_POST['newName'])) {
	
		extract($_POST);
		
		$sql = "INSERT INTO procs (name)" .
		"VALUES ('$newName')";
		
		$worker->query($sql);
		$worker->closeConnection();
		
		header( "Location: procedures.php" );
		die();
	}
	
	
	echo "<h2>Input new procedure data:</h2>";
	
	$form = "<form action='addNewProcedure.php' method='post'>" .
	"New Procedure&#39;s Name: <input type='text' name='newName' /> <br/>" . 
	"<input type='submit' value='Commit Changes' /> </form>";
	
	echo "<p>$form</p>";
	$worker->closeConnection();
	$htmlUtils->makeFooter();
?>