<?php

	include_once "dbConnector.php";
	
	#This class handles all misc. DB-related stuff
	#It is primarily a bridge for queries from the rest of the system
	
	class Gremlin extends dbConnector {
	
		private $connection;
		
		public function __construct() {
		
			//establish connection to database
			$this->connection = $this->doConnect();
		}
		
			
		function __destruct() {
		    $this->closeConnection();
		}
		
			
		public function closeConnection() {
			mysqli_close($this->connection);
		}
		
		#query wrapper
		public function query($sql, $direct = false) {

			$mysqliResult = mysqli_query($this->connection, $sql);
			
			
			
			if($direct == TRUE) {
				return mysqli_fetch_assoc($mysqliResult);
			
			}
			
		
			if($mysqliResult == false) {
				return array();
			
			} else if(mysqli_num_rows($mysqliResult) == 1) {
			
				return array(mysqli_fetch_assoc($mysqliResult));
			
			
			} else {
			
				$assocToReturn = array();
				
				
				
				while($row = mysqli_fetch_assoc($mysqliResult)) {
				
					array_push($assocToReturn, $row);
				}
				
			
				if(!empty($assocToReturn)) return $assocToReturn;
			}
		}
		
		#HTML helper functions
		
		public function defend() {
		
			#No non-logged-in users allowed
			if (!isset($_SESSION['loggedIn'])) {
			
				header("Location: index.php");
				die();
			
			}
		
		
		}
		
		public function spawnPage($ID, $userType) {
			
			#logged-in users only
			$this->defend();
			
	
			$user = User::spawnUser($ID, $userType);
	
			return $user;
		
		}
		
		

		#MUST BE CALLED AFTER session_start() ON PAGE
		public function buildMenu($pageName) {
				
			#We need HTML headers first
			#this also handles the opening <body> tag for the page
			$headers = "<!DOCTYPE HTML>";
			$headers .= "<head>";
			$headers .= "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
			$headers .= "<meta content='utf-8' http-equiv='encoding'>";
			$headers .= "<title>Athena System | $pageName</title>";
			$headers .= "<link rel='stylesheet' type='text/css' href='core/styles.css'>";
			$headers .= "<script src='js/jquery-2-1-3.js'></script>";
			$headers .= "</head><body>";
			
		
			$menu = "<div class='navMenu'>"; #open menu
			
			#use inline-block in CSS for these buttons
			#left-aligned buttons
			$menu .= "<a href='home.php'><div class='navMenuButtonLogo'><img height='42' width='133' class='navMenuLogo'
			src='core/images/athena-logo.png'/> </div></a>";
			
			
			######DUMMY: calendar button is 'selected' for demo, rest are unselected
			$menu .= "<a href='home.php'><div class='navMenuButtonLeft navSelected'><span class='navMenuText'><b>Calendar</b></span></div></a>";
			
			
			$menu .= "<a href='trays.php'><div class='navMenuButtonLeft navUnselected'><span class='navMenuText'><b>Trays</b></span></div></a>";
			
			$menu .= "<a href='notifications.php'><div class='navMenuButtonLeft navUnselected'><span class='navMenuText'><b>Notifications</b></span></div></a>";
			
			$menu .= "<a href='teamActivity.php'><div class='navMenuButtonLeft navUnselected'><span class='navMenuText'><b>Team Activity</b></span></div></a>";
			
			$menu .= "<a href='data.php'><div class='navMenuButtonLeft navUnselected'><span class='navMenuText'><b>Data</b></span></div></a>";
			
			$menu .= "<a href='newCase.php'><div id='newCaseButton' class='navMenuButtonLeft navUnselected'><span class='navMenuText'><b>New Case</b></span></div></a>";
			
			
			#right-aligned buttons
			#add profile image?
			$menu .= "<a href='settings.php'><div class='navMenuButtonRight navUnselected'><span class='navMenuText'><b>Setttings</b></span></div></a>";
			
			$menu .= "<a href='help.php'><div class='navMenuButtonRight navUnselected'><span class='navMenuText'><b>Help</b></span></div></a>";
			
			$menu .= "</div>"; #end menu
			
			$menu .= "<div id='mainContentWrapper'>"; //open mainContentWrapper
			
			
			#make Gremlin object availible on every page
			$gremlin = new Gremlin();
			
			#set timezone
			date_default_timezone_set('America/Los_Angeles');
			
			#return header + menu
			return $headers . $menu;
		}
		
		public function buildFooter() {
		
			return "</div></body></html>";
		
		}
		
		#used on Home page to return "Anytime Events" rows
		public function buildPickupDropoffRows($userID, $teamID, $unixTime, $myEvents = false) {
		
			#for controlling the "none found" label
			$numRows = 0;
		
			#process unix timestamp
			$day = date("d", $unixTime);
			$month = date("m", $unixTime);
			$year = date ("Y", $unixTime);
			
			$tomorrow = date("d", $unixTime + (24 * 60 * 60));
			
			$databaseTimestamp = date("Y-m-d H:i:s", mktime(0, 0, 0, $month, $day, $year));
			$databaseTimestampEndOfDay = date("Y-m-d H:i:s", mktime(23, 59, 59, $month, $day, $year));
		
			#Figure out what cases are related to user and user's team (or any unassigned case)
			
			if($myEvents == false) {
				$sql = "SELECT * FROM cases WHERE (team_id='$teamID' OR team_id='0') AND (status='Pending')";
			} else {
				$sql = "SELECT * FROM cases WHERE (team_id='$teamID') AND (status='Pending')";
			}
			$cases = $this->query($sql);
			
			
			if(count($cases) <= 0) {
			
				goto end;
			
			}
			
			$rows = "";
			
			#for each case, check assignments related to current user's team
			foreach ($cases as $thisCase) {
			
				$thisCaseId = $thisCase['case_id'];
				
				if($myEvents == false) {
					$sql = "SELECT * FROM assigns WHERE (case_id='$thisCaseId') AND (do_usr='$userID' OR do_usr='0') AND (do_dttm BETWEEN '$databaseTimestamp' AND '$databaseTimestampEndOfDay') ORDER BY do_dttm DESC";
				} else {
					$sql = "SELECT * FROM assigns WHERE (case_id='$thisCaseId') AND (do_usr='$userID') AND (do_dttm BETWEEN '$databaseTimestamp' AND '$databaseTimestampEndOfDay') ORDER BY do_dttm DESC";
				}
				
				
				$DOassignments = array();
				
				#get drop off events
				$DOassignments = $this->query($sql);
				
				#FORGIVE ME
				if($DOassignments == 0 || $DOassignments == 1 || $DOassignments == null) goto pu;
				
				//echo print_r($DOassignments);
				
				#assemble drop-off events
				#build table rows
				foreach ($DOassignments as $thisAssign) {
				
					$numRows++;
				
					if(empty($thisAssign)) continue;
					
					//echo print_r($thisAssign);
					
					if($thisAssign['status'] == 'Complete') $complete = "complete";
					else $complete = "pending";
					
					$trayName = $this->findTrayData($thisAssign['tray_id'], "name");
					$siteName = $this->findSiteData($thisCase['site_id'], "name");
					$procName = $this->findProcedureData($thisCase['proc_id'], "name");
					$drName = $this->findDoctorData($thisCase['doc_id'], "name");
					
					$thisAssignID = $thisAssign['asgn_id'];
					
					$doUsr = $thisAssign['do_usr'];
					
					$rows .= "<tr><td>";
					$rows .= "<div data-user='$doUsr' class='normalRow $complete'><div class='rowBox'><span>Drop</span><span><br/> Off</span></div>";
					$rows .= "<div class='rowText'>$thisAssignID. Drop off <a href='#'>$trayName</a> at <a href='#'>$siteName</a> for $procName w/ $drName.</div>";
					
					#Check to see if there's already a user assigned
					$do_usr_sql = "SELECT do_usr FROM assigns WHERE asgn_id='$thisAssignID'";
					
					$do_usr = $this->query($do_usr_sql, true);
					
					if($do_usr['do_usr'] != 0) {
					
						$do_usr = $do_usr['do_usr'];
						$do_usr_name = $this->findUserData($do_usr, "uname");
						$selectData = "<select><option value='0'>Unassigned</option>";
						$selectData .= "<option selected value='$do_usr'>$do_usr_name</option>";
					} else {
						$selectData = "<select class='unassignedSelect'><option selected value='0'>Unassigned</option>";
					}
					
					
					$availUsers = $this->query("SELECT usr_id, uname FROM users WHERE team_id='$teamID'");
					
					foreach($availUsers as $userName) {
						$localUserId = $userName['usr_id'];
						$localUserName = $userName['uname'];
						if($localUserId == $do_usr) continue;
						$selectData .= "<option value='$localUserId'>$localUserName</option>";
					}
					$selectData .= "</select>";
					
					$rows .= "<div class='rowSelect'>$selectData</div>";
					$rows .=  "</div></td></tr>";
					
					
				
				}
				#GOTO STATEMENTS ARE BAD
				pu:
				
				if($myEvents == false) {
					$sql = "SELECT * FROM assigns WHERE (case_id='$thisCaseId') AND (pu_usr='$userID' OR pu_usr='0') AND (pu_dttm BETWEEN '$databaseTimestamp' AND '$databaseTimestampEndOfDay') ORDER BY pu_dttm DESC";
				} else {
					$sql = "SELECT * FROM assigns WHERE (case_id='$thisCaseId') AND (pu_usr='$userID') AND (pu_dttm BETWEEN '$databaseTimestamp' AND '$databaseTimestampEndOfDay') ORDER BY pu_dttm DESC";
				}
				
				
				#get pick-up events
				$PUassignments = $this->query($sql);
				
				
				if($PUassignments == 0 || $PUassignments == 1 || $PUassignments == null) continue;
				
				#assemble pick-up events
				foreach($PUassignments as $thisAssign) {
				
					if($thisAssign['status'] == 'Complete') $complete = "complete";
					else $complete = "pending";
					
					$thisAssignID = $thisAssign['asgn_id'];
					
					$trayName = $this->findTrayData($thisAssign['tray_id'], "name");
					$siteName = $this->findSiteData($thisCase['site_id'], "name");
					
					$puUsr = $thisAssign['pu_usr'];
					
					$rows .= "<tr><td>";
					$rows .= "<div data-user='$puUsr' class='normalRow $complete'><div class='rowBox'><span>Pick</span><span><br/> Up</span></div>";
					$rows .= "<div class='rowText'>$thisAssignID. Pick up <a href='#'>$trayName</a> at <a href='#'>$siteName</a></div>";
					
					#Check to see if there's already a user assigned
					$pu_usr_sql = "SELECT pu_usr FROM assigns WHERE asgn_id='$thisAssignID'";
					
					$pu_usr = $this->query($pu_usr_sql, true);
					
					if($pu_usr['pu_usr'] != 0) {
					
						$pu_usr = $pu_usr['pu_usr'];
						$pu_usr_name = $this->findUserData($pu_usr, "uname");
						$selectData = "<select><option value='0'>Unassigned</option>";
						$selectData .= "<option selected value='$pu_usr'>$pu_usr_name</option>";
					} else {
						$selectData = "<select class='unassignedSelect'><option selected value='0'>Unassigned</option>";
					}
					
					$availUsers = $this->query("SELECT usr_id, uname FROM users WHERE team_id='$teamID'");
					
					foreach($availUsers as $userName) {
						$localUserId = $userName['usr_id'];
						$localUserName = $userName['uname'];
						
						if($localUserId == $pu_usr) continue;
						$selectData .= "<option value='$localUserId'>$localUserName</option>";
					}
					$selectData .= "</select>";
					
					$rows .= "<div class='rowSelect'>$selectData</div>";
					$rows .=  "</div></td></tr>";

					$numRows++;
				}
				
				
			
			}
			end:
			
			if($numRows > 0) {
			
				return $rows;
			
			} else {
				$emptyRow = "<tr><td>No events scheduled.</td></tr>";
				return $emptyRow;
			}
		
		}
		
		public function buildCaseEventsRows($userID, $teamID, $unixTime, $myEvents = false) {
		
			#for controlling the "none found" label
			$numRows = 0;
		
			#process unix timestamp
			$day = date("d", $unixTime);
			$month = date("m", $unixTime);
			$year = date ("Y", $unixTime);
			
			$tomorrow = date("d", $unixTime + (24 * 60 * 60));
			
			$databaseTimestamp = date("Y-m-d H:i:s", mktime(0, 0, 0, $month, $day, $year));
			$databaseTimestampEndOfDay = date("Y-m-d H:i:s", mktime(23, 59, 59, $month, $day, $year));
			
			if($myEvents == false) {	
				$sql = "SELECT * FROM cases WHERE (team_id='$teamID' OR team_id='0') AND status='Pending' AND (dttm BETWEEN '$databaseTimestamp' AND '$databaseTimestampEndOfDay') ORDER BY dttm DESC";
			} else {
				$sql = "SELECT * FROM cases WHERE (team_id='$teamID') AND status='Pending' AND (dttm BETWEEN '$databaseTimestamp' AND '$databaseTimestampEndOfDay') ORDER BY dttm DESC";
			}

			
			$cases = $this->query($sql);
			
			
			if(count($cases) <= 0) {
				#echo "jumped to end!";
				goto end;
			
			}
			
			$rows = "";
			
			#for each case, check assignments related to current user's team
			foreach ($cases as $thisCase) {
			
				$thisCaseId = $thisCase['case_id'];
				$thisCaseDTTM = $thisCase['dttm'];
			
				# build and process selectors
				$selectorsAndFlags = $this->createTTYPSelectors($thisCaseId);
				
				$rows .= "<tr><td>";
				
				
				# tray not assigned?
				if($selectorsAndFlags['trayUnassigned'] == true) {
					$rows .= "<div class='caseRow rowUnassigned'>"; #open Row
					$warningText = "<span class='caseRowUnassigned'>Tray is not assigned!</span>";
				# tray not on site?	
				} else if ($selectorsAndFlags['trayNotAtSite'] == true) {
					$warningText = "<span class='caseRowNotAtSite'>Tray is not at site!</span>";
					$rows .= "<div class='caseRow rowTrayNotAtSite'>"; #open Row
				# everything is fine
				} else {				
					$warningText = "";
					$rows .= "<div class='caseRow'>"; #open Row				
				}
				
				
				$caseTimeStamp = strtotime($thisCaseDTTM);
				$dateForBox = date("g:i a", $caseTimeStamp);
				
				$rows .= "<div class='caseTime'><h3>$dateForBox</h3></div>";
				
				$siteName = $this->findSiteData($thisCase['site_id'], "name");
				$procName = $this->findProcedureData($thisCase['proc_id'], "name");
				$drName = $this->findDoctorData($thisCase['doc_id'], "name");
				
				$rows .= "<div class='caseTextScheduled'>$procName at $siteName w/ $drName</div>";

				$rows .= "<div class='trayWarning'>$warningText</div>";
				
				$selectors = $selectorsAndFlags['selectors'];
				
				$rows .= "<div class='traysNeeded'>$selectors</div>";
				
				#rowSelectAlternate
				$selectData = "<select><option value='0'>Unassigned</option>";
				$sql = "SELECT usr_id, uname FROM users WHERE team_id='$teamID'";
				$availUsers = $this->query($sql);
					
				foreach($availUsers as $userName) {
					$localUserId = $userName['usr_id'];
					$localUserName = $userName['uname'];
					$selectData .= "<option value='$localUserId'>$localUserName</option>";
				}
				$selectData .= "</select>";
				
				$rows .= "<div class='rowSelectAlternate'>$selectData</div>";
			
			
				$rows .= "</div>"; #close Row
				
				$rows .= "</td></tr>";
				
				$numRows++;
			}
			end:
			
			
			if($numRows > 0) {
			
				return $rows;
			
			} else {
				$emptyRow = "<tr><td>No events scheduled.</td></tr>";
				return $emptyRow;
			}
		
		
		
		}
		
		
		
		#Writing functions
		
		
		
		
		
		#lookup functions
		
		public function createUserSelect() {
		
			$sql = "SELECT * FROM users WHERE active='1'";
			
			
			$result =  mysqli_query($this->connection, $sql);
			
			$select = "<select onchange='filterUsers()' id='repFilterSelect'>";
			$select .= "<option value='none'>No Filter</option>";
			$select .= "<option value='0'>Unassigned</option>";
			
			while($user = mysqli_fetch_assoc($result)) {
				
				$usr_id = $user['usr_id'];
				$uname = $user['uname'];
			
				$select .= "<option value='$usr_id'>$uname</option>";
				
			
			}
			
			$select .= "</select>";
			
			
			return $select;
			
		}
		
		#NEED TO REDO LOGIC IN THIS SECTION
		public function createTTYPSelectors($caseID) {
		
			$caseTTYPSql = "SELECT * FROM case_ttyp WHERE case_id='$caseID'";
			
			$trayNotAtSite = false;
			$trayUnassigned = false;
			
			
			$caseTTYPResult = $this->query($caseTTYPSql);
			
			# find data about site
			$caseSql = "SELECT * FROM cases WHERE case_id='$caseID'";
			$thisCase = $this->query($caseSql, true);
			
			$selectors = "";
			
			foreach($caseTTYPResult as $thisTTYP) {
			
				$ttyp_id = $thisTTYP['ttyp_id'];
				$tray_id = $thisTTYP['tray_id'];
				
				$tagsMatchingTTYPSql = "SELECT tag FROM ttyp_tag WHERE ttyp_id='$ttyp_id'";
				$tagsMatchingTTYP = $this->query($tagsMatchingTTYPSql);
				

				foreach ($tagsMatchingTTYP as $thisTag) {
					
					
					$curTag = $thisTag['tag'];
					
					$anotherSql = "SELECT DISTINCT tray_id FROM tray_tag WHERE tag='$curTag'";
					
					$trays = mysqli_query($this->connection, $anotherSql);
					
					#echo print_r($trays);
					
					if(count($trays) >= 2) $trays = $trays[0];
					
					foreach($trays as $tray) {
					
						#echo print_r($tray);
					
						$curTray = $tray['tray_id'];
						
						$trayName = $this->findTrayData($curTray, "name");
						
						# find data about tray
						$traySql = "SELECT * FROM trays WHERE tray_id='$curTray'";
						$trayData = $this->query($traySql, true);
						
						# tray is at a site, but not the correct site
						if($trayData['atnow'] == "site" && $trayData['site_id'] != $thisCase['site_id']) {
							$trayNotAtSite = true;
							
							$siteName = $this->findSiteData($trayData['site_id'], "name");
							$curSelect = "<select class='trayNotAtSite'>";
							$curSelect .= "<option value='0'>Unassigned</option>";
							$curSelect .= "<option value='$curTray' selected>$trayName</option>";
							
							continue;
							
						#tray is not assigned
						} else if($tray_id == 0) {
							$trayUnassigned = true;
							
							$curSelect = "<select class='trayUnassigned'>";
							$curSelect .= "<option value='0' selected>Unassigned</option>";
							
							continue;
						
						#tray is at site
						} else {
							$curSelect = "<select>";
							$curSelect .= "<option value='0'>Unassigned</option>";
							$curSelect .= "<option value='$curTray' selected>$trayName</option>";
							
							continue;
						
						}
						
					
						$curSelect .= "<option value='$curTray'>$trayName</option>";
						
					
					}
				
				}
				
				$curSelect .= "</select>";
				
				
				$selectors .= $curSelect;
			
			}
			#echo $selectors;
			
			$selectorAndFlags = array(
				'trayUnassigned' => $trayUnassigned,
				'trayNotAtSite' => $trayNotAtSite,
				'selectors' => $selectors,
			);
			
			return $selectorAndFlags;
		
		}
		
		public function findCompanyData($cid, $requestedField) {
		
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM company WHERE cmp_id='$cid'";
			$result = $this->query($sql);
			
			return $result[0]["$requestedField"];
		}
		
		public function findRegionData($cid, $requestedField) {
		
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM regions WHERE reg_id='$cid'";
			$result = $this->query($sql);
			
			return $result[0]["$requestedField"];
		}
		
		public function findUserData($uid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM users WHERE usr_id='$uid'";
			$result = $this->query($sql);
			
			return $result[0]["$requestedField"];
		}
		
		public function findSiteData($uid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM sites WHERE site_id='$uid'";
			$result = $this->query($sql);
			
			return $result[0]["$requestedField"];
		}
		
		public function findTeamData($uid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM teams WHERE team_id='$uid'";
			$result = $this->query($sql);
			
			return $result[0]["$requestedField"];
		}
		
		public function findInstrumentData($uid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM instruments WHERE inst_id='$uid'";
			$result = $this->query($sql);
			
			return $result[0]["$requestedField"];
		}
		
		public function findStorageData($sid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM storage WHERE stor_id='$sid'";
			$result = $this->query($sql);
			
			return $result[0]["$requestedField"];
		}
		
		
		public function findDoctorData($uid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM doctors WHERE doc_id='$uid'";
			$result = $this->query($sql);
			
			return $result[0]["$requestedField"];
		}
		
		public function findProcedureData($uid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM procs WHERE proc_id='$uid'";
			$result = $this->query($sql);
			
			return $result[0]["$requestedField"];
		}
				
				
		public function findTrayData($uid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM trays WHERE tray_id='$uid'";
			$result = $this->query($sql);
			
			return $result[0]["$requestedField"];
		}	
		
		public function findClientData($uid, $requestedField) {
					
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM clients WHERE cli_id='$uid'";
			$result = $this->query($sql);
			
			return $result[0]["$requestedField"];
		}
		
		public function findTrayTypeData($ttypId, $requestedField) {
		
			//$requestedField MUST match the name of a database column
			
			$sql = "SELECT * FROM ttyp WHERE ttyp_id='$ttypId'";
			$result = $this->query($sql);
			
			
			return $result[0]["$requestedField"];
		
		
		}
	
	
	}



?>