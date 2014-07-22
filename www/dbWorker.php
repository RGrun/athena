<?php

	require_once("dbConnector.php");

	class dbWorker extends dbConnector {
		
		//inherets db connection info and doConnect() method from dbConnector
		
		private $connection;
		
		public function __construct() {
		
			//establish connection to database
			$this->connection = $this->doConnect();
		}
		
		public function setTableName($newName) {
			$this->tableName = $newName;
		}
		
		public function query($sql) {

			$result = mysqli_query($this->connection, $sql);
			
			return $result;
		}
		
		public function editCompanyDatabase($column, $id, $newData = null) {
		
			if($column == "active") {
				if($result = $this->query($sql)) {
					$row = mysqli_fetch_assoc($result);
					if($row['active'] == 1) {
						$sql = "UPDATE company SET active='0' WHERE cmp_id='$cid'";
						
						$this->query($sql);
					} else {
						$sql = "UPDATE company SET active='1' WHERE cmp_id='$cid'";
						
						$this->query($sql);
					}
				}
			} else {
			
				$sql = "UPDATE company SET $column='$newData' WHERE cmp_id='$id'";
				
				$this->query($sql);
			}
		}