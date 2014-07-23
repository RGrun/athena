<?php
	//deleteDoctor.php
	
	require_once "includes.php";
	
	$worker = new dbWorker();
	
	$doctorToDelete = $_GET['did'];
	
	$sql = "DELETE FROM doctors WHERE doc_id='$doctorToDelete'";
	
	$worker->query($sql);
	$worker->closeConnection();
	
	header( "Location: doctors.php" );
	die();
?>