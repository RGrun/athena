<?php

	# homeList.php
	# List view for the Athena homepage
	
	include_once "includes.php";
	
	session_start();
	
	$gremlin = new Gremlin();
	
	$userID = $_SESSION['userID'];
	$userType = $_SESSION{'userType'};
	
	$user = $gremlin->spawnPage($userID, $userType);
	
	$page = "";
	
	$page .= $gremlin->buildMenu("$user->uname" . "'s Home - List", "homeList");
	
	$script = "<script src='js/home.js'></script>";
	
	$colTabRow = "<div class='colTabRow'>"; #open colTabRow
	
	$tabRow = "<div class='tabRowHeader'><h3>Calendar</h3></div>"; #tabRow
	
	$tabRow .= "<div id='tab1Button' onclick='tab1Toggle()' class='tabSelected'>All Events</div><div id='tab2Button' class='tabUnselected' onclick='tab2Toggle()'>My Events</div>";
	
	$tabRow .= "</div>"; #end colTabRow
	
	$colTabRow .= $tabRow;
	
	#menu bar with date selection stuff
	
	$dateMenuBar = "<div class='dateMenuBar'>"; #open dateMenuBar
	
	#this is where we figure out what date to show and display it in the date box
	$timeOffset = 0;
	
	# To calculate week range:
	# 1. find Sunday's date relative to now.
	# 2. calculate number of weeks offset based in GET parameter
	# 3. add number of weeks to Sunday
	if(isset($_GET['offset'])) {
	
		$offset = $_GET['offset'];
		
	} else {
		$offset = 0;
	}
	
	# figure out date range
	
	# 'sunday last week' gives the sunday of this week. stupid, right?
	$timeSinceSundayOfThisWeek = time() - strtotime('Sunday last week');
	
	$offset = $offset * 7;
	
	$sundayOfTargetWeek = (time() - $timeSinceSundayOfThisWeek) + ($offset * 24 * 60 * 60);
	
	$saturdayOfTargetWeek = $sundayOfTargetWeek + (6 * 24 * 60 * 60);
	
	if(!isset($_GET['offset']) || $_GET['offset'] == 0) {
		$todaySelected = "selected";
	} else {
		$todaySelected = "";
	}
	
	$todayButton = "<a href='homeList.php'><div class='$todaySelected' id='thisWeekButton'><small>This Week</small></div></a>";

	$arrowButtonsBox = "<div id='arrowButtonsBox'>";
	
	$arrowOffset = 0;
	if(isset($_GET['offset'])) {
		$arrowOffset = $_GET['offset'];
		$leftArrowOffset = $arrowOffset - 1;
		$rightArrowOffset = $arrowOffset + 1;
		
		$arrowButtonLeft = "<a href='homeList.php?offset=$leftArrowOffset'><div class='unselected' id='arrowButtonLeft'>&lt;</div></a>";
		$arrowButtonRight = "<a href='homeList.php?offset=$rightArrowOffset'><div class='unselected' id='arrowButtonLeft'>&gt;</div></a>";
		
	} else {
		$arrowButtonLeft = "<a href='homeList.php?offset=-1'><div class='unselected' id='arrowButtonLeft'>&lt;</div></a>";
		$arrowButtonRight = "<a href='homeList.php?offset=1'><div class='unselected' id='arrowButtonRight'>&gt;</div></a>";
	}
	
	$arrowButtonsBox .= $arrowButtonLeft . $arrowButtonRight;
	
	$arrowButtonsBox .= "</div>";
	
	$dateBox = "<div id='dateBoxCal' class='unselected'>";

	$sundayDate = date('l\, M jS', $sundayOfTargetWeek);
	$saturdayDate = date('l\, M jS', $saturdayOfTargetWeek);
	
	$todayText = "";
	
	if(!isset($_GET['offset']) || $arrowOffset == 0) $todayText = "<small>This Week</small>";
	
	$calDate = "<div id='calDate'>$todayText<br/><h3>$sundayDate - $saturdayDate</h3></div>";
	
	$dateBox .= $calDate;
	
	$dateBox .= "</div>";
	
	$dmyCalListBox = "<div id='calListBox'>";
	
	$dmyCalButton = "<a href='home.php'><div class='unselected' id='calButton'><small>[Cal]</small></div></a>";
	
	$dmyListButton = "<a href='#'><div class='calButtonSelected' id='listButton'><small>[List]</small></div></a>";
	
	$dmyCalListBox .= $dmyCalButton . $dmyListButton;
	
	$dmyCalListBox .= "</div>";
	
	# make 'disabled'
	$showFiltersButton = "<div class='disabled'  onclick='' id='showFiltersButton'><span>Show Filters</span></div>";
	
	$dateMenuBar .= $todayButton . $arrowButtonsBox .
	$dateBox . $dmyCalListBox . $showFiltersButton;
	
	
	$dateMenuBar .= "</div>"; #close dateMenuBar
	
	#Col 1 - Event List
	$col1 = "<div id='homeCol1'>"; #open homeCol1
	#there's two tabs in col1
	
	#tab 1 - All Events
	$tab1 = "<div id='homeTab1'>"; #open homeTab1
	
	$tab1 .= buildWeekMenu($sundayOfTargetWeek, false, $gremlin, $user);
	
	$tab1 .= "</div>"; # close homeTab1

	$tab2 = "<div id='homeTab2'  style='display: none;'>";

	$tab2 .= buildWeekMenu($sundayOfTargetWeek, true, $gremlin, $user);
	
	# tab 2 - My Events
	$tab2 .= "</div>"; # close homeTab2
	
	#assemble col1 - Event List
	$col1 .= $tab1 . $tab2;
	
	$col1 .= "</div>"; # close homeCol1
	
	#Col 2 - Notifications
	$col2 = "<div id='homeCol2'>"; #open homeCol2
	
	########START DUMMY
	
	$dmyNotificationsTable = "<table class='notificationsTable'>";
	
	$dmyNotificationsTable .= "<tr><td><h3>Notifications</h3></td></tr>";
	
	$dmyNotificationsTable .= "<tr><td><div class='notification'><div class='notificationsTableText'>Tray Grasper 1 is 1 day overdue for drop off at [site name] for [procedure] on [procedure date] - Drop off is assigned to [Rep Name]</div><div class='notificationsTableX'>X</div></div></td></tr>";
	
	$dmyNotificationsTable .= "<tr><td><div class='notification'><div class='notificationsTableText'>Not enough trays for cases on [date]</div><div class='notificationsTableX'>X</div><div class='notificationsTableGoToButton'>Go to [date]</div></div></td></tr>";
	
	$dmyNotificationsTable .= "<tr><td><div class='notification'><div class='notificationsTableText'>[Rep Name] from [Team Name] is requesting a [Tray Type] tray for a [Procedure Name] on [Procedure Date]</div><div class='notificationsTableX'>X</div><div class='notificationsTableGoToButton'>View available trays on [Date]</div></div></td></tr>";
	
	$dmyNotificationsTable .= "<tr><td><div class='notification'><div class='notificationsTableText'>[Additional Notification]</div><div class='notificationsTableX'>X</div></div></td></tr>";
	
	$dmyNotificationsTable .= "<tr><td><div class='notification'><div class='notificationsTableText'>[Additional Notification]</div><div class='notificationsTableX'>X</div></div></td></tr>";
	
	$dmyNotificationsTable .= "<tr><td><div class='notification'><div class='notificationsTableText'>[Additional Notification]</div><div class='notificationsTableX'>X</div></div></td></tr>";
	
	$dmyNotificationsTable .= "<tr><td><div class='notification'><div class='notificationsTableText'>[Additional Notification]</div><div class='notificationsTableX'>X</div></div></td></tr>";
	
	$dmyNotificationsTable .= "<tr><td><div class='notification'><div class='notificationsTableText'>[Additional Notification]</div><div class='notificationsTableX'>X</div></div></td></tr>";
	
	$dmyNotificationsTable .= "</table>";
	
	$col2 .= $dmyNotificationsTable;
	
	########END DUMMY
	
	
	$col2 .= "</div>"; #close homeCol2
	
	$page .= $script . $colTabRow . $dateMenuBar . $col1 . $col2;
	
	$page .= $gremlin->buildFooter();
		
	echo $page;
	
	# returns blocks of list view for the week defined in offset (relative to current week)
	function buildWeekMenu($timeOffset, $myEvents, $gremlin, $user) {
	
		# calculate days
		$unixTimeSunday = $timeOffset;
		$unixTimeMonday = $unixTimeSunday + (1 * 24 * 60 * 60);
		$unixTimeTuesday = $unixTimeSunday + (2 * 24 * 60 * 60);
		$unixTimeWednesday = $unixTimeSunday + (3 * 24 * 60 * 60);
		$unixTimeThursday = $unixTimeSunday + (4 * 24 * 60 * 60);
		$unixTimeFriday = $unixTimeSunday + (5 * 24 * 60 * 60);
		$unixTimeSaturday = $unixTimeSunday + (6 * 24 * 60 * 60);
		
		$week = array(
			$unixTimeSunday,
			$unixTimeMonday,
			$unixTimeTuesday,
			$unixTimeWednesday,
			$unixTimeThursday,
			$unixTimeFriday,
			$unixTimeSaturday,
		);
		
		$rows = "";
		
		foreach($week as $day) {
		
			$curDate = date('l\, F jS', $day);
		
			$row = "<div class='listTable'>";
			$row .= "<div class='listDate'>$curDate</div>";
		
			$row .= "<table>";
			$row .= "<tr><td><div class='headerRow'><h5>Pick Ups and Drop Offs</h5></div></td></tr>";
			$row .= $gremlin->buildPickupDropoffRows($user->ID, $user->teamID, $day, $myEvents);

			$row .= "<tr><td><div class='headerRow'><h5>Cases</h5></div></td></tr>";
			$row .= $gremlin->buildCaseEventsRows($user->ID, $user->teamID, $day, $myEvents);
			
			$row .= "</table>";
			
			$row .= "</div>";
			
			$rows .= $row;
		
		}
		
	
		return $rows;
	
	}
?>