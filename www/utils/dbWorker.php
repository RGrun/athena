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
						
						if($this->query($sql)) header( "Location: companyDetail.php?cid=$id" );
					} else {
						$sql = "UPDATE company SET active='1' WHERE cmp_id='$id'";
						
						if($this->query($sql)) header( "Location: companyDetail.php?cid=$id" );
					}
					
				}
			} else {
			
				$sql = "UPDATE company SET $column='$newData' WHERE cmp_id='$id'";
				
				if($this->query($sql)) header( "Location: companyDetail.php?cid=$id" );
				
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
		
		public function editStorageDatabase($column, $id, $newData = null) {
			if($column == "active") {
				$sql = "SELECT active FROM storage WHERE stor_id='$id'";
				if($result = $this->query($sql)) {
					$row = mysqli_fetch_assoc($result);
					if($row['active'] == 1) {
						$sql = "UPDATE storage SET active='0' WHERE stor_id='$id'";
						
						if($this->query($sql)) header( "Location: storageDetail.php?sid=$id" );
					} else {
						$sql = "UPDATE storage SET active='1' WHERE stor_id='$id'";
						
						if($this->query($sql)) header( "Location: storageDetail.php?sid=$id" );
					}
					
				}
			} else {
			
				$sql = "UPDATE storage SET $column='$newData' WHERE stor_id='$id'";
				
				if($this->query($sql)) header( "Location: storageDetail.php?sid=$id" );
				
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
		
		public function editAssignmentDatabase($column, $id, $newData = null, $link = true) {
				$sql = "UPDATE assigns SET $column='$newData' WHERE asgn_id='$id'";
				//echo $sql;
				if($this->query($sql) && $link == true) header( "Location: assignmentDetail.php?aid=$id" );
				else $this->query($sql);
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
		
		public function createSelector($requestTable, $field, $nameOfId, $pending = false, $alt = false, $storage = false) {
		
			$salt = "";
			if($alt == true) $salt = "2";
		
			$sql = "SELECT $field, $nameOfId FROM $requestTable";

			$result = $this->query($sql);
			
			$selector = "<select name='new$requestTable" . $salt . "' size='1'>";
			
			if($pending == true) $selector .= "<option value='0'>Pending</option>";
			if($requestTable == "teams") $selector .= "<option value='0'>None</option>";
			
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
			
			//in storage or unknown location trays only
			if($atnow == "site" || $atnow == "stor") return null;
			//$atnow == "usr" || $atnow == "unk"
		
			if($loanTeam == null) $loanTeam = "None";
		
			if($atnow == "usr") $status = "With user";
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
			" WHERE trays.tray_id='$tray_id' AND assigns.tray_id='$tray_id' ORDER BY do_dttm ASC";
			
			//echo $sql;
			
			$result = $this->query($sql);
			$row = mysqli_fetch_array($result);
			
			$closestTime = $row[0];
			
			$closestTime = $this->checkTime($closestTime);
			
			$forIcon = "site";
			if($site_id == 0 && $stor_id == 0) {  $site = "With User";  $forIcon = "user";  }
			else if($site_id == 0 && $stor_id != 0) { $forIcon = "storage"; }
			
			
			//generate icon/location
			$icon = $this->makeIcon($forIcon);
			$loc = "<div class='location'>$icon Current Location: $site <br/> Until: $closestTime</div>";
			
			//stuff here always visible
			$newView = "<div id='$trayNameClass' class='trayclass'>";

			$newView .= "<span class='dropoffButton'><a href='dropoffTray.php?tid=$tray_id'>View Details/Drop off</a></span>";
			$newView .= "<div class='clickable' onclick='expand($tray_id)'>"; //open clickable
			$newView .= $loc;
			$newView .= "<em class='trayarrow' id='arrow$tray_id'>&#x25bc;</em>";
			$newView .= "<h2>$name</h2>";
			$newView .= "</div>"; //close clickable
			
			//this stuff is hidden at first, revealed by click
			$newView .=  "<div id='$trayNameClass" . "_expanded' class='expandedtrayview' style='display: none;'>";
			
			$newView .= $fromAnotherTeam;
			
			$newView .= "<br/><span class='companydata'>Belongs To: $company.$team </span>";
			
			$sql = "SELECT * FROM assigns WHERE tray_id='$tray_id' AND (do_usr='$userId' OR pu_usr='$userId' OR status='Pending' OR status='Overdue')";
			
			$result = $this->query($sql);
			while($row = mysqli_fetch_assoc($result)) {
	
				$newView .= $this->makeTrayAssignments($row, $userId);
				
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
			" WHERE trays.tray_id='$tray_id' AND assigns.tray_id='$tray_id' ORDER BY pu_dttm ASC";
			
			//echo $sql;
			
			$result = $this->query($sql);
			$row = mysqli_fetch_array($result);
			
			$closestTime = $row[0];
			
			$closestTime = $this->checkTime($closestTime);

			$forIcon = "site";
			if($site_id == 0 && $stor_id == 0) {  $site = "With User";  $forIcon = "user";  }
			else if($site_id == 0 && $stor_id != 0) { $forIcon = "storage"; }
				
			//generate icon/location
			$icon = $this->makeIcon($forIcon);
			$loc = "<div class='location'>$icon Current Location: $site <br/> Until: $closestTime</div>";
			
			//stuff here always visible
			$newView = "<div id='$trayNameClass' class='trayclass'>";
			
			$newView .= "<span class='dropoffButton'><a href='pickupTray.php?tid=$tray_id'>View Details/Pick Up</a></span>";
			$newView .= "<div class='clickable' onclick='expand($tray_id)'>"; //open clickable
			$newView .= $loc;
			$newView .= "<em class='trayarrow' id='arrow$tray_id'>&#x25bc;</em>";
			$newView .= "<h2>$name</h2>";
			$newView .= "</div>"; //close clickable
			
			//this stuff is hidden at first, revealed by click
			$newView .=  "<div id='$trayNameClass" . "_expanded' class='expandedtrayview' style='display: none;'>";
			
			$newView .= $fromAnotherTeam;
			
			$newView .= "<br/><span class='companydata'>Belongs To: $company.$team </span>";
			
			$sql = "SELECT * FROM assigns WHERE tray_id='$tray_id' AND (do_usr='$userId' OR pu_usr='$userId' OR status='Pending' OR status='Overdue')";
			
			$result = $this->query($sql);
			while($row = mysqli_fetch_assoc($result)) {
	
				$newView .= $this->makeTrayAssignments($row, $userId);
				
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
		
		public function makeLoanedTables($usersTeamId, $method) {			
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
				
		}
		
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
					"<tr><td><em>Case ID:</em></td><td>$case_id</td></tr>" .
					"<tr><td><em>Assigned Team:</em></td><td>$team</td></tr>" .
					"<tr><td><em>Doctor:</em></td><td>$doc</td></tr>" .
					"<tr><td><em>Procedure:</em></td><td>$procedure</td></tr>" .
					"<tr><td><em>Site:</em></td><td>$siteName</td></tr>" .
					"<tr><td><em>Status:</em></td><td>$status</td></tr>" .
					"<tr><td><em>Time Created:</em></td><td>$dttm</td></tr>" .
					"<tr><td><em>Comment:</em></td><td>$cmt</td></tr>" .
					"<tr><td><a href='reservations.php?complete=1&cid=$case_id'>Mark as Complete</a></td>" .
					"<td><a href='addTrays.php?cid=$case_id'>Add/View Trays</a></td></tr>" .
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
				
				//find doctor and site
				$sql = "SELECT site_id, doc_id FROM cases INNER JOIN assigns ON cases.case_id=assigns.case_id WHERE assigns.do_usr='$userId' OR assigns.pu_usr='$userId'";
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
				$yearSelect .= "<option id='y$y' value='20$y'>20$y</option>";
			}
		
			$yearSelect .= "</select>";
			
			$monthSelect = "<select name='newMonth$salt'>";
			
			for($mo = 1; $mo <=12; $mo++) {
				$monthSelect .= "<option id='mo$mo' value='$mo'>$mo</option>";
			}
			
			$monthSelect .= "</select>";
			
			$daySelect = "<select name='newDay$salt'>";
			
			for($day = 1; $day <=31; $day++) {
				$daySelect .="<option id='d$day' value='$day'>$day</option>";
			}
			
			$daySelect .= "</select>";
			
			$hourSelect = "<select name='newHour$salt'>";
			
			for($h = 0; $h <=23; $h++) {
				$hourSelect .= "<option id='h$h' value='$h'>$h</option>";
			}
			
			$hourSelect .= "</select>";
			
			$minSelect = "<select name='newMin$salt'>";
			
			for($m = 0; $m <= 59; $m++) {
				$minSelect .= "<option id='m$m' value='$m'>$m</option>";
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
		//INCOMPLETE
		public function makeIcon($dest) {
			
			if($dest == "site") return "<img class='icon' src='/athena/www/utils/images/hospital_symbol.png' height='40' width='40' />";
			else if($dest == "storage") return "<img class='icon' src='/athena/www/utils/images/warehouse.png' height='40' width='40' />";
			else if($dest == "user") return "<img class='icon' src='/athena/www/utils/images/truck.png' height='40' width='40' />";
			
		}
		
	}
				
?>