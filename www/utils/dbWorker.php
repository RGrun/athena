<?php

	require_once("dbConnector.php");

	class dbWorker extends dbConnector {
		
		//inherets db connection info and doConnect() method from dbConnector
		
		private $connection;
		
		//these constants are for notifications
		  public $_LOAN_REQUEST = 1;
		  public $_LOAN_REPLY = 2;
		  public $_TRAY_PICKED_UP = 3;
		  public $_CASE_REMINDER = 4;
		  public $_TRAY_RELINQUISHED = 5;
		  public $_TRAY_UNASSIGNED = 6;
		  public $_NEW_CASE_CREATED = 7;
		  public $_TRAY_LATE = 8;
		  
		  public $_REQUEST = 1;
		  public $_TRAY = 2;
		  public $_CASE = 3;
		
		//private static $TIMEZONE = 'America/Los_Angeles'; //does not work in php for some stupid reason
		
		public function __construct() {
		
			//establish connection to database
			$this->connection = $this->doConnect();
		}
		
		public function closeConnection() {
			mysqli_close($this->connection);
		}
		
		//query wrapper
		public function query($sql) {

			return mysqli_query($this->connection, $sql);
		}
		
		//Database editing functions
		
		public function editCompanyDatabase($column, $id, $newData = null) {
			//get old data so we can log it
			$sql = "SELECT * FROM company WHERE cmp_id='$id'";
			$result = $this->query($sql);
			$old = mysqli_fetch_assoc($result);
		
			$oldData = $old["$column"];
		
			if($old["$column"] == $newData) header( "Location: companyDetail.php?cid=$id" );
				
			$userId = $_SESSION['userId'];
		
			if($column == "active") {
				$sql = "SELECT active FROM company WHERE cmp_id='$id'";
				if($result = $this->query($sql)) {
					$row = mysqli_fetch_assoc($result);
					if($row['active'] == 1) {
						$sql = "UPDATE company SET active='0' WHERE cmp_id='$id'";
						$oldData = "Active";
						$new = "Inactive";
						$this->logSevent($userId, "change.company", $column, $oldData, $new); 
						if($this->query($sql)) header( "Location: companyDetail.php?cid=$id" );
					} else {
						$sql = "UPDATE company SET active='1' WHERE cmp_id='$id'";
						$oldData = "Inactive";
						$new = "Active";
						$this->logSevent($userId, "change.company", $column, $oldData, $new); 
						if($this->query($sql)) header( "Location: companyDetail.php?cid=$id" );
					}
					
				}
			} else {
			
				$sql = "UPDATE company SET $column='$newData' WHERE cmp_id='$id'";
				$this->logSevent($userId, "change.company", $column, $oldData, $newData); 

				if($this->query($sql)) header( "Location: companyDetail.php?cid=$id" );
				
			}
		}
		
		public function editUserDatabase($column, $id, $newData = null, $settings = false) {
		
			//get old data so we can log it
			$sql = "SELECT * FROM users WHERE usr_id='$id'";
			$result = $this->query($sql);
			$old = mysqli_fetch_assoc($result);
			
			//log it
				if($column == "team_id") {
					$oldData = $this->findTeam($old["$column"], "name");
					$new = $this->findTeam($newData, "name");
				} else {
					$oldData = $old["$column"];
				}
				
			if($old["$column"] == $newData) header( "Location: userDetail.php?uid=$id" );
				
			$userId = $_SESSION['userId'];
				
			if($column == "active") {
				$sql = "SELECT active FROM users WHERE usr_id='$id'";
				if($result = $this->query($sql)) {
					$row = mysqli_fetch_assoc($result);
					if($row['active'] == 1) {
						$sql = "UPDATE users SET active='0' WHERE usr_id='$id'";
						$oldData = "Active";
						$new = "Inactive";
						$this->logSevent($userId, "change.users", $column, $oldData, $new); 
						if($this->query($sql)) header( "Location: userDetail.php?uid=$id" );
					} else {
						$sql = "UPDATE users SET active='1' WHERE usr_id='$id'";
						$oldData = "Inactive";
						$new = "Active";
						$this->logSevent($userId, "change.users", $column, $oldData, $new); 
						if($this->query($sql)) header( "Location: userDetail.php?uid=$id" );
					}
					
				}
			} else {
			
				$sql = "UPDATE users SET $column='$newData' WHERE usr_id='$id'";
				$this->logSevent($userId, "change.users", $column, $oldData, $newData); 
				$this->query($sql);
				if($settings) header("Location: settings.php");
				else header( "Location: userDetail.php?uid=$id" );
				
			}
		}
		
		public function editStorageDatabase($column, $id, $newData = null) {
			//get old data so we can log it
			$sql = "SELECT * FROM storage WHERE site_id='$id'";
			$result = $this->query($sql);
			$old = mysqli_fetch_assoc($result);
			
			//log it
				if($column == "cmp_id") {
					$oldData = $this->findCompany($old["$column"], "name");
					$new = $this->findCompany($newData, "name");
				} else {
					$oldData = $old["$column"];
				}
			
			if($old["$column"] == $newData) header( "Location: storageDetail.php?sid=$id" );
				
			$userId = $_SESSION['userId'];
			
			if($column == "active") {
				$sql = "SELECT active FROM storage WHERE stor_id='$id'";
				if($result = $this->query($sql)) {
					$row = mysqli_fetch_assoc($result);
					if($row['active'] == 1) {
						$sql = "UPDATE storage SET active='0' WHERE stor_id='$id'";
						$oldData = "Active";
						$new = "Inactive";
						$this->logSevent($userId, "change.storage", $column, $oldData, $new); 
						if($this->query($sql)) header( "Location: storageDetail.php?sid=$id" );
					} else {
						$sql = "UPDATE storage SET active='1' WHERE stor_id='$id'";
						$oldData = "Inactive";
						$new = "Active";
						$this->logSevent($userId, "change.storage", $column, $oldData, $new); 
						if($this->query($sql)) header( "Location: storageDetail.php?sid=$id" );
					}
					
				}
			} else {
			
				$sql = "UPDATE storage SET $column='$newData' WHERE stor_id='$id'";
				$this->logSevent($userId, "change.storage", $column, $oldData, $newData); 
				if($this->query($sql)) header( "Location: storageDetail.php?sid=$id" );
				
			}
		}
		
		public function editSiteDatabase($column, $id, $newData = null) {
			//get old data so we can log it
			$sql = "SELECT * FROM sites WHERE site_id='$id'";
			$result = $this->query($sql);
			$old = mysqli_fetch_assoc($result);
			
			$oldData = $old["$column"];
		
			if($old["$column"] == $newData) header( "Location: siteDetail.php?sid=$id" );
				
			$userId = $_SESSION['userId'];
		
			if($column == "active") {
				$sql = "SELECT active FROM sites WHERE site_id='$id'";
				if($result = $this->query($sql)) {
					$row = mysqli_fetch_assoc($result);
					if($row['active'] == 1) {
						$sql = "UPDATE sites SET active='0' WHERE site_id='$id'";
						$oldData = "Active";
						$new = "Inactive";
						$this->logSevent($userId, "change.sites", $column, $oldData, $new); 
						if($this->query($sql)) header( "Location: siteDetail.php?sid=$id" );
					} else {
						$sql = "UPDATE sites SET active='1' WHERE site_id='$id'";
						$oldData = "Inactive";
						$new = "Active";
						$this->logSevent($userId, "change.sites", $column, $oldData, $new); 
						
						if($this->query($sql)) header( "Location: siteDetail.php?sid=$id" );
					}
					
				}
			} else {
			
				$sql = "UPDATE sites SET $column='$newData' WHERE site_id='$id'";
				$this->logSevent($userId, "change.sites", $column, $oldData, $newData); 

				if($this->query($sql)) header( "Location: siteDetail.php?sid=$id" );
				
			}
		}
		
		public function editClientDatabase($column, $id, $newData = null, $settings = false) {
		//get old data so we can log it
			$sql = "SELECT * FROM clients WHERE cli_id='$id'";
			$result = $this->query($sql);
			$old = mysqli_fetch_assoc($result);
		
			$oldData = $old["$column"];
		
			if($old["$column"] == $newData) header( "Location: clientDetail.php?cid=$id" );
				
			$userId = $_SESSION['userId'];
		
		
			if($column == "active") {
				$sql = "SELECT active FROM clients WHERE cli_id='$id'";
				if($result = $this->query($sql)) {
					$row = mysqli_fetch_assoc($result);
					if($row['active'] == 1) {
						$sql = "UPDATE clients SET active='0' WHERE cli_id='$id'";
						$oldData = "Active";
						$new = "Inactive";
						$this->logSevent($userId, "change.clients", $column, $oldData, $new); 
						if($this->query($sql)) header( "Location: clientDetail.php?cid=$id" );
					} else {
						$sql = "UPDATE clients SET active='1' WHERE cli_id='$id'";
						$oldData = "Inactive";
						$new = "Active";
						$this->logSevent($userId, "change.clients", $column, $oldData, $new); 
						if($this->query($sql)) header( "Location: clientDetail.php?cid=$id" );
					}
				}
			} else {
			
				$sql = "UPDATE clients SET $column='$newData' WHERE cli_id='$id'";
				$this->query($sql);
				$this->logSevent($userId, "change.clients", $column, $oldData, $newData); 

				if($settings) header("Location: settings.php");
				else header( "Location: clientDetail.php?cid=$id" );
				
			}
		}
		
		public function editDoctorDatabase($column, $id, $newData = null) {
			//get old data so we can log it
			$sql = "SELECT * FROM doctors WHERE doc_id='$id'";
			$result = $this->query($sql);
			$old = mysqli_fetch_assoc($result);
		
			$oldData = $old["$column"];
		
			
			if($old["$column"] == $newData) header( "Location: doctorDetail.php?did=$id" );
				
			$userId = $_SESSION['userId'];
				
		
			if($column == "active") {
				$sql = "SELECT active FROM doctors WHERE doc_id='$id'";
				if($result = $this->query($sql)) {
					$row = mysqli_fetch_assoc($result);
					if($row['active'] == 1) {
						$sql = "UPDATE doctors SET active='0' WHERE doc_id='$id'";
						$oldData = "Active";
						$new = "Inactive";
						$this->logSevent($userId, "change.doctors", $column, $oldData, $new); 
						if($this->query($sql)) header( "Location: doctorDetail.php?did=$id" );
					} else {
						$sql = "UPDATE doctors SET active='1' WHERE doc_id='$id'";
						$oldData = "Inactive";
						$new = "Active";
						$this->logSevent($userId, "change.doctors", $column, $oldData, $new); 
						if($this->query($sql)) header( "Location: doctorDetail.php?did=$id" );
					}
					
				}
			} else {
			
				$sql = "UPDATE doctors SET $column='$newData' WHERE doc_id='$id'";
				$this->logSevent($userId, "change.doctors", $column, $oldData, $newData); 
				if($this->query($sql)) header( "Location: doctorDetail.php?did=$id" );
				
			}
		}
		
		public function editTeamDatabase($column, $id, $newData = null) {	
				//get old data so we can log it
				$sql = "SELECT * FROM teams WHERE team_id='$id'";
				$result = $this->query($sql);
				$old = mysqli_fetch_assoc($result);
				
				$sql = "UPDATE teams SET $column='$newData' WHERE team_id='$id'";
				echo $sql;
				$this->query($sql);
		
				//log it
				if($column == "cmp_id") {
					$oldData = $this->findCompany($old["$column"], "name");
					$new = $this->findCompany($newData, "name");
				} else if ($column == "head_id") {
					$oldData = $this->findUser($old["$column"], "uname");
					$new = $this->findUser($newData, "uname");
				} else {
					$oldData = $old["$column"];
					$new = $newData;
				}
				
				if($old["$column"] == $newData) header( "Location: teamDetail.php?tid=$id" );
				
				$userId = $_SESSION['userId'];
				
				$this->logSevent($userId, "change.teams", $column, $oldData, $new); 
				
				
				header( "Location: teamDetail.php?tid=$id" );
		}
		
		public function editInstrumentDatabase($column, $id, $newData = null) {
				//get old data so we can log it
				$sql = "SELECT * FROM instruments WHERE inst_id='$id'";
				$result = $this->query($sql);
				$old = mysqli_fetch_assoc($result);
				
				if($old["$column"] == $newData) header( "Location: instrumentDetail.php?iid=$id" );
				
				$userId = $_SESSION['userId'];
				
				$oldData = $old["$column"];
				
				$this->logSevent($userId, "change.tray", $column, $oldData, $newData); 
				
		
				$sql = "UPDATE instruments SET $column='$newData' WHERE inst_id='$id'";
				//echo $sql;
				$this->query($sql); 
				header( "Location: instrumentDetail.php?iid=$id" );
		}
		
		public function editProcedureDatabase($column, $id, $newData = null) {
			//get old data so we can log it
				$sql = "SELECT * FROM procs WHERE proc_id='$id'";
				$result = $this->query($sql);
				$old = mysqli_fetch_assoc($result);
				
				if($old["$column"] == $newData) header( "Location: procedureDetail.php?pid=$id" );
				
				$userId = $_SESSION['userId'];
				
				$oldData = $old["$column"];
				
				$this->logSevent($userId, "change.procedure", $column, $oldData, $newData); 
				
		
				$sql = "UPDATE procs SET $column='$newData' WHERE proc_id='$id'";
				//echo $sql;
				$this->query($sql); 
				header( "Location: procedureDetail.php?pid=$id" );
		
		
		
		}
		
		public function editTrayDatabase($column, $id, $newData = null) {
				//get old data so we can log it
				$sql = "SELECT * FROM trays WHERE tray_id='$id'";
				$result = $this->query($sql);
				$old = mysqli_fetch_assoc($result);
				
				$sql = "UPDATE trays SET $column='$newData' WHERE tray_id='$id'";
				echo $sql;
				$this->query($sql);
				
				
				//log it
				if($column == "cmp_id") {
					$oldData = $this->findCompany($old["$column"], "name");
					$new = $this->findCompany($newData, "name");
				} else if ($column == "team_id" || $column == "loan_team") {
					$oldData = $this->findTeam($old["$column"], "name");
					$new = $this->findTeam($newData, "name");
				} else if ($column == "stor_id") {
					$oldData = $this->findStorage($old["$column"], "uname");
					$new = $this->findStorage($newData, "uname");
				} else if($column == "site_id") {
					$oldData = $this->findSite($old["$column"], "name");
					$new = $this->findSite($newData, "name");
				} else {
					$oldData = $old["$column"];
					$new = $newData;
				}
				
				if($old["$column"] == $newData) header( "Location: trayDetail.php?tid=$id" );
				
				$userId = $_SESSION['userId'];
				
				$this->logSevent($userId, "change.tray", $column, $oldData, $new); 
				
		
				
				header( "Location: trayDetail.php?tid=$id" );
		}
		
		public function editRegionDatabase($column, $id, $newData = null) {
				//get old data so we can log it
				$sql = "SELECT * FROM regions WHERE reg_id='$id'";
				$result = $this->query($sql);
				$old = mysqli_fetch_assoc($result);
		
		
				//log it
				$oldData = $old["$column"];
		
				if($old["$column"] == $newData)  header( "Location: regionDetail.php?rid=$id" );
				
				$userId = $_SESSION['userId'];
				
				$this->logSevent($userId, "change.region", $column, $oldData, $newData); 
				
		
				$sql = "UPDATE regions SET $column='$newData' WHERE reg_id='$id'";
				//echo $sql;
				if($this->query($sql)) header( "Location: regionDetail.php?rid=$id" );
		}
		
		public function editAssignmentDatabase($column, $id, $newData = null, $link = true) {
				//get old data so we can log it
				$sql = "SELECT * FROM assigns WHERE asgn_id='$id'";
				$result = $this->query($sql);
				$old = mysqli_fetch_assoc($result);
				
				//log it
				if($column == "tray_id") {
					$oldData = $this->findTray($old["$column"], "name");
					$new = $this->findTray($newData, "name");
				} else if ($column == "cli_id") {
					$oldData = $this->findClient($old["$column"], "name");
					$new = $this->findClient($newData, "name");
				} else if ($column == "do_usr" || $column == "pu_usr") {
					$oldData = $this->findUser($old["$column"], "uname");
					$new = $this->findUser($newData, "uname");
				} else {
					$oldData = $old["$column"];
					$new = $newData;
				}

				if($old["$column"] == $newData) header("Location: assignmentDetail.php?aid=$id");
				
				$userId = $_SESSION['userId'];
				
				$this->logSevent($userId, "change.assignment", $column, $oldData, $new); 
				
				//make actual DB change
				$sql = "UPDATE assigns SET $column='$newData' WHERE asgn_id='$id'";
				echo $sql;
				if($this->query($sql) && $link == true) header( "Location: assignmentDetail.php?aid=$id" );
				$this->query($sql);
		}
		
		public function editCaseDatabase($column, $id, $newData = null) {
				//get old data so we can log it
				$sql = "SELECT * FROM cases WHERE case_id='$id'";
				$result = $this->query($sql);
				$old = mysqli_fetch_assoc($result);
		
				$sql = "UPDATE cases SET $column='$newData' WHERE case_id='$id'";
				//echo $sql;
				$this->query($sql);
				
				//log it
				if($column == "team_id") {
					$oldData = $this->findTeam($old["$column"], "name");
					$new = $this->findTeam($newData, "name");
				} else if ($column == "doc_id") {
					$oldData = $this->findDoctor($old["$column"], "name");
					$new = $this->findDoctor($newData, "name");
				} else if ($column == "proc_id") {
					$oldData = $this->findProcedure($old["$column"], "name");
					$new = $this->findProcedure($newData, "name");
				} else if ($column == "site_id") {
					$oldData = $this->findSite($old["$column"], "name");
					$new = $this->findSite($newData, "name");
				} else {
					$oldData = $old["$column"];
					$new = $newData;
				}

				if($old["$column"] == $newData) header( "Location: caseDetail.php?cid=$id" );
				
				$userId = $_SESSION['userId'];
				$this->logSevent($userId, "change.case", $column, $oldData, $new); 

				header( "Location: caseDetail.php?cid=$id" );
				
				
		}
				
		public function editTrayContents($column, $iid, $newData = null, $tid, $method, $link = true) {
		
				//get old data so we can log it
				$sql = "SELECT * FROM traycont WHERE inst_id='$iid' AND tray_id='$tid'";
				$result = $this->query($sql);
				$old = mysqli_fetch_assoc($result);
		
				$sql = "UPDATE traycont SET $column='$newData' WHERE inst_id='$iid' AND tray_id='$tid'";
				//echo $sql;
				$this->query($sql);
				
				$userId = $_SESSION['userId'];
				$item = $this->findInstrument($iid, "name");
				
				if($old["$column"] == $newData) return null;

				$this->logSevent($userId, "change.trayContents", $item, $old["$column"], $newData); 
				

				if($link == true) header( "Location: /athena/www/trays/editTrayContents.php?iid=$iid&mtd=$method" );
		}
		
		public function logSevent($userId, $name, $item, $from, $to) {
		
			$time = time();
			$time = date("Y-m-d H:i:s", $time);
		
			$sql = "INSERT INTO sevents (u_id, name, item, was, now, dttm) VALUES ('$userId', '$name', '$item', '$from', '$to', '$time')";
			
			//echo $sql;
			
			$this->query($sql);
		
		
		}
				
		//creative functions
		
		public function createSelector($requestTable, $field, $nameOfId, $pending = false, $alt = false, $storage = false, $noPending = false) {
		
			$salt = "";
			if($alt == true) $salt = "2";
		
			$sql = "SELECT $field, $nameOfId FROM $requestTable";

			$result = $this->query($sql);
			
			$selector = "<select name='new$requestTable" . $salt . "' size='1'>";
			
			if($pending == true) $selector .= "<option value='0'>Pending</option>";
			if($requestTable == "teams" && $noPending != true) $selector .= "<option value='0'>None</option>";
			
			if($storage != false) {
			
				$sql2 = "SELECT stor_id, name FROM storage";
				$result2 = $this->query($sql2);
				while ($row2 = mysqli_fetch_array($result2)) {
					//$stor = $this->findStorage($row[0], "name");
					$selector .= "<option value='stor$row2[0]'>$row2[1]</option>";
				}
			}
			
			while($row = mysqli_fetch_array($result)) {
				$selector .= "<option value='$row[1]'>$row[0]</option>";
			}
			
	
			$selector .= "</select>";
			
			return $selector;
		}
		/* REVISION 8/8/14: 
		* This function returns a dropdown of trays assigned to the users team 
		* or loaned to the users team 
		*/
		
		public function createLandingDropdown($userId, $method) {
		
			$usersTeam = $this->findUser($userId, "team_id");
			
			$selector = "<select id='filterselect' size='1' onchange='trayFilter()'>" . 
			"<option value='all'>All</option>" .
			"<option disabled>--Trays--</option>";
			
			$sqlPart = "";
			if($method == "dropoff") $sqlPart = "(atnow='usr' OR atnow='unk')";
			elseif($method == "pickup") $sqlPart = "(atnow='stor' OR atnow='site' OR atnow='unk')";
			
			$sql = "SELECT tray_id, name FROM trays WHERE (team_id='$usersTeam' OR loan_team='$usersTeam') AND $sqlPart";
			
			$result = $this->query($sql);
			while ($row = mysqli_fetch_array($result)) {
				$selector .= "<option value='$row[0]'>$row[1]</option>";
			}
			$selector .= "</select>";
			return $selector;
		}
		
		public function makeAssignmentDropdown($trayId, $userId) {
		
			$usersTeam = $this->findUser($userId, "team_id");
			
			$selector = "<select id='assignment' size='1' onchange='assignmentFilter()'>" . 
			"<option>--Select Assignment--</option>" .
			"<option disabled>-------------</option>";
			
			//display assignments related to the current tray
			$sql = "SELECT asgn_id FROM assigns WHERE tray_id='$trayId' AND (status='Pending' OR status='Overdue')";
			
			$result = $this->query($sql);
			
			while($row = mysqli_fetch_array($result)) {
			
				$selector .= "<option value='assignment$row[0]'>Assignment #$row[0]</option>";
			}

			$selector .= "</select>";
			
			return $selector;
			
		}
		
		//USED IN NEWEST REV (8/8/14)
		public function makeDropoffSitesTrayTables($row, $teamId, $userId) {
			
			$team = $this->findTeam($teamId, "name");
			
			extract($row);
			
			$company = $this->findCompany($cmp_id, "name");
			$team = $this->findTeam($team_id, "name");
			if ($site_id == 0) $site = 0;
			else $site = $this->findSite($site_id, "name");
			$loanTeam = $this->findTeam($loan_team, "name");
			$storage = $this->findStorage($stor_id, "name");
			$user = $this->findUser($userId, "uname");
			
			//with user or unknown trays only
			if($atnow == "site" || $atnow == "stor") return null;
			//$atnow == "usr" || $atnow == "unk"
		
			if($loanTeam == null) $loanTeam = "None";
		
			if($atnow == "usr") $status = "With $user";
			if($atnow == "site") $status = "At site";
			if($atnow == "stor") $status = "In storage";
			if($atnow == "unk") $status = "Unknown";
			
			$trayNameClass = "$name" . "_class";
			
			$fromAnotherTeam = "";
			$method = "dropoff";

			if($loan_team == 0) $loan = "<a href='loanTray.php?tid=$tray_id&mtd=$method&action=loan'> Loan tray to another team</a>";
			elseif($loan_team != 0 && $loan_team == $teamId) {
				$loan = "<a href='loanTray.php?tid=$tray_id&mtd=$method&action=return'>Return borrowed tray</a>";
				$fromAnotherTeam = "<tr><td><span class='loan'>Borrowed from another team</span></td></tr>";
			}
			elseif($team_id == $teamId && $loan_team != 0) $loan = "<span class='loan'>Loaned</span>";
			
			//figure out time of next pending dropoff event
			$sql = "SELECT do_dttm FROM assigns INNER JOIN trays ON trays.tray_id=assigns.tray_id" .
			" WHERE trays.tray_id='$tray_id' AND assigns.tray_id='$tray_id' AND assigns.status!='Complete' ORDER BY do_dttm DESC";
			
			//echo $sql;
			
			$result = $this->query($sql);
			$row = mysqli_fetch_array($result);
			
			$closestTime = $row[0];
			
			if($closestTime != null) $closestTime = $this->checkTime($closestTime);
			else $closestTime = "None Scheduled, return to storage.";
			
			$forIcon = "site";
			if($site_id == 0 && $stor_id == 0) {  $site = "With $user";  $forIcon = "user";  }
			else if($site_id == 0 && $stor_id != 0) { $forIcon = "storage"; }
			
			
			//generate icon/location
			$icon = $this->makeIcon($forIcon);
			$loc = "<div class='location'>$icon Current Location: $site <br/> Until: $closestTime</div>";
			
			//stuff here always visible
			$newView = "<div id='$trayNameClass' class='trayclass'>";

			if($loan_team == 0 && $loan_team != $teamId) $newView .= "<span class='dropoffButton'><a href='dropoffTray.php?tid=$tray_id'>View Details/Drop off</a></span>";
			$newView .= "<div class='clickable' onclick='expand($tray_id)'>"; //open clickable
			$newView .= "<h2>$name</h2>";
			$newView .= $loc;
			$newView .= "<em class='trayarrow' id='arrow$tray_id'>&#x25bc;</em>";
			$newView .= "</div>"; //close clickable
			
			//this stuff is hidden at first, revealed by click
			$newView .=  "<div id='$trayNameClass" . "_expanded' class='expandedtrayview' style='display: none;'>";
			
			$newView .= $fromAnotherTeam;
			
			$newView .= "<br/><span class='companydata'>Belongs To: $company.$team </span>";
			
			$sql = "SELECT * FROM assigns WHERE tray_id='$tray_id' AND (do_usr='$userId' OR pu_usr='$userId' OR do_usr='0' OR pu_usr='0') AND (status='Pending' OR status='Overdue')";
			
			
			$result = $this->query($sql);
			
			
			$newView .= "<br/><br/><h4 class='assignmentsLabel'>Upcoming assignments:</h4>";
			
			while($row2 = mysqli_fetch_assoc($result)) {
	
				$newView .= $this->makeTrayAssignments($row2, $userId);
				
				
			}
				
			//create traycont table (tray contents)
			$sql3 = "SELECT * FROM traycont WHERE tray_id='$tray_id'";
			
			$newView .= "<h4>Tray contents: </h4>";

			if($result3 = $this->query($sql3)) {
				
				while ($row3 = mysqli_fetch_assoc($result3)) {
					
					extract($row3);
					
					$instrument = $this->findInstrument($inst_id, "name");
					
					$newView .= "<div class='instrumentView'>";
					$newView .= "$quant x $instrument";
					$newView .= "</div>";
				}
				
			}
				
			
			/* $newView .= "<table>" .
			"<tr><td><em>Tray ID: </em></td><td>$tray_id</td></tr>" .
			//"<tr><td><em>Name: </em></td><td>$name</td></tr>" .
			"<tr><td><em>Belongs To:</em></td><td>$company</td></tr>" .
			"<tr><td><em>Responsible Team:</em></td><td>$team</td></tr>" .
			"<tr><td><em>Loaned To: </em></td><td>$loanTeam</td></tr>" .
			"<tr><td><em>Status: </em></td><td>$status</td></tr>" .
			"<tr><td><em>Stored At: </em></td><td>$storage</td></tr>" .
			"<tr><td><a href='dropoffTray.php?tid=$tray_id'>View Details/Drop off</a></td>" .
			"<td>$loan</td></tr>" .
			"</table>"; */
		
			
			$loanButton = "<span class='loanButton'>$loan</span>";
			
			$newView .= "</div>$loanButton</div>";
						
			//return $newView;			
			return "<div class='sitesTray'>$newView</div>";
		}
	
		
		//USED IN NEWEST REV (8/8/14)
		public function makePickupSitesTrayTables($row, $teamId, $userId) {
			
			$team = $this->findTeam($teamId, "name");
			
			extract($row);
			
			$company = $this->findCompany($cmp_id, "name");
			$team = $this->findTeam($team_id, "name");
			if ($site_id == 0) $site = 0;
			else $site = $this->findSite($site_id, "name");
			$loanTeam = $this->findTeam($loan_team, "name");
			$storage = $this->findStorage($stor_id, "name");
			
			if($site_id == 0) $site = $storage;
			
			//in user-held or site-held location trays only
			if($atnow == "usr") return null;
		
			if($loanTeam == null) $loanTeam = "None";
		
			if($atnow == "usr") $status = "With user";
			if($atnow == "site") $status = "At site";
			if($atnow == "stor") $status = "In storage";
			if($atnow == "unk") $status = "Unknown";
			
			$trayNameClass = "$name" . "_class";
			
			$fromAnotherTeam = "";
			$method = "pickup";

			if($loan_team == 0) $loan = "<a href='loanTray.php?tid=$tray_id&mtd=$method&action=loan'> Loan tray to another team</a>";
			elseif($loan_team != 0 && $loan_team == $teamId) {
				$loan = "<a href='loanTray.php?tid=$tray_id&mtd=$method&action=return'>Return borrowed tray</a>";
				$fromAnotherTeam = "<tr><td><span class='loan'>Borrowed from another team</span></td></tr>";
			}
			elseif($team_id == $teamId && $loan_team != 0) $loan = "<span class='loan'>Loaned</span>";
			
			//figure out time of next pending dropoff event
			$sql = "SELECT pu_dttm FROM assigns INNER JOIN trays ON trays.tray_id=assigns.tray_id" .
			" WHERE trays.tray_id='$tray_id' AND assigns.tray_id='$tray_id' ORDER BY pu_dttm DESC";
			
			//echo $sql;
			
			$result = $this->query($sql);
			$row = mysqli_fetch_array($result);
			
			$closestTime = $row[0];
			
			if($closestTime != null) $closestTime = $this->checkTime($closestTime);
			else $closestTime = "None Scheduled";

			$forIcon = "site";
			if($site_id == 0 && $stor_id == 0) {  $site = "With User";  $forIcon = "user";  }
			else if($site_id == 0 && $stor_id != 0) { $forIcon = "storage"; }
				
			//generate icon/location
			$icon = $this->makeIcon($forIcon);
			if($forIcon != "storage") $loc = "<div class='location'>$icon Current Location: $site <br/> Until: $closestTime</div>";
			else $loc = "<div class='location'>$icon Current Location: $site <br/> </div>";
			
			//stuff here always visible
			$newView = "<div id='$trayNameClass' class='trayclass'>";
			
			$newView .= "<span class='dropoffButton'><a href='pickupTray.php?tid=$tray_id'>View Details/Pick Up</a></span>";
			$newView .= "<div class='clickable' onclick='expand($tray_id)'>"; //open clickable
			$newView .= "<h2>$name</h2>";
			$newView .= $loc;
			$newView .= "<em class='trayarrow' id='arrow$tray_id'>&#x25bc;</em>";
			$newView .= "</div>"; //close clickable
			
			//this stuff is hidden at first, revealed by click
			$newView .=  "<div id='$trayNameClass" . "_expanded' class='expandedtrayview' style='display: none;'>";
			
			$newView .= $fromAnotherTeam;
			
			$newView .= "<br/><span class='companydata'>Belongs To: $company.$team </span>";
			
			$sql = "SELECT * FROM assigns WHERE tray_id='$tray_id' AND (do_usr='$userId' OR pu_usr='$userId' OR do_usr='0' OR pu_usr='0') AND  (status='Pending' OR status='Overdue')";
			
			$result = $this->query($sql);
			
			$newView .= "<br/><br/><h4 class='assignmentsLabel'>Upcoming assignments:</h4>";

			while($row = mysqli_fetch_assoc($result)) {
	
				$newView .= $this->makeTrayAssignments($row, $userId);
				
			}
			
			//create traycont table (tray contents)
			$sql3 = "SELECT * FROM traycont WHERE tray_id='$tray_id'";
			
			$newView .= "<h4>Tray contents: </h4>";

			if($result3 = $this->query($sql3)) {
				
				while ($row3 = mysqli_fetch_assoc($result3)) {
					
					extract($row3);
					
					$instrument = $this->findInstrument($inst_id, "name");
					
					$newView .= "<div class='instrumentView'>";
					$newView .= "$quant x $instrument";
					$newView .= "</div>";
				}
				
			}

					
			/* $newView .= "<table>" .
			"<tr><td><em>Tray ID: </em></td><td>$tray_id</td></tr>" .
			//"<tr><td><em>Name: </em></td><td>$name</td></tr>" .
			"<tr><td><em>Belongs To:</em></td><td>$company</td></tr>" .
			"<tr><td><em>Responsible Team:</em></td><td>$team</td></tr>" .
			"<tr><td><em>Loaned To: </em></td><td>$loanTeam</td></tr>" .
			"<tr><td><em>Status: </em></td><td>$status</td></tr>" .
			"<tr><td><em>Stored At: </em></td><td>$storage</td></tr>" .
			"<tr><td><a href='pickupTray.php?tid=$tray_id'>View Details/Pick Up</a></td>" .
			"<td>$loan</td></tr>" .
			"</table>"; */
			
			$loanButton = "<span class='loanButton'>$loan</span>";
			
			$newView .= "</div>$loanButton</div>";			
			//return $newView;			
			return "<div class='sitesTray'>$newView</div>";
		}
		
		//no longer used because open is no longer a valid status for trays
		/*
		public function makeOpenTables($userId) {
			$sql = "SELECT * FROM trays WHERE team_id='$userId' AND status='Open'";
			
			$result = $this->query($sql);
			
			if($result->num_rows != 0) {
			
				echo "<div class='openelement'>";
				echo "<h2>Open Trays:</h2>";
				
				while($row = mysqli_fetch_assoc($result)) {
				
					if($row['status'] != "Open") return "There are no open trays.";
					
					//get assoc array and print table data
					
					extract($row);
						
					$company = $this->findCompany($cmp_id, "name");
					$team = $this->findTeam($team_id, "name");
					$loanTeam = $this->findTeam($loan_team, "name");
					$siteName = $this->findSite($site_id, "name");
							
					$trayTable = "<table>" .
					"<tr><td><em>Tray ID</em></td><td>$tray_id</td></tr>" .
					"<tr><td><em>Name</em></td><td>$name</td></tr>" .
					"<tr><td><em>Belongs To:</em></td><td>$company</td></tr>" .
					"<tr><td><em>Responsible Team:</em></td><td>$team</td></tr>" .
					"<tr><td><em>Loaned To</em></td><td>$loanTeam</td></tr>" .
					"<tr><td><em>Status</em></td><td>$status</td></tr>" .
					"<tr><td><a href='viewTrayDetail.php?tid=$tray_id'>View Details/Check-in</a></td></tr>" .
					"</table>";
						
					echo "<div class='openTray'>$trayTable</div>";
				}
				
				echo "</div>";
					
			} else {
			
				//echo "No trays at that location.";
			}
				
		} */
		
		/* public function makeLoanedTables($usersTeamId, $method) {			
			$sql = "SELECT * from trays WHERE status='Loaned' and (team_id='$usersTeamId' or loan_team='$usersTeamId')";	
			
			$result = $this->query($sql);
			
			if($result->num_rows != 0) {
			
				echo "<div class='loanedelement'>";
				echo "<h2>Loaned Trays:</h2>";
				
				while($row = mysqli_fetch_assoc($result)) {
				
					//get assoc array and print table data
					
					extract($row);
					
					$company = $this->findCompany($cmp_id, "name");
					$team = $this->findTeam($team_id, "name");
					$loanTeam = $this->findTeam($loan_team, "name");
					
					$fromAnotherTeam = "";
					//echo $loan_team; echo $team_id;
					if($loan_team == 0) $loan = "<a href='loanTray.php?tid=$tray_id&mtd=$method&action=loan'> Loan tray to another team</a>";
					elseif($loan_team != 0 && $loan_team == $usersTeamId) {
						$loan = "<a href='loanTray.php?tid=$tray_id&mtd=$method&action=return'> Return borrowed tray</a>";
						$fromAnotherTeam = "<tr><td><span class='loan'>Borrowed from another team</span></td></tr>";
					}
					elseif($team_id == $usersTeamId && $loan_team != 0) $loan = "<span class='loan'>Loaned</span>";
							
					$trayTable = "<table>" .
					"$fromAnotherTeam" .
					"<tr><td><em>Tray ID</em></td><td>$tray_id</td></tr>" .
					"<tr><td><em>Name</em></td><td>$name</td></tr>" .
					"<tr><td><em>Belongs To:</em></td><td>$company</td></tr>" .
					"<tr><td><em>Responsible Team:</em></td><td>$team</td></tr>" .
					"<tr><td><em>Loaned To</em></td><td>$loanTeam</td></tr>" .
					"<tr><td><em>Status</em></td><td>$status</td></tr>" .
					"<tr><td><a href='viewTrayDetail.php?tid=$tray_id'>View Details/Check-in</a></td>" .
					"<td>$loan</td></tr>" .
					"</table>";
						
						
					echo "<div class='loanedTray'>$trayTable</div>";
				}
				
				echo "</div>";
					
			} else {
			
				//echo "No currently loaned trays.";
			}
				
		} */
		
		public function makeScheduledTables($usersTeamId, $method) {
			$sql = "SELECT * from trays WHERE status='Scheduled' and (team_id='$usersTeamId' or loan_team='$usersTeamId')";	
			
			$result = $this->query($sql);
			
			if($result->num_rows != 0) {
			
				echo "<div class='scheduledelement'>";
				echo "<h2>Scheduled Trays:</h2>";
				
				while($row = mysqli_fetch_assoc($result)) {
				
					//get assoc array and print table data
					
					extract($row);
					
					$company = $this->findCompany($cmp_id, "name");
					$team = $this->findTeam($team_id, "name");
					$loanTeam = $this->findTeam($loan_team, "name");
					
					$fromAnotherTeam = "";
					//echo $loan_team; echo $team_id;
					if($loan_team == 0) $loan = "<a href='loanTray.php?tid=$tray_id&mtd=$method&action=loan'> Loan tray to another team</a>";
					elseif($loan_team != 0 && $loan_team == $usersTeamId) {
						$loan =  "<a href='loanTray.php?tid=$tray_id&mtd=$method&action=return'> Return borrowed tray</a>";
						$fromAnotherTeam = "<tr><td><span class='loan'>Borrowed from another team</span></td></tr>";
					}
					elseif($team_id == $usersTeamId && $loan_team != 0) $loan = "<span class='loan'>Loaned</span>";
							
					$trayTable = "<table>" .
					"$fromAnotherTeam" .
					"<tr><td><em>Tray ID</em></td><td>$tray_id</td></tr>" .
					"<tr><td><em>Name</em></td><td>$name</td></tr>" .
					"<tr><td><em>Belongs To:</em></td><td>$company</td></tr>" .
					"<tr><td><em>Responsible Team:</em></td><td>$team</td></tr>" .
					"<tr><td><em>Loaned To</em></td><td>$loanTeam</td></tr>" .
					"<tr><td><em>Status</em></td><td>$status</td></tr>" .
					"<tr><td><a href='viewTrayDetail.php?tid=$tray_id'>View Details/Check-in</a></td>" .
					"<td>$loan</td></tr>" .
					"</table>";
						
						
					echo "<div class='scheduled'>$trayTable</div>";
				}
				
				echo "</div>";
					
			} else {
			
				//echo "No currently loaned trays.";
			}
					
		}
		
		public function makeReturnedTables($usersTeamId, $method) {
			$sql = "SELECT * from trays WHERE status='Returned' and (team_id='$usersTeamId' or loan_team='$usersTeamId')";	
			
			$result = $this->query($sql);
			
			if($result->num_rows != 0) {
			
				echo "<div class='returnedelement'>";
				echo "<h2>Returned Trays:</h2>";
				
				while($row = mysqli_fetch_assoc($result)) {
				
					//get assoc array and print table data
					
					extract($row);
					
					$company = $this->findCompany($cmp_id, "name");
					$team = $this->findTeam($team_id, "name");
					$loanTeam = $this->findTeam($loan_team, "name");
					
					$fromAnotherTeam = "";
					//echo $loan_team; echo $team_id;
					if($loan_team == 0) $loan = "<a href='loanTray.php?tid=$tray_id&mtd=$method&action=loan'> Loan tray to another team</a>";
					elseif($loan_team != 0 && $loan_team == $usersTeamId) {
						$loan =  "<a href='loanTray.php?tid=$tray_id&mtd=$method&action=return'> Return borrowed tray</a>";
						$fromAnotherTeam = "<tr><td><span class='loan'>Borrowed from another team</span></td></tr>";
					}
					elseif($team_id == $usersTeamId && $loan_team != 0) $loan = "<span class='loan'>Loaned</span>";
							
					$trayTable = "<table>" .
					"$fromAnotherTeam" .
					"<tr><td><em>Tray ID</em></td><td>$tray_id</td></tr>" .
					"<tr><td><em>Name</em></td><td>$name</td></tr>" .
					"<tr><td><em>Belongs To:</em></td><td>$company</td></tr>" .
					"<tr><td><em>Responsible Team:</em></td><td>$team</td></tr>" .
					"<tr><td><em>Loaned To</em></td><td>$loanTeam</td></tr>" .
					"<tr><td><em>Status</em></td><td>$status</td></tr>" .
					"<tr><td><a href='viewTrayDetail.php?tid=$tray_id'>View Details/Check-in</a></td>" .
					"<td>$loan</td></tr>" .
					"</table>";
						
						
					echo "<div class='returned'>$trayTable</div>";
				}
				
				echo "</div>";
					
			} else {
			
				//echo "No currently loaned trays.";
			}				
		}

		
		public function makeCasesTable($userId, $row) {
		
			extract($row);
				
			//first, find the users teamid
			$sql = "SELECT team_id from users WHERE usr_id='$userId'";
			$result = $this->query($sql);
			$row2 = mysqli_fetch_array($result);
			$usersTeamId = $row2[0];
			
			$trayNameClass = "$case_id" . "_class";
			
			//date
			$date = $this->checkTime($dttm);
			$date = "<div class='caseTime'>Surgery Date: $date</div>";
			
			//doctor
			$doc = $this->findDoctor($doc_id, "name");
			$site = $this->findSite($site_id, "name");
			
			$docSite = "<div class='docSite'>$doc @ $site</div>";
			
			$comment = "<div class='caseComment'>$cmt</div>";
			
			//stuff here always visible
			$newView = "<div id='$trayNameClass' class='trayclass'>";
			//$newView .= "<div class='linkToComplete'><a href='/athena/www/reservations.php?complete=1&cid=$case_id'>Mark as Complete</a></div>";
			$newView .= "<div class='clickable' onclick='expandCase($case_id)'>"; //open clickable
			$newView .= "<h2>Case No: $case_id</h2>";
			$newView .= $date;
			$newView .= $docSite;
			//$newView .= $comment;
			$newView .= "<em class='trayarrow' id='arrow$case_id'>&#x25bc;</em>";
			$newView .= "</div>"; //close clickable
			
			//This stuff is revealed by clicking, its in the dropdown
			
			$newView .=  "<div id='$trayNameClass" . "_expanded' class='expandedtrayview' style='display: none;'>";
			
			$newView .= "<div class='ttypRecords'>"; //open ttyp records
			$newView .= "<h4 class='assignmentsLabel'>Unfulfilled tray types: </h4>";
			//get unfuffiled tray type records
			$ttypSql = "SELECT * FROM case_ttyp WHERE case_id='$case_id' AND tray_id='0'"; 
			$ttypResult = $this->query($ttypSql);
			while($ttypRow = mysqli_fetch_assoc($ttypResult)) {
				$name = $this->findTrayType($ttypRow['ttyp_id'], "name");
				
				$newView .= "<div class='ttypNeeded'>" . //open ttypNeeded
				"<div class='trayName'><em>Needed: </em> $name Tray</div>" .
				"</div>"; //close ttypNeeded
			
			}
			
			
			$newView .= "</div>"; //close ttyp records
			$newView .= "";
			
			$newView .= "<h4 class='assignmentsLabel'>Trays assigned to this case: </h4>";
			
			//generate trays associated with this case
			$sql = "SELECT tray_id FROM assigns INNER JOIN cases ON cases.case_id=assigns.case_id " .
			"WHERE (cases.case_id='$case_id' AND assigns.case_id='$case_id')";
			
			$result = $this->query($sql);
	
			while($row3 = mysqli_fetch_assoc($result)) {
			
				$tray = $row3['tray_id'];
			
				$sql2 = "SELECT * FROM trays WHERE tray_id='$tray'";
				
				
				$result2 = $this->query($sql2);
				
				$row4 = mysqli_fetch_assoc($result2);
				
				extract($row4);
				
				$company = $this->findCompany($cmp_id, "name");
				$team = $this->findTeam($team_id, "name");
				$site = $this->findSite($site_id, "name");
				$loanTeam = $this->findTeam($loan_team, "name");
				$storage = $this->findStorage($stor_id, "name");
				
				if($loanTeam == null) $loanTeam = "None";
				
				if($atnow == "usr") $status = "With user";
				if($atnow == "site") $status = "At site";
				if($atnow == "stor") $status = "In storage";
				if($atnow == "unk") $status = "Unknown";
				
				//figure out next avalibale time
				$sql5 = "SELECT do_dttm, pu_dttm FROM assigns INNER JOIN trays ON trays.tray_id=assigns.tray_id" .
				" WHERE trays.tray_id='$tray_id' AND assigns.tray_id='$tray_id' ORDER BY do_dttm DESC, pu_dttm DESC";
				
				//echo $sql5;
				
				$result5 = $this->query($sql5);
				
				$closestTime = 0;
				while($row5 = mysqli_fetch_array($result5)) {
					
					$doDTTM = strtotime($row5[0]);
					$puDTTM = strtotime($row5[1]);
					
					$closestTime = $row5[0];
					if ($closestTime < time() && time() > $doDTTM) $closestTime = $row5[1];
				
				}
				
				$avalibleTime = $this->checkTime($closestTime);
				
				
				$newView .= "<div class='traysInCase'>" .
				"<div class='assignLink'><a href='/athena/www/trays/trayDetail.php?tid=$tray'>Details</a></div>" .
				"<div class='trayName'>Name: $name</div>" .
				"<div class='trayTeam'>Team: $team For: $doc</div>" .
				//"<div class='trayTime'>Busy Until: $avalibleTime</div>" .
				"<div class='trayStatus'>Status: $status</div>" .
				"</div>";

				
			}
			
			$newView .= "</div>";
			
			$newView .= "<p><a href='/athena/www/addTrays.php?cid=$case_id'>ADD / REMOVE TRAYS</a></p>";
			
			$newView .= "$comment</div>";
			echo $newView;
		}
		
		
		public function makeCompletedCasesTable($userId, $caseId) {
				
			//first, find the users teamid
			$sql = "SELECT team_id from users WHERE usr_id='$userId'";
			$result = $this->query($sql);
			$row = mysqli_fetch_array($result);
			$usersTeamId = $row[0];
			
			//now, find cases assigned to that team, but only pending cases
			$sql = "SELECT * FROM cases WHERE team_id='$usersTeamId' AND status='Complete'";
			
			$result = $this->query($sql);
			
			
			if($result->num_rows != 0) {
			
				echo "<div class='caseelement'>";
				echo "<h2>Completed Cases:</h2>";
				
				while($row = mysqli_fetch_assoc($result)) {
				
					//get assoc array and print table data

					extract($row);
					
					$team = $this->findTeam($team_id, "name");
					$doc = $this->findDoctor($doc_id, "name");
					$procedure = $this->findProcedure($proc_id, "name");
					$siteName = $this->findSite($site_id, "name");
					
					//$dttm = $this->checkTime($dttm);
							
					$caseTable = "<table>" .
					"<tr><td><em>Case ID</em></td><td>$case_id</td></tr>" .
					"<tr><td><em>Assigned Team</em></td><td>$team</td></tr>" .
					"<tr><td><em>Doctor</em></td><td>$doc</td></tr>" .
					"<tr><td><em>Procedure</em></td><td>$procedure</td></tr>" .
					"<tr><td><em>Site</em></td><td>$siteName</td></tr>" .
					"<tr><td><em>Status</em></td><td>$status</td></tr>" .
					"<tr><td><em>Time</em></td><td>$dttm</td></tr>" .
					"<tr><td><em>Comment</em></td><td>$cmt</td></tr>" .
					"<tr><td><a href='reservations.php?pending=1&cid=$case_id'>Mark as Pending</a></td></tr>" .
					"</table>";
						
					echo "<div class='completed'>$caseTable</div>";
				}
				
				echo "</div>";
					
			} else {
			
				//echo "No trays at that location.";
			}
		}
			
		
				
		//lookup functions
		
		public function findCompany($cid, $requestedField) {
		
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM company WHERE cmp_id='$cid'";
			$result = $this->query($sql);
			$row = mysqli_fetch_assoc($result);
			
			return $row["$requestedField"];
		}
		
		public function findRegion($cid, $requestedField) {
		
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM regions WHERE reg_id='$cid'";
			$result = $this->query($sql);
			$row = mysqli_fetch_assoc($result);
			
			return $row["$requestedField"];
		}
		
		public function findUser($uid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM users WHERE usr_id='$uid'";
			$result = $this->query($sql);
			$row = mysqli_fetch_assoc($result);
			
			return $row["$requestedField"];
		}
		
		public function findSite($uid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM sites WHERE site_id='$uid'";
			$result = $this->query($sql);
			$row = mysqli_fetch_assoc($result);
			
			return $row["$requestedField"];
		}
		
		public function findTeam($uid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM teams WHERE team_id='$uid'";
			$result = $this->query($sql);
			$row = mysqli_fetch_assoc($result);
			
			return $row["$requestedField"];
		}
		
		public function findInstrument($uid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM instruments WHERE inst_id='$uid'";
			$result = $this->query($sql);
			$row = mysqli_fetch_assoc($result);
			
			return $row["$requestedField"];
		}
		
		public function findStorage($sid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM storage WHERE stor_id='$sid'";
			$result = $this->query($sql);
			$row = mysqli_fetch_assoc($result);
			
			return $row["$requestedField"];
		}
		
		
		public function findDoctor($uid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM doctors WHERE doc_id='$uid'";
			$result = $this->query($sql);
			$row = mysqli_fetch_assoc($result);
			
			return $row["$requestedField"];
		}
		
		public function findProcedure($uid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM procs WHERE proc_id='$uid'";
			$result = $this->query($sql);
			$row = mysqli_fetch_assoc($result);
			
			return $row["$requestedField"];
		}
				
				
		public function findTray($uid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM trays WHERE tray_id='$uid'";
			$result = $this->query($sql);
			$row = mysqli_fetch_assoc($result);
			
			return $row["$requestedField"];
		}	
		
		public function findClient($uid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM clients WHERE cli_id='$uid'";
			$result = $this->query($sql);
			$row = mysqli_fetch_assoc($result);
			
			return $row["$requestedField"];
		}
		
		public function findTrayType($ttypId, $requestedField) {
		
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM ttyp WHERE ttyp_id='$ttypId'";
			$result = $this->query($sql);
			$row = mysqli_fetch_assoc($result);
			
			return $row["$requestedField"];
		
		
		}
		
		//Other functions
		
			public function makeAssignmentTables($currentUser) {
			
				$sql = "SELECT * from assigns WHERE do_usr='$currentUser' OR pu_usr='$currentUser'";
			
				if($result = $this->query($sql)) {
				
					//get assoc array and print table data
					while ($row = mysqli_fetch_assoc($result)){
					
						if($row['status'] != "Complete") {					
							
							extract($row);
							
							$tray = $this->findTray($tray_id, "name");
							$dropoffUser = $this->findUser($do_usr, "uname");
							$pickupUser = $this->findUser($pu_usr, "uname");
							if($dropoffUser == null) $dropoffUser = "Pending";
							if($pickupUser == null) $pickupUser = "Pending";
							
							$doTime = $this->checkTime($do_dttm);
							$puTime = $this->checkTime($pu_dttm);
													
							$asgnTable = "<table>" .
							"<tr><td><em>Assignment ID</em></td><td>$asgn_id</td></tr>" .
							"<tr><td><em>Case No</em></td><td>$case_id</td></tr>" .
							"<tr><td><em>Dropped off By</em></td><td>$dropoffUser</td></tr>" .
							"<tr><td><em>Picked up By</em></td><td>$pickupUser</td></tr>" .
							"<tr><td><em>Dropoff Time</em></td><td>$doTime</td></tr>" .
							"<tr><td><em>Pickup Time</em></td><td>$puTime</td></tr>" .
							"<tr><td><em>Status</em></td><td>$status</td></tr>" .
							"<tr><td><em>Comment</em></td><td>$cmt</td></tr>" .
							"<tr><td><a href='userAssignments.php?complete=1&aid=$asgn_id'>Mark as completed</a></td></tr>" .
							"</table>";
							
							echo "<div class='assignment'>$asgnTable</div>";
						}
					}
				}
			}
			
			public function findTeamByCase($caseId) {
			
				$sql  = "SELECT team_id FROM cases WHERE case_id='$caseId'";
				
				$result = $this->query($sql);
				
				$row = mysqli_fetch_array($result);
				
				$team = $this->findTeam($row[0], "name");
				
				return $team;
			}
			
			public function makeCompletedAssignments($currentUser) {
			
				$sql = "SELECT * from assigns WHERE do_usr='$currentUser' OR pu_usr='$currentUser'";
			
				if($result = $this->query($sql)) {
				
					//get assoc array and print table data
					while ($row = mysqli_fetch_assoc($result)){
					
						if($row['status'] == "Complete") {					
							
							extract($row);
							
							$tray = $this->findTray($tray_id, "name");
							$dropoffUser = $this->findUser($do_usr, "uname");
							$pickupUser = $this->findUser($pu_usr, "uname");
							if($dropoffUser == null) $dropoffUser = "Pending";
							if($pickupUser == null) $pickupUser = "Pending";
							
							//uncomment these for red highlighting on overdue dates
							//$doTime = $this->checkTime($do_dttm);
							//$puTime = $thi->checkTime($pu_dttm);
													
							$asgnTable = "<table>" .
							"<tr><td><em>Assignment ID</em></td><td>$asgn_id</td></tr>" .
							"<tr><td><em>Case No</em></td><td>$case_id</td></tr>" .
							"<tr><td><em>Dropped off By</em></td><td>$dropoffUser</td></tr>" .
							"<tr><td><em>Picked up By</em></td><td>$pickupUser</td></tr>" .
							"<tr><td><em>Dropoff Time</em></td><td>$do_dttm</td></tr>" .
							"<tr><td><em>Pickup Time</em></td><td>$pu_dttm</td></tr>" .
							"<tr><td><em>Status</em></td><td>$status</td></tr>" .
							"<tr><td><em>Comment</em></td><td>$cmt</td></tr>" .
							"<tr><td><a href='userAssignments.php?pending=1&aid=$asgn_id'>Mark as pending</a></td></tr>" .
							"</table>";
							
							
							echo "<div class='completed'>$asgnTable</div>";
						}
					}
				}
			}
			
			public function makeTrayAssignments($row, $userId) {
				extract($row);
				
				//$newDiv = "<div id='assignment$asgn_id' class='assignmentTable'>";
				$doDTTM = $this->checkTime($do_dttm);
				$puDTTM = $this->checkTime($pu_dttm);
				$dropoffUser = $this->findUser($do_usr, "uname");
				$pickupUser = $this->findUser($pu_usr, "uname");
				if($pickupUser == null) $pickupUser = "Pending";
				if($dropoffUser == null) $dropoffUser = "Pending";
				
				$assignment = $row['asgn_id'];
				
				//find doctor and site
				$sql = "SELECT site_id, doc_id FROM cases INNER JOIN assigns ON cases.case_id=assigns.case_id WHERE assigns.asgn_id='$assignment'";
				$result = $this->query($sql);

				
				$newDiv = "<div class='innerAssignWrapper'>";
				while ($row2 = mysqli_fetch_array($result)) {
				
					$site = $this->findSite($row2[0], "name");
					$doc = $this->findDoctor($row2[1], "name");
					
					$newDiv .= "<div class='innerAssignTable'>" .
					"<table>" .
					"<tr><td>DO: $doDTTM</td><td>PU: $puDTTM</td></tr>" .
					"<tr><td>Location: $site</td><td>For: $doc</td></tr>" .
					"<tr><td><a href='/athena/www/assignments/assignmentDetail.php?aid=$asgn_id'>View Details</a></td></tr>" .
					"</table></div>";
			
				}
				/*
				$newDiv = "<table>" .
							"<tr><td><em>Assignment ID</em></td><td>$asgn_id</td></tr>" .
							"<tr><td><em>Case No</em></td><td>$case_id</td></tr>" .
							"<tr><td><em>Dropoff Time</em></td><td>$doDTTM</td></tr>" .
							"<tr><td><em>Pickup Time</em></td><td>$puDTTM</td></tr>" .
							"<tr><td><em>Status</em></td><td>$status</td></tr>" .
							"<tr><td><em>Comment</em></td><td>$cmt</td></tr>" .
							"<tr><td><a href='/athena/www/assignments/editAssignmentDetails.php?aid=$asgn_id'>Modify Details</a></td></tr>" .
							"</table>"; */
				
				$newDiv .= "</div>";
				return $newDiv;
			}
			
			public function showAllRelevantTrays($usrId, $siteId = null) {
				
				$this->makeSitesTrayTables($usrId, $siteId);
			}
			
		public function makeDateTimeForm($targetPage) {
		
			$form = "<form method='post' action='$targetPage'>";
			
			$yearSelect = "<select id='dateTime' name='newYear'>";
			
			for($y = 14; $y <= 32; $y++) {
				$yearSelect .= "<option id='y$y' value='20$y'>20$y</option>";
			}
		
			$yearSelect .= "</select>";
			
			$monthSelect = "<select name='newMonth'>";
			
			for($mo = 1; $mo <=12; $mo++) {
				$monthSelect .= "<option id='mo$mo' value='$mo'>$mo</option>";
			}
			
			$monthSelect .= "</select>";
			
			$daySelect = "<select name='newDay'>";
			
			for($day = 1; $day <=31; $day++) {
				$daySelect .="<option id='d$day' value='$day'>$day</option>";
			}
			
			$daySelect .= "</select>";
			
			$hourSelect = "<select name='newHour'>";
			
			for($h = 0; $h <=23; $h++) {
				$hourSelect .= "<option id='h$h' value='$h'>$h</option>";
			}
			
			$hourSelect .= "</select>";
			
			$minSelect = "<select name='newMin'>";
			
			for($m = 0; $m <= 59; $m++) {
				$minSelect .= "<option id='m$m' value='$m'>$m</option>";
			}
			
			$minSelect .= "</select>";
			
			$form .= "Month: $monthSelect Day: $daySelect Year: $yearSelect <br/>" .
			"Hour: $hourSelect Minute: $minSelect <br/>" .
			"<input type='submit' value='Modify Time' /> </form>";
			
			return $form;
		}
		
		public function makeDateTimeSelect($salt = "") {
			
			
			$yearSelect = "<select id='dateTime' name='newYear$salt'>";
			
			for($y = 14; $y <= 31; $y++) {
				$yearSelect .= "<option id='y$y" . $salt . "' value='20$y'>20$y</option>";
			}
		
			$yearSelect .= "</select>";
			
			$monthSelect = "<select name='newMonth$salt'>";
			
			for($mo = 1; $mo <=12; $mo++) {
				$monthSelect .= "<option id='mo$mo" . $salt . "' value='$mo'>$mo</option>";
			}
			
			$monthSelect .= "</select>";
			
			$daySelect = "<select name='newDay$salt'>";
			
			for($day = 1; $day <=31; $day++) {
				$daySelect .="<option id='d$day". $salt . "' value='$day'>$day</option>";
			}
			
			$daySelect .= "</select>";
			
			$hourSelect = "<select name='newHour$salt'>";
			
			for($h = 0; $h <=23; $h++) {
				$hourSelect .= "<option id='h$h". $salt ."' value='$h'>$h</option>";
			}
			
			$hourSelect .= "</select>";
			
			$minSelect = "<select name='newMin$salt'>";
			
			for($m = 0; $m <= 59; $m++) {
				$minSelect .= "<option id='m$m". $salt ."' value='$m'>$m</option>";
			}
			
			$minSelect .= "</select>";
			
			$form = "<br/>Month: $monthSelect Day: $daySelect Year: $yearSelect <br/>" .
			"Hour: $hourSelect Minute: $minSelect <br/>";
			
			return $form;
		}
		
		//time-checking functions
		public function checkTime($timeStamp) {
			date_default_timezone_set('America/Los_Angeles');
		
			$date = strtotime($timeStamp);
			$oneDayFromNow = time() + 86400;

			if(time() > strtotime($timeStamp)) return "<span class='error'>$timeStamp</span>"; // < 24 hours from now
			else if($date <= $oneDayFromNow && time() < $date) return "<span class='warning'>$timeStamp</span>";
			else return $timeStamp;
		}
		
		//NOT USED CURRENTLY
		public function makeTrayCheckboxes() {
			//This function creates a form with checkboxes for each tray
			//used in addTrays.php
			$sql = "SELECT tray_id, name FROM trays";
			
			$result = $this->query($sql);
			
			$form = "<form method='post' action='addTrays2.php'>";
			
			$form .= "<h2>Add Trays to Reservation: </h2>";
			
			$counter = 0;
			while($row = mysqli_fetch_array($result)) {
				if($counter == 0) $salt = "";
				$dateTime = $this->makeDateTimeSelect($salt);
				$form .= "<label><input type='checkbox' name='newTray[]' value='$row[0]'>$row[1] </label> <br/>";
				$form .= "$dateTime <br/>";
				
				$counter++;
			}
			
			$form .= "<input type='submit' value='Commit Reservation'/>";
		
			$form .= "</form>";
			
			return $form;
		}
		
		//this function will generate an icon corresponding to the site
		public function makeIcon($dest) {
			
			if($dest == "site") return "<img class='icon' src='/athena/www/utils/images/hospital_symbol.png' height='40' width='40' />";
			else if($dest == "storage") return "<img class='icon' src='/athena/www/utils/images/warehouse.png' height='40' width='40' />";
			else if($dest == "user") return "<img class='icon' src='/athena/www/utils/images/truck.png' height='40' width='40' />";
			
		}
		
		//this function makes the caleandar on the landing page
		
		public function makeCalendar($userId, $teamId) {
			//WARNING: this function is terrifying
			//displays cases and assignments from the next seven days
			date_default_timezone_set('America/Los_Angeles');
			
			$oneDayAgo = time() - (60 * 60 * 24);
			$currentTime = time();
			$oneDayFromNow = time() + (60 * 60 * 24);
			$twoDaysFromNow = time() + (60 * 60 * 24 * 2);
			$threeDaysFromNow = time() + (60 * 60 * 24 * 3);
			$fourDaysFromNow = time() + (60 * 60 * 24 * 4);
			$fiveDaysFromNow = time() + (60 * 60 * 24 * 5);
			$sixDaysFromNow = time() + (60 * 60 * 24 * 6);
			$oneWeekFromNow = time() + (7 * 24 * 60 * 60);
			
			$oneDayAgoDate = date("l M j, 'y", $oneDayAgo);
			$currentDate = date("l M j, 'y", $currentTime);
			$oneDayFromNowDate = date("l M j, 'y", $oneDayFromNow);
			$twoDaysFromNowDate = date("l M j, 'y", $twoDaysFromNow);
			$threeDaysFromNowDate = date("l M j, 'y", $threeDaysFromNow);
			$fourDaysFromNowDate = date("l M j, 'y", $fourDaysFromNow);
			$fiveDaysFromNowDate = date("l M j, 'y", $fiveDaysFromNow);
			$sixDaysFromNowDate = date("l M j, 'y", $sixDaysFromNow);
			$oneWeekFromNowDate = date("l M j, 'y", $oneWeekFromNow);
			
			$times = array($currentTime, $oneDayFromNow, $twoDaysFromNow, $threeDaysFromNow, $fourDaysFromNow, $fiveDaysFromNow,
			$sixDaysFromNow, $oneWeekFromNow);
			
			$dates = array($currentDate, $oneDayFromNowDate, $twoDaysFromNowDate, $threeDaysFromNowDate, $fourDaysFromNowDate,
			$fiveDaysFromNowDate, $sixDaysFromNowDate, $oneWeekFromNowDate);
			
			$alreadyPrinted = array();
			
			$salt = "";
			
			$timeViews = "<div class='trayclassholder'>"; //open tray class holder
			
			for ($i = 0; $i < count($dates); $i++) {
			
				$timeViews .= "<h4>$dates[$i]</h4>";
				
				
				$timeViews .= "<h5>Cases: </h5>";
				
					
				/********************************
				* print case tables for each case
				*********************************/
				$sql = "SELECT * FROM cases WHERE (team_id='$teamId' OR team_id='0')";
		
				$result = $this->query($sql);	
				
				
				while($row = mysqli_fetch_assoc($result)) {
						
						//if($row['status'] == "Complete") continue;

						if($i + 1 == count($dates)) $x = 6;
						else $x = $i;
						
						
						//check to make sure time is within range
						if($this->dateIsBetween($times[$x], $times[$x + 1], $row['dttm'])) {
						
							$case = $row['case_id'];
						
							//figure out how many assignments are pending or complete
							$noOfCompleteAssignments = 0;
							$noOfPendingAssignments = 0;
							$noOfAssignments = 0;
							
							$sql2 = "SELECT asgn_id, tray_id, status FROM assigns WHERE case_id='$case' AND (do_usr='$userId' OR pu_usr='$userId' OR do_usr='0' OR pu_usr='0')";
							
							//echo $sql2;
							
							$result2 = $this->query($sql2);
							
							while($row2 = mysqli_fetch_array($result2)) {		
								if($row2[2] == "Complete") $noOfCompleteAssignments++;
								if($row2[2] == "Pending") $noOfPendingAssignments++;
					
								$noOfAssignments++;
							}

							//is case complete?
							if($row['status'] == "Pending") $timeViews .= "<div id='" . $case . "_class' class='warningtrayclass'>"; //warning trayclass
							else $timeViews .= "<div id='" . $case . "_class' class='trayclass'>"; //open trayclass
						
							$team = $this->findTeam($row['team_id'], "name");
							$doc = $this->findDoctor($row['doc_id'], "name");
							$procedure = $this->findProcedure($row['proc_id'], "name");
							$site = $this->findSite($row['site_id'], "name");
							$case = $row['case_id'];
							
							
							//this stuff is always visible
							$timeViews .= "<div class='clickable' onclick='expandCase($case)'>"; //open clickable
							$timeViews .= "<h2>Case No: $case</h2>";

							
							if($noOfAssignments == $noOfCompleteAssignments && ($noOfAssignments != 0 || $noOfAssignments != null)) {
								$timeViews .= "<div class='assignmentDots'>";
								$timeViews .= "<img src='/athena/www/utils/images/check.png' height='40' width='40' />";
								$timeViews .= "</div>";
								
								//mark case as complete if there are no pending assignments associated with it
								$completeSql = "UPDATE cases SET status='Complete' WHERE case_id='$case'";
								$this->query($completeSql);
							} else if($noOfAssignments > 0) { 
								//assignment dots added here
								$timeViews .= "<div class='assignmentDots'>"; //open dots
								
								if($noOfCompleteAssignments > 0) {
									for($v = 1; $v <= $noOfCompleteAssignments; $v++) {
										$timeViews .= "<img src='/athena/www/utils/images/closedCircle.png' height='18' width='18' />";
									}
								}
									
								if($noOfPendingAssignments > 0) {
									for($k = 1; $k <= $noOfPendingAssignments; $k++) {
											$timeViews .= "<img src='/athena/www/utils/images/openCircle.png' height='18' width='18' />";
									}
								}
								$timeViews .= "</div>"; //close dots
							}
							
							
							
							
							$timeViews .= "<div class='caseProc'>$procedure</div>";
							$timeViews .= "<div class='docSite'>$doc @ $site</div>";
							$timeViews .= "<em class='trayarrow' id='arrow$case'>&#x25bc;</em>";
							$timeViews .= "</div>"; //close clickable
							
							
							
							//this stuff is hidden at first, revealed by click
							//open expandedtrayview
							$timeViews .=  "<div id='" . $case . "_class_expanded' class='expandedtrayview' style='display: none;'>";
							
							$timeViews .= "<h4 class='assignmentsLabel'>Trays assigned to this case: </h4>";
							
							
							//generate trays associated with this case
							$sql3 = "SELECT tray_id FROM assigns INNER JOIN cases ON cases.case_id=assigns.case_id " .
							"WHERE (cases.case_id='$case' AND assigns.case_id='$case')";
							$result3 = $this->query($sql3);

							while($row3 = mysqli_fetch_assoc($result3)) {
					
								$tray = $row3['tray_id'];
			
								$sql6 = "SELECT * FROM trays WHERE tray_id='$tray'";
								
								$result6 = $this->query($sql6);
								
								$row6 = mysqli_fetch_assoc($result6);
								
								extract($row6);
								
								$company = $this->findCompany($cmp_id, "name");
								$team = $this->findTeam($team_id, "name");
								$site = $this->findSite($site_id, "name");
								$loanTeam = $this->findTeam($loan_team, "name");
								$storage = $this->findStorage($stor_id, "name");
								
								if($loanTeam == null) $loanTeam = "None";
								
								if($atnow == "usr") $status = "With user";
								if($atnow == "site") $status = "At site";
								if($atnow == "stor") $status = "In storage";
								if($atnow == "unk") $status = "Unknown";
								
								//figure out next avalibale time
								$sql7 = "SELECT do_dttm, pu_dttm FROM assigns INNER JOIN trays ON trays.tray_id=assigns.tray_id" .
								" WHERE trays.tray_id='$tray' AND assigns.tray_id='$tray' ORDER BY do_dttm DESC, pu_dttm DESC";
								
								//echo $sql5;
								
								$result7 = $this->query($sql7);
								
								$closestTime = 0;
								while($row7 = mysqli_fetch_array($result7)) {
									
									$doDTTM = strtotime($row7[0]);
									$puDTTM = strtotime($row7[1]);
									
									$closestTime = $row7[0];
									if ($closestTime < time() && time() > $doDTTM) $closestTime = $row7[1];
								
								}
								
								$avalibleTime = $this->checkTime($closestTime);
								
								
								$timeViews .= "<div class='traysInCase'>" .
								"<div class='assignLink'><a href='/athena/www/trays/trayDetail.php?tid=$tray'>Details</a></div>" .
								"<div class='trayName'>Name: $name</div>" .
								"<div class='trayTeam'>Team: $team For: $doc</div>" .
								//"<div class='trayTime'>Busy Until: $avalibleTime</div>" .
								"<div class='trayStatus'>Status: $status</div>" .
								"</div>";
								
							}
							
						
							$timeViews .= "</div>"; //close expanded case view
							$timeViews .= "</div>"; 
						}
					
					
				} // end case stuff
				
				/********************************
				* print tray tables for each day
				*********************************/
				$timeViews .= "<h5>Trays: </h5>";
				
				
				$getCaseSql = "SELECT case_id, site_id FROM cases WHERE (team_id='$teamId' OR team_id='0')";
		
				$getCaseResult = $this->query($getCaseSql);
				
				while($getCaseRow = mysqli_fetch_assoc($getCaseResult)) {
				
					$case = $getCaseRow['case_id'];
				
					$traySql = "SELECT tray_id, do_dttm, pu_dttm, assigns.status FROM assigns INNER JOIN cases ON cases.case_id=assigns.case_id " .
								"WHERE (cases.case_id='$case' AND assigns.case_id='$case')";
								
								
					
					$trayResult = $this->query($traySql);
					
					while($trayRow = mysqli_fetch_assoc($trayResult)) {
					
						//ignore trays from completed assignments
						if($trayRow['status'] == "Complete") continue;
						
						
					
					
						//this is time-related, bug?
						if($i + 1 == count($dates)) $x = 6;
						else $x = $i;
						
						//tray is a dropoff
						if($this->dateIsBetween($times[$x], $times[$x + 1], $trayRow['do_dttm'])) {
						
							
							
							$tray = $trayRow['tray_id'];
				
							$sql9 = "SELECT * FROM trays WHERE tray_id='$tray'";
									
							$result9 = $this->query($sql9);
									
							$row9 = mysqli_fetch_assoc($result9);
							
							
					
							$company = $this->findCompany($row9['cmp_id'], "name");
							$team = $this->findTeam($row9['team_id'], "name");
							$name = $this->findTray($tray, "name");
							$site_id = $row9['site_id'];
							if ($row9['site_id'] == 0) $site = 0;
							else $site = $this->findSite($row9['site_id'], "name");
							$loanTeam = $this->findTeam($row9['loan_team'], "name");
							$storage = $this->findStorage($row9['stor_id'], "name");
							$stor_id = $row9['stor_id'];
							
							$atnow = $row9['atnow'];
							
							
							//figure out next pending event
								$nextSql = "SELECT do_dttm, do_usr FROM assigns INNER JOIN trays ON trays.tray_id=assigns.tray_id" .
								" WHERE trays.tray_id='$tray' AND assigns.tray_id='$tray' AND assigns.status!='Complete' ORDER BY do_dttm DESC";

								
								
							
							$nextResult = $this->query($nextSql);
							
							$nextRow = mysqli_fetch_array($nextResult);
			
							$closestTime = $nextRow[0];
							$assignedUser = $nextRow[1];
													
							
							//ignore non-pending and trays assigned to other users
							if($assignedUser != 0 && $assignedUser != $userId) {
								continue;
							
							}
							
							if($loanTeam == null) $loanTeam = "None";
			
							if($atnow == "usr") $status = "With user";
							if($atnow == "site") $status = "At site";
							if($atnow == "stor") $status = "In storage";
							if($atnow == "unk") $status = "Unknown";
							
							
							
							//figure out time of next pending dropoff event
							$sql10 = "SELECT do_dttm, pu_dttm, do_usr, pu_usr FROM assigns INNER JOIN trays ON trays.tray_id=assigns.tray_id" .
							" WHERE trays.tray_id='$tray' AND assigns.tray_id='$tray' AND assigns.status!='Complete' ORDER BY do_dttm DESC, pu_dttm DESC";
							//echo $sql10;
							
							$result10 = $this->query($sql10);
							
							//figure out closest assignment
							$row10 = mysqli_fetch_array($result10);
							
							$closestDOTime = $row10[0];
							$closestPUTime = $row10[1];
								
							$assignedToDO = $this->findUser($row10[2], "uname");
							$assignedToPU = $this->findUser($row10[3], "uname");
							
							
							
							if($assignedToDO == null)
								$assignedToDO = "<div class='assignedToDO'>Dropoff: Unassigned</div>";
							else
								$assignedToDO = "<div class='assignedToDO'>Dropoff Assigned To: $assignedToDO</div>";
							
								
							$userAssignments = "<div class='userAssignments'>$assignedToDO</div>";
				
							if($closestDOTime != null) $closestDOTime = $this->checkTime($closestDOTime);
							else $closestDOTime = "No Dropoff Scheduled";
							
							
							//check to see if this tray was already printed earlier
							//this is needed to make the javascript work correctly
							if(in_array($tray, $alreadyPrinted)) {
								if($salt == "") $salt = 0;
								$salt++;
							}
									
							//trayview building begins here
							//is assignment due within one day?, or is there still no dropoff user assigned?
							if(($this->dateIsBetween(time() - (60 * 60 * 24), time() + (60 * 60 * 24), $closestDOTime) || ($row10['do_usr'] == 0))) $timeViews .= "<div id='Tray " . $tray . $salt . "_class' class='warningtrayclass'>"; //warning trayclass
							else $timeViews .= "<div id=' Tray " . $tray . $salt . "_class' class='trayclass'>"; //open trayclass
							
							$forIcon = "site";
							//if($site_id == 0 && $stor_id == 0) {  $site = "With User";  $forIcon = "user";  }
							//else if($site_id == 0 && $stor_id != 0) { $site = "In Storage"; $forIcon = "storage"; }
								
							
							//check if assignment is a pickup or dropoff
							$destId = $getCaseRow['site_id'];
							$dest = $this->findSite($destId, "name");
						
							$stateIcon = "<div class='stateIcon'><img src='/athena/www/utils/images/downarrow.png' width='40' height='40' /></div>";
							
							
							//generate icon/location
							$icon = $this->makeIcon($forIcon);
							if($forIcon != "storage" && $atnow != "site") 
								$loc = "<div class='location'>$icon Dropoff Location: $dest <br/> Due: $closestDOTime</div>";
							else
								$loc = "<div class='location'>$icon Destination: $dest </div>";
							
							//figure out next pending event

								$nextSql = "SELECT do_dttm, do_usr FROM assigns INNER JOIN trays ON trays.tray_id=assigns.tray_id" .
								" WHERE trays.tray_id='$tray' AND assigns.tray_id='$tray' AND assigns.status!='Complete' ORDER BY do_dttm DESC";
							
								//echo $nextSql;
							
							$nextResult = $this->query($nextSql);
							
							$nextRow = mysqli_fetch_array($nextResult);
			
							$closestTime = $nextRow[0];
							$assignedUser = $nextRow[1];
							
							
			
							if($closestTime != null) { 
								$closestTime = $this->checkTime($closestTime);
								
							} else  {
								$closestTime = "";
							}
							
							
							
							$timeViews .= "<div class='clickable' onclick='expand($tray". $salt . ")'>"; //open clickable
							$timeViews .= "<h2>$name</h2>";
							$timeViews .= $userAssignments;
							$timeViews .= $stateIcon;
							$timeViews .= $loc;
							$timeViews .= "<em class='trayarrow' id='arrow$tray" . $salt ."'>&#x25bc;</em>";
							$timeViews .= "</div>"; //close clickable
							
							//this stuff is hidden at first, revealed by click
							$timeViews .=  "<div id='Tray " . $tray . $salt . "_class_expanded' class='expandedtrayview' style='display: none;'>";
							
							
							$timeViews .= "<br/><span class='companydata'>Belongs To: $company.$team </span>";
							
							$sql11 = "SELECT * FROM assigns WHERE tray_id='$tray' AND (do_usr='$userId' OR pu_usr='$userId' OR do_usr='0' OR pu_usr='0') AND  (status='Pending' OR status='Overdue')";
							
							$result11 = $this->query($sql11);
							
							$timeViews .= "<br/><br/><h4 class='assignmentsLabel'>Upcoming assignments:</h4>";

							while($row11 = mysqli_fetch_assoc($result11)) {
					
								$timeViews .= $this->makeTrayAssignments($row11, $userId);
								
							}
							
							//create traycont table (tray contents)
							$sql12 = "SELECT * FROM traycont WHERE tray_id='$tray'";
							
							$timeViews .= "<h4>Tray contents: </h4>";

							if($result12 = $this->query($sql12)) {
								
								while ($row12 = mysqli_fetch_assoc($result12)) {
									
									extract($row12);
									
									$instrument = $this->findInstrument($inst_id, "name");
									
									$timeViews .= "<div class='instrumentView'>"; //open instrument view
									$timeViews .= "$quant x $instrument";
									$timeViews .= "</div>"; //close instrument view
								}
											
								
					
							}
							
							$timeViews .= "</div>"; //close expanded tray view 
							
							$timeViews .= "</div>"; //close trayclass
							
							
							
							if(!in_array($tray, $alreadyPrinted)) array_push($alreadyPrinted, $tray);
							
						//tray is a pickup
						} else if ($this->dateIsBetween($times[$x], $times[$x + 1], $trayRow['pu_dttm'])) {
						
							$tray = $trayRow['tray_id'];
				
							$sql9 = "SELECT * FROM trays WHERE tray_id='$tray'";
									
							$result9 = $this->query($sql9);
									
							$row9 = mysqli_fetch_assoc($result9);
					
							$company = $this->findCompany($row9['cmp_id'], "name");
							$team = $this->findTeam($row9['team_id'], "name");
							$name = $this->findTray($tray, "name");
							$site_id = $row9['site_id'];
							if ($row9['site_id'] == 0) $site = 0;
							else $site = $this->findSite($row9['site_id'], "name");
							$loanTeam = $this->findTeam($row9['loan_team'], "name");
							$storage = $this->findStorage($row9['stor_id'], "name");
							$stor_id = $row9['stor_id'];
							
							$atnow = $row9['atnow'];
							
							
							//figure out next pending event
								$nextSql = "SELECT pu_dttm, pu_usr FROM assigns INNER JOIN trays ON trays.tray_id=assigns.tray_id" .
								" WHERE trays.tray_id='$tray' AND assigns.tray_id='$tray' AND assigns.status!='Complete' ORDER BY pu_dttm DESC";
								
								
							
							$nextResult = $this->query($nextSql);
							
							$nextRow = mysqli_fetch_array($nextResult);
			
							$closestTime = $nextRow[0];
							$assignedUser = $nextRow[1];
							//echo $assignedUser;
							
							//ignore non-pending and trays assigned to other users
							if($assignedUser != 0 && $assignedUser != $userId) {
								continue;
							
							}
							
							if($loanTeam == null) $loanTeam = "None";
			
							if($atnow == "usr") $status = "With user";
							if($atnow == "site") $status = "At site";
							if($atnow == "stor") $status = "In storage";
							if($atnow == "unk") $status = "Unknown";
							
							
							//figure out time of next pending pickup event
							$sql10 = "SELECT pu_dttm, do_usr, pu_usr FROM assigns INNER JOIN trays ON trays.tray_id=assigns.tray_id" .
							" WHERE trays.tray_id='$tray' AND assigns.tray_id='$tray' AND assigns.status!='Complete' ORDER BY do_dttm DESC, pu_dttm DESC";
							//echo $sql10;
							
							$result10 = $this->query($sql10);
							
							//figure out closest assignment
							$row10 = mysqli_fetch_array($result10);
							
							$closestPUTime = $row10[0];
								
							//$assignedToDO = $this->findUser($row10[1], "uname");
							$assignedToPU = $this->findUser($row10[2], "uname");
							
							
							if($assignedToPU == null)
								$assignedToPU = "<div class='assignedToPU'>Pickup: Unassigned</div>";
							else
								$assignedToPU = "<div class='assignedToPU'>Pickup Assigned To: $assignedToPU</div>";
								
							$userAssignments = "<div class='userAssignments'>$assignedToPU</div>";
				
							
							if($closestPUTime != null) $closestPUTime = $this->checkTime($closestPUTime);
							else $closestPUTime = "No Pickup Scheduled";
							
							//check to see if this tray was already printed earlier
							//this is needed to make the javascript work correctly
							if(in_array($tray, $alreadyPrinted)) {
								if($salt == "") $salt = 0;
								$salt++;
							}
									
							//trayview building begins here
							//is assignment due within one day?, or is there still no dropoff user assigned?
							if(($this->dateIsBetween(time() - (60 * 60 * 24), time() + (60 * 60 * 24), $closestPUTime) || $row10['pu_usr'] == 0)) $timeViews .= "<div id='Tray " . $tray . $salt . "_class' class='warningtrayclass'>"; //warning trayclass
							else $timeViews .= "<div id=' Tray " . $tray . $salt . "_class' class='trayclass'>"; //open trayclass
							
							//pickup must be from a site
							$forIcon = "site";
							
							//check if assignment is a pickup or dropoff
							$destId = $getCaseRow['site_id'];
							$dest = $this->findSite($destId, "name");
							$stateIcon = "<div class='stateIcon'><img src='/athena/www/utils/images/uparrow.png' width='40' height='40' /></div>";
						
							
							//generate icon/location
							$icon = $this->makeIcon($forIcon);
							if ($forIcon != "storage" && $atnow == "site") 
								$loc = "<div class='location'>$icon Pickup Location: $site <br/> Until: $closestPUTime</div>";
							else
								$loc = "<div class='location'>$icon Pickup Location: $dest <br/> Until: $closestPUTime </div>";
							
							//figure out next pending event
								$nextSql = "SELECT pu_dttm, pu_usr FROM assigns INNER JOIN trays ON trays.tray_id=assigns.tray_id" .
								" WHERE trays.tray_id='$tray' AND assigns.tray_id='$tray' AND assigns.status!='Complete' ORDER BY pu_dttm DESC";
								
								//echo $nextSql;
							
							$nextResult = $this->query($nextSql);
							
							$nextRow = mysqli_fetch_array($nextResult);
			
							$closestTime = $nextRow[0];
							$assignedUser = $nextRow[1];
			
							if($closestTime != null) { 
								$closestTime = $this->checkTime($closestTime);
								
							} else  {
								$closestTime = "";
							}
							
							
							
							$timeViews .= "<div class='clickable' onclick='expand($tray". $salt . ")'>"; //open clickable
							$timeViews .= "<h2>$name</h2>";
							$timeViews .= $userAssignments;
							$timeViews .= $stateIcon;
							$timeViews .= $loc;
							$timeViews .= "<em class='trayarrow' id='arrow$tray" . $salt ."'>&#x25bc;</em>";
							$timeViews .= "</div>"; //close clickable
							
							//this stuff is hidden at first, revealed by click
							$timeViews .=  "<div id='Tray " . $tray . $salt . "_class_expanded' class='expandedtrayview' style='display: none;'>";
							
							
							$timeViews .= "<br/><span class='companydata'>Belongs To: $company.$team </span>";
							
							$sql11 = "SELECT * FROM assigns WHERE tray_id='$tray' AND (do_usr='$userId' OR pu_usr='$userId' OR do_usr='0' OR pu_usr='0') AND  (status='Pending' OR status='Overdue')";
							
							$result11 = $this->query($sql11);
							
							$timeViews .= "<br/><br/><h4 class='assignmentsLabel'>Upcoming assignments:</h4>";

							while($row11 = mysqli_fetch_assoc($result11)) {
					
								$timeViews .= $this->makeTrayAssignments($row11, $userId);
								
							}
							
							//create traycont table (tray contents)
							$sql12 = "SELECT * FROM traycont WHERE tray_id='$tray'";
							
							$timeViews .= "<h4>Tray contents: </h4>";

							if($result12 = $this->query($sql12)) {
								
								while ($row12 = mysqli_fetch_assoc($result12)) {
									
									extract($row12);
									
									$instrument = $this->findInstrument($inst_id, "name");
									
									$timeViews .= "<div class='instrumentView'>"; //open instrument view
									$timeViews .= "$quant x $instrument";
									$timeViews .= "</div>"; //close instrument view
								}
											
								
					
							}
							
							$timeViews .= "</div>"; //close expanded tray view 
							
							$timeViews .= "</div>"; //close trayclass
							
							
							
							if(!in_array($tray, $alreadyPrinted)) array_push($alreadyPrinted, $tray);

						}

					} 
					
				} // end tray stuff
				
				//divider here
				$timeViews .= "<div class='divider'></div>";
				//$timeViews .= "</div>"; //end trayclassholder
				
			}
			//print_r($alreadyPrinted);
			
			return $timeViews;

			
		}
		
		public function dateIsBetween($from, $to, $date = null) {
			if($date == null) $date = time();
			$date = is_int($date) ? $date : strtotime($date); // convert non timestamps
			$from = is_int($from) ? $from : strtotime($from); // ..
			$to = is_int($to) ? $to : strtotime($to);         // ..
			return ($date >= $from) && ($date <= $to); // extra parens for clarity
		}
		
		public function makeNotification($userId, $notId, $itemId, $msg, $evDttm) {
			//database cols are: 
			/*****************************************
			  not_id - Title              - item  - behavior

			+-- -------------------------------------------------------
			+--  1      - Loan Request       - req   - resolved  -
			+--  2      - Loan Reply         - req   - dismiss   -
			+--  3  *    - Tray Picked up     - tray  - dismiss   -
			+--  4 xxx   - Case Reminder      - case  - expired   -
			+--  5      - Tray Relinquished  - tray  - resolved  -
			+--  6  *    - Tray Unassigned    - tray  - resolved  -
			+--  7  *    - New Case Created   - case  - dismiss   -
			+--  8      - Tray Late          - tray  - resolved  -
		
			un_id     int(10)       not null auto_increment,
			usr_id    int(10)       not null,
  
			not_id    int(10)       not null default 0,     -- what kind of notice
			item_id   int(10)       not null default 0,     -- ID of thing
  
			hidden    int(10)       not null default 0,     -- set to 1 after the notification should be hidden
                                                  
			msg       varchar(255)  not null,               -- messages get resolved
			dttm      datetime      not null,               -- the dttm the notification was generated
			evdttm    datetime      not null,               -- the dttm of the event related to the notification
			vwdttm    datetime      not null,               -- the last dttm the notification was viewed
			primary key(un_id)
			******************************************/
			
			$dttm =  date("Y-m-d H:i:s", time());
			$vwDttm = "0000-00-00 00:00:00";
			
			$sql = "INSERT INTO unotifs (usr_id, not_id, item_id, msg, dttm, evdttm, vwdttm) " .
			"VALUES ('$userId', '$notId', '$itemId', '$msg', '$dttm', '$evDttm', '$vwDttm')";
			
			//echo $sql;
			
			$this->query($sql);
		
		
		}
		
		public function setNotificationHidden($un_id) {
			$sql = "UPDATE unotifs SET hidden='1' WHERE un_id='$un_id'";
			$this->query($sql);
		}
		
		public function setNotificationViewed($un_id) {
		
			$vwDttm = date("l M j, 'y", time());
		
			$sql = "UPDATE unotifs SET vwdttm='$vwDttm' WHERE un_id='$un_id'";
			$this->query($sql);
		
		}
	}
				
?>