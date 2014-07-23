<?php
	
	//editDoctorInfo.php
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	if(isset($_GET['mtd'])){
		$selectedMethod = $_GET['mtd'];
		$_SESSION['selectedMethod'] = $selectedMethod;
	} else {
		$selectedMethod = $_SESSION['selectedMethod'];
	}
	$currentDoctor = $_SESSION['currentDoctorId'];
	
	echo "<h2>Edit Doctor Info: </h2>";
	
	if(isset($_POST['changeActivity'])) {
		$worker->editDoctorDatabase('active', $currentDoctor);
		$worker->closeConnection();
	} else if(isset($_POST['newData'])) {
		$worker->editDoctorDatabase($selectedMethod, $currentDoctor, $_POST['newData']);
		$worker->closeConnection();
	} else {
		$activityForm = "<form method='post' action='editDoctorInfo.php'>" .
			"<input type='hidden' name='changeActivity' />" .
			"<input type='submit' value='Change Activity' /> </form> <br />";
			
		$form = "<form method='post' action='editDoctorInfo.php'>" .
		"<textarea name='newData' cols='20' rows='5'>Enter New Data Here</textarea><br />" .
		"<input type='submit' value='Commit Changes' /></form> <br/>";
		
		$sql = "SELECT $selectedMethod FROM doctors WHERE doc_id='$currentDoctor'";
		
		if($result = $worker->query($sql)) {
			
			$row = mysqli_fetch_array($result);
			
			$currentData = $row[0];
			
			echo "Current Value: <br />";
			
			if($selectedMethod == "active" && $currentData == 1) {
				echo "Doctor is active. <br />";
				echo $activityForm;
			} else if($selectedMethod == "active" && $currentData == 0) {
				echo "Doctor is inactive. <br />";
				echo $activityForm;
			} else {
				echo "<p>$currentData</p>";
				echo $form;
			}
			
		}
		
		$htmlUtils->makeFooter();
		$worker->closeConnection();
	}
?>