<?php

	require_once("dbConnector.php");

	class dbWorker extends dbConnector {
		
		//inherets db connection info and doConnect() method from dbConnector
		
		private $connection;
		
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
		
			if($column == "active") {
				$sql = "SELECT active FROM company WHERE cmp_id='$id'";
				if($result = $this->query($sql)) {
					$row = mysqli_fetch_assoc($result);
					if($row['active'] == 1) {
						$sql = "UPDATE company SET active='0' WHERE cmp_id='$id'";
						
						if($this->query($sql)) header( "Location: detail.php?cid=$id" );
					} else {
						$sql = "UPDATE company SET active='1' WHERE cmp_id='$id'";
						
						if($this->query($sql)) header( "Location: detail.php?cid=$id" );
					}
					
				}
			} else {
			
				$sql = "UPDATE company SET $column='$newData' WHERE cmp_id='$id'";
				
				if($this->query($sql)) header( "Location: detail.php?cid=$id" );
				
			}
		}
		
		public function editUserDatabase($column, $id, $newData = null) {
			if($column == "active") {
				$sql = "SELECT active FROM users WHERE usr_id='$id'";
				if($result = $this->query($sql)) {
					$row = mysqli_fetch_assoc($result);
					if($row['active'] == 1) {
						$sql = "UPDATE users SET active='0' WHERE usr_id='$id'";
						
						if($this->query($sql)) header( "Location: userDetail.php?uid=$id" );
					} else {
						$sql = "UPDATE users SET active='1' WHERE usr_id='$id'";
						
						if($this->query($sql)) header( "Location: userDetail.php?uid=$id" );
					}
					
				}
			} else {
			
				$sql = "UPDATE users SET $column='$newData' WHERE usr_id='$id'";
				
				if($this->query($sql)) header( "Location: userDetail.php?uid=$id" );
				
			}
		}
		
		public function editSiteDatabase($column, $id, $newData = null) {
			if($column == "active") {
				$sql = "SELECT active FROM sites WHERE site_id='$id'";
				if($result = $this->query($sql)) {
					$row = mysqli_fetch_assoc($result);
					if($row['active'] == 1) {
						$sql = "UPDATE sites SET active='0' WHERE site_id='$id'";
						
						if($this->query($sql)) header( "Location: siteDetail.php?sid=$id" );
					} else {
						$sql = "UPDATE sites SET active='1' WHERE site_id='$id'";
						
						if($this->query($sql)) header( "Location: siteDetail.php?sid=$id" );
					}
					
				}
			} else {
			
				$sql = "UPDATE sites SET $column='$newData' WHERE site_id='$id'";
				
				if($this->query($sql)) header( "Location: siteDetail.php?sid=$id" );
				
			}
		}
		
		public function editClientDatabase($column, $id, $newData = null) {
			if($column == "active") {
				$sql = "SELECT active FROM clients WHERE cli_id='$id'";
				if($result = $this->query($sql)) {
					$row = mysqli_fetch_assoc($result);
					if($row['active'] == 1) {
						$sql = "UPDATE clients SET active='0' WHERE cli_id='$id'";
						
						if($this->query($sql)) header( "Location: clientDetail.php?cid=$id" );
					} else {
						$sql = "UPDATE clients SET active='1' WHERE cli_id='$id'";
						
						if($this->query($sql)) header( "Location: clientDetail.php?cid=$id" );
					}
					
				}
			} else {
			
				$sql = "UPDATE clients SET $column='$newData' WHERE cli_id='$id'";
				
				if($this->query($sql)) header( "Location: clientDetail.php?cid=$id" );
				
			}
		}
		
		public function editDoctorDatabase($column, $id, $newData = null) {
			if($column == "active") {
				$sql = "SELECT active FROM doctors WHERE doc_id='$id'";
				if($result = $this->query($sql)) {
					$row = mysqli_fetch_assoc($result);
					if($row['active'] == 1) {
						$sql = "UPDATE doctors SET active='0' WHERE doc_id='$id'";
						
						if($this->query($sql)) header( "Location: doctorDetail.php?did=$id" );
					} else {
						$sql = "UPDATE doctors SET active='1' WHERE doc_id='$id'";
						
						if($this->query($sql)) header( "Location: doctorDetail.php?did=$id" );
					}
					
				}
			} else {
			
				$sql = "UPDATE doctors SET $column='$newData' WHERE doc_id='$id'";
				
				if($this->query($sql)) header( "Location: doctorDetail.php?did=$id" );
				
			}
		}
		
		public function editTeamDatabase($column, $id, $newData = null) {		
				$sql = "UPDATE teams SET $column='$newData' WHERE team_id='$id'";
				//echo $sql;
				if($this->query($sql)) header( "Location: teamDetail.php?tid=$id" );
		}
		
		public function editInstrumentDatabase($column, $id, $newData = null) {		
				$sql = "UPDATE instruments SET $column='$newData' WHERE inst_id='$id'";
				//echo $sql;
				if($this->query($sql)) header( "Location: instrumentDetail.php?iid=$id" );
		}
		
		public function editTrayDatabase($column, $id, $newData = null) {
				$sql = "UPDATE trays SET $column='$newData' WHERE tray_id='$id'";
				//echo $sql;
				if($this->query($sql)) header( "Location: trayDetail.php?tid=$id" );
		}
		
		public function editRegionDatabase($column, $id, $newData = null) {
				$sql = "UPDATE regions SET $column='$newData' WHERE reg_id='$id'";
				//echo $sql;
				if($this->query($sql)) header( "Location: regionDetail.php?rid=$id" );
		}
		
		public function editAssignmentDatabase($column, $id, $newData = null) {
				$sql = "UPDATE assigns SET $column='$newData' WHERE asgn_id='$id'";
				//echo $sql;
				if($this->query($sql)) header( "Location: assignmentDetail.php?aid=$id" );
		}
		
		public function editCaseDatabase($column, $id, $newData = null) {
				$sql = "UPDATE cases SET $column='$newData' WHERE case_id='$id'";
				//echo $sql;
				if($this->query($sql)) header( "Location: caseDetail.php?cid=$id" );
		}
				
		public function editTrayContents($column, $id, $newData = null, $tray_id) {
				$sql = "UPDATE traycont SET $column='$newData' WHERE inst_id='$id' AND tray_id='$tray_id'";
				//echo $sql;
				if($this->query($sql)) header( "Location: editTrayContents.php?iid=$id" );
		}		
				
		//creative functions
		
		public function createSelector($requestTable, $field, $nameOfId) {
		
			$sql = "SELECT $field, $nameOfId FROM $requestTable";

			$result = $this->query($sql);
			
			$selector = "<select name='new$requestTable' size='1'>";
			
			while($row = mysqli_fetch_array($result)) {
				$selector .= "<option value='$row[1]'>$row[0]</option>";
			}
	
			$selector .= "</select>";
			
			return $selector;
		}
		
		public function createLandingDropdown($userId) {
			
			$selector = "<select id='filterselect' size='1' onchange='trayFilter()'>" . 
			"<option value='all'>All</option>" .
			"<option disabled>--Sites--</option>";
			
			//display trays from the selected site
			$sql = "SELECT name, site_id FROM sites";
			//$sql = "SELECT * from trays WHERE team_id='$usersTeamId' AND site_id='$siteId'";
			
			$result = $this->query($sql);
			
			while($row = mysqli_fetch_array($result)) {
				$selector .= "<option value='$row[0]'>$row[0]</option>";
			}
			
			$selector .= "<option disabled>--Status--</option>";
			
			//display trays by status
			$sql = "SELECT status, name FROM trays";
			
			$result = $this->query($sql);
			
			$selector .= "<option value='open'>Open Trays</option><option value='loaned'>Loaned Trays</option><option value='scheduled'>Scheduled Trays</option>";

			$selector .= "</select>";
			
			return $selector;
			
		}
		
		public function makeSitesTrayTables($userId, $siteId) {
			
			//first, find the users teamid
			$sql = "SELECT team_id from users WHERE usr_id='$userId'";
			$result = $this->query($sql);
			$row = mysqli_fetch_array($result);
			$usersTeamId = $row[0];
			
			$sql = "SELECT * from trays WHERE team_id='$usersTeamId' AND site_id='$siteId'";
			
			if($result = $this->query($sql)) {
			
				$siteName = $this->findSite($siteId, "name");
				$siteNameClass = "$siteName" . "_class";
			
				echo "<div class='$siteNameClass'>";
				echo "<h2>Trays at $siteName</h2>";
				
				while($row = mysqli_fetch_assoc($result)) {
				
					//get assoc array and print table data
					
					extract($row);
						
					$company = $this->findCompany($cmp_id, "name");
					$team = $this->findTeam($team_id, "name");
					$loanTeam = $this->findTeam($loan_team, "name");
					
					if($status == "Returned") continue;
					
					$trayTable = "<table>" .
					"<tr><td><em>Tray ID</em></td><td>$tray_id</td></tr>" .
					"<tr><td><em>Name</em></td><td>$name</td></tr>" .
					"<tr><td><em>Belongs To:</em></td><td>$company</td></tr>" .
					"<tr><td><em>Responsible Team:</em></td><td>$team</td></tr>" .
					"<tr><td><em>Loaned To</em></td><td>$loanTeam</td></tr>" .
					"<tr><td><em>Status</em></td><td>$status</td></tr>" .
					"<tr><td><a href='viewTrayDetail.php?tid=$tray_id'>View Details/Check-in</a></td></tr>" .
					"</table>";
						
					echo "<div class='sitesTray'>$trayTable</div>";
				}
				
				echo "</div>";
					
			} else {
			
				echo "No trays at that location.";
			}
				
		}
		
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
				
		}
		
		public function makeLoanedTables($userId) {
			$sql = "SELECT * FROM trays WHERE team_id='$userId' AND status='Loaned'";
			
			$result = $this->query($sql);
			
			if($result->num_rows != 0) {
			
				echo "<div class='loanedelement'>";
				echo "<h2>Loaned Trays:</h2>";
				
				while($row = mysqli_fetch_assoc($result)) {
				
					//get assoc array and print table data
					if($row['status'] != "Loaned") continue;
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
						
					echo "<div class='loanedTray'>$trayTable</div>";
				}
				
				echo "</div>";
					
			} else {
			
				//echo "No currently loaned trays.";
			}
				
		}
		
		public function makeScheduledTables($userId) {
			$sql = "SELECT * FROM trays WHERE team_id='$userId' AND status='Scheduled'";
			
			$result = $this->query($sql);
			
			if($result->num_rows != 0) {
			
				echo "<div class='scheduledelement'>";
				echo "<h2>Scheduled Trays:</h2>";
				
				while($row = mysqli_fetch_assoc($result)) {
				
					//get assoc array and print table data
					
					if($row['status'] != "Scheduled") continue;

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
						
					echo "<div class='scheduledTray'>$trayTable</div>";
				}
				
				echo "</div>";
					
			} else {
			
				//echo "No trays at that location.";
			}
				
		}
		
		public function makeCasesTable($userId, $caseId) {
				
			//first, find the users teamid
			$sql = "SELECT team_id from users WHERE usr_id='$userId'";
			$result = $this->query($sql);
			$row = mysqli_fetch_array($result);
			$usersTeamId = $row[0];
			
			//now, find cases assigned to that team, but only pending cases
			$sql = "SELECT * FROM cases WHERE team_id='$usersTeamId' AND status='Pending'";
			
			$result = $this->query($sql);
			
			
			if($result->num_rows != 0) {
			
				echo "<div class='caseelement'>";
				echo "<h2>Pending Cases:</h2>";
				
				while($row = mysqli_fetch_assoc($result)) {
				
					//get assoc array and print table data

					extract($row);
					
					$team = $this->findTeam($team_id, "name");
					$doc = $this->findDoctor($doc_id, "name");
					$procedure = $this->findProcedure($proc_id, "name");
					$siteName = $this->findSite($site_id, "name");
							
					$caseTable = "<table>" .
					"<tr><td><em>Case ID</em></td><td>$case_id</td></tr>" .
					"<tr><td><em>Assigned Team</em></td><td>$team</td></tr>" .
					"<tr><td><em>Doctor</em></td><td>$doc</td></tr>" .
					"<tr><td><em>Procedure</em></td><td>$procedure</td></tr>" .
					"<tr><td><em>Site</em></td><td>$siteName</td></tr>" .
					"<tr><td><em>Status</em></td><td>$status</td></tr>" .
					"<tr><td><em>Time</em></td><td>$dttm</td></tr>" .
					"<tr><td><em>Comment</em></td><td>$cmt</td></tr>" .
					"<tr><td><a href='landing.php?complete=1&cid=$case_id'>Mark as Complete</a></td></tr>" .
					"</table>";
						
					echo "<div class='caseTray'>$caseTable</div>";
				}
				
				echo "</div>";
					
			} else {
			
				//echo "No trays at that location.";
			}
			
			
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
							
					$caseTable = "<table>" .
					"<tr><td><em>Case ID</em></td><td>$case_id</td></tr>" .
					"<tr><td><em>Assigned Team</em></td><td>$team</td></tr>" .
					"<tr><td><em>Doctor</em></td><td>$doc</td></tr>" .
					"<tr><td><em>Procedure</em></td><td>$procedure</td></tr>" .
					"<tr><td><em>Site</em></td><td>$siteName</td></tr>" .
					"<tr><td><em>Status</em></td><td>$status</td></tr>" .
					"<tr><td><em>Time</em></td><td>$dttm</td></tr>" .
					"<tr><td><em>Comment</em></td><td>$cmt</td></tr>" .
					"<tr><td><a href='landing.php?pending=1&cid=$case_id'>Mark as Pending</a></td></tr>" .
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
		
		//Other functions
		
			public function makeAssignmentTables() {
			
				$sql = "SELECT * from assigns";
			
				if($result = $this->query($sql)) {
				
					//get assoc array and print table data
					while ($row = mysqli_fetch_assoc($result)){
					
						if($row['status'] != "Complete") {					
							
							extract($row);
							
							$tray = $this->findTray($row['tray_id'], "name");
							$client = $this->findClient($row['cli_id'], "uname");
							$kind = ($row['kind'] == 1) ? "Drop" : "Pickup";
							
							$team = $this->findTeamByCase($case_id);
								
							$trayTable = "<table>" .
							"<tr><td><em>Assignment ID</em></td><td>$asgn_id</td></tr>" .
							"<tr><td><em>Case ID</em></td><td>$case_id</td></tr>" .
							"<tr><td><em>Team</em></td><td>$team</td></tr>" .
							"<tr><td><em>Tray</em></td><td>$tray</td></tr>" .
							"<tr><td><em>Client</em></td><td>$client</td></tr>" .
							"<tr><td><em>Date</em></td><td>$dttm</td></tr>" .
							"<tr><td><em>Status</em></td><td>$status</td></tr>" .
							"<tr><td><em>Comment</em></td><td>$cmt</td></tr>" .
							"<tr><td><em>Type</em></td><td>$kind</td></tr>" .
							"<tr><td><a href='userAssignments.php?complete=1&aid=$asgn_id'>Mark as completed</a></td></tr>" .
							"</table>";
							
							echo "<div class='assignment'>$trayTable</div>";
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
			
			public function makeCompletedAssignments() {
			
				$sql = "SELECT * from assigns";
			
				if($result = $this->query($sql)) {
				
					//get assoc array and print table data
					while ($row = mysqli_fetch_assoc($result)){
					
						if($row['status'] == "Complete") {					
							
							extract($row);
							
							$tray = $this->findTray($row['tray_id'], "name");
							$client = $this->findClient($row['cli_id'], "uname");
							$kind = ($row['kind'] == 1) ? "Drop" : "Pickup";
							
							$team = $this->findTeamByCase($case_id);
								
							$trayTable = "<table>" .
							"<tr><td><em>Assignment ID</em></td><td>$asgn_id</td></tr>" .
							"<tr><td><em>Case ID</em></td><td>$case_id</td></tr>" .
							"<tr><td><em>Team</em></td><td>$team</td></tr>" .
							"<tr><td><em>Tray</em></td><td>$tray</td></tr>" .
							"<tr><td><em>Client</em></td><td>$client</td></tr>" .
							"<tr><td><em>Date</em></td><td>$dttm</td></tr>" .
							"<tr><td><em>Status</em></td><td>$status</td></tr>" .
							"<tr><td><em>Comment</em></td><td>$cmt</td></tr>" .
							"<tr><td><em>Type</em></td><td>$kind</td></tr>" .
							"<tr><td><a href='userAssignments.php?pending=1&aid=$asgn_id'>Mark as pending</a></td></tr>" .
							"</table>";
							
							echo "<div class='completed'>$trayTable</div>";
						}
					}
				}
			}
			
			public function showAllRelevantTrays($usrId, $siteId = null) {
				
				$this->makeSitesTrayTables($usrId, $siteId);
			}
	}
				
?>