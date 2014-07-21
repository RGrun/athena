<?php

	//companyUpdater.php
	
	include_once("dbConnector.php");
	
	class companyUpdater {
		
		private $database;
		private $connection;
		
		public function __construct() {
			$this->database = new dbConnector();
			$this->connection = $this->database->doConnect();
		}
		
		public function update($method, $cid, $newData) {
		
			switch($method) {
				case "activity":
					$this->changeCompanyActivity($cid);
					break;
				case "name":
					$this->changeCompanyName($cid, $newData);
					break;
				case "address":
					$this->changeCompanyAddress($cid, $newData);
					break;
				case "city":
					$this->changeCompanyCity($cid, $newData);
					break;
				case "state":
					$this->changeCompanyState($cid, $newData);
					break;
				case "zip":
					$this->changeCompanyZip($cid, $newData);
					break;
			}
		}
		
		public function query($sql) {

			$result = mysqli_query($this->connection, $sql);
			
			return $result;
		}
		
		private function changeCompanyActivity($cid) {
			$sql = "SELECT active FROM company WHERE cmp_id=$cid";
			
			if($result = mysqli_query($this->connection, $sql)) {
				$row = mysqli_fetch_assoc($result);
				if($row['active'] == 1) {
					$sql = "UPDATE company SET active='0' WHERE cmp_id='$cid'";
					
					mysqli_query($this->connection, $sql);
				} else {
					$sql = "UPDATE company SET active='1' WHERE cmp_id='$cid'";
					
					mysqli_query($this->connection, $sql);
				}
				
				echo "Company activity updated.";
			} else {
				echo "Activity update failed.";
			}
		}
		
		private function changeCompanyName($cid, $newData) {
			$sql = "UPDATE company SET name='$newData' WHERE cmp_id='$cid'";
			
			if(mysqli_query($this->connection, $sql)) {
				echo "Company name updated.";
			} else {
				echo "Company name change failed.";
			}
		}
		
		private function changeCompanyAddress($cid, $newData) {
			$sql = "UPDATE company SET address='$newData' WHERE cmp_id='$cid'";
			
			if(mysqli_query($this->connection, $sql)) {
				echo "Company Address updated.";
			} else {
				echo "Company name update failed.";
			}
		}
		
		private function changeCompanyCity($cid, $newData) {
			$sql = "UPDATE company SET city='$newData' WHERE cmp_id='$cid'";
			
			if(mysqli_query($this->connection, $sql)) {
				echo "Company city changed";
			} else {
				echo "Company city update failed";
			}
		}
		
		private function changeCompanyState($cid, $newData) {
			$sql = "UPDATE company SET state='$newData' WHERE cmp_id='$cid'";
			
			if(mysqli_query($this->connection, $sql)) {
				echo "Company state changed.";
			} else {
				echo "Company state change failed.";
			}
		}
		
		private function changeCompanyZip($cid, $newData) {
			$sql = "UPDATE company SET zip='$newData' WHERE cmp_id='$cid'";
			
			if(mysqli_query($this->connection, $sql)) {
				echo "Company zip changed.";
			} else {
				echo "Company zip change failed.";
			}
		}
		
		public function closeConnection() {
			mysqli_close($this->connection);
		}
	}
?>