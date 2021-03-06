<?php

	#home.php
	#this is the main screen for logged-in users
	#includes calendar screen and, menu bar, notifications, colTabRow, 2 tabs, 2 col[3:1] 
	#
	#Col 1: 2 tabs { "All Events", "My Events" } 
	# |
	# |-"All Events": List of all events relating to user's team.
	# |
	# |-"My Events": List of all tray events relating directly to user. 
	#
	#Col 2: Notifications
	
	include_once "includes.php";
	
	session_start();
	
	$gremlin = new Gremlin();
	
	$userID = $_SESSION['userID'];
	$userType = $_SESSION{'userType'};
	
	$user = $gremlin->spawnPage($userID, $userType);
	
	$page = "";
	
	$page .= $gremlin->buildMenu("$user->uname" . "'s Home", "home");
	
	$script = "<script src='js/home.js'></script>";
	
	#build colTabRow
	
	$colTabRow = "<div class='colTabRow'>"; #open colTabRow
	
	
	$tabRow = "<div class='tabRowHeader'><h3>Calendar</h3></div>"; #tabRow
	
	$tabRow .= "<div id='tab1Button' onclick='tab1Toggle()' class='tabSelected'>All Events</div><div id='tab2Button' class='tabUnselected' onclick='tab2Toggle()'>My Events</div>";
	
	$tabRow .= "</div>"; #end colTabRow
	
	$colTabRow .= $tabRow;
	
	
	#menu bar with date selection stuff
	
	$dateMenuBar = "<div class='dateMenuBar'>"; #open dateMenuBar
	
	#this is where we figure out what date to show and display it in the date box
	$timeOffset = 0;
	
	#Here we check to see if there's a time offset. If there is, it will be added to 
	#the current date
	if(isset($_GET['offset'])) {
	
		$offset = $_GET['offset'];
		
		$timeOffset = ($offset * 24 * 60 * 60);
		
	}
	
	#figure out date
	$unixTime = time() + $timeOffset;
	
	if(!isset($_GET['offset']) || $_GET['offset'] == 0) {
		$todaySelected = "selected";
	} else {
		$todaySelected = "";
	}
	
	
	$todayButton = "<a href='home.php'><div class='$todaySelected' id='todayButton'><small>Today</small></div></a>";

	$arrowButtonsBox = "<div id='arrowButtonsBox'>";
	
	$arrowOffset = 0;
	if(isset($_GET['offset'])) {
		$arrowOffset = $_GET['offset'];
		$leftArrowOffset = $arrowOffset - 1;
		$rightArrowOffset = $arrowOffset + 1;
		
		$arrowButtonLeft = "<a href='home.php?offset=$leftArrowOffset'><div class='unselected' id='arrowButtonLeft'>&lt;</div></a>";
		$arrowButtonRight = "<a href='home.php?offset=$rightArrowOffset'><div class='unselected' id='arrowButtonLeft'>&gt;</div></a>";
		
	} else {
		$arrowButtonLeft = "<a href='home.php?offset=-1'><div class='unselected' id='arrowButtonLeft'>&lt;</div></a>";
		$arrowButtonRight = "<a href='home.php?offset=1'><div class='unselected' id='arrowButtonRight'>&gt;</div></a>";
	}
	
	$arrowButtonsBox .= $arrowButtonLeft . $arrowButtonRight;
	
	$arrowButtonsBox .= "</div>";
	
	$dateBox = "<div id='dateBox' class='unselected'>";

	$curDate = date('l\, F jS', $unixTime);
	
	$todayText = "";
	
	if(!isset($_GET['offset']) || $arrowOffset == 0) $todayText = "<small>Today</small>";
	
	$calDate = "<div id='calDate'>$todayText<br/><h3>$curDate</h3></div>";
	
	$dateBox .= $calDate;
	
	$dateBox .= "</div>";
	
	$dmyCalListBox = "<div id='calListBox'>";
	
	$dmyCalButton = "<a href='#'><div class='calButtonSelected' id='calButton'><small>[Cal]</small></div></a>";
	
	$dmyListButton = "<a href='homeList.php'><div class='unselected' id='listButton'><small>[List]</small></div></a>";
	
	$dmyCalListBox .= $dmyCalButton . $dmyListButton;
	
	$dmyCalListBox .= "</div>";
	
	$showFiltersButton = "<div class='unselected'  onclick='toggleFilters()' id='showFiltersButton'><span>Show Filters</span></div>";
	
	$dateMenuBar .= $todayButton . $arrowButtonsBox .
	$dateBox . $dmyCalListBox . $showFiltersButton;
	
	
	$dateMenuBar .= "</div>"; #close dateMenuBar
	
	#filters box
	$filtersBox = "<div style='display:none;' class='filtersBox'>"; #open filtersBox
	
	$assignmentStatusDiv = "<div class='assignmentStatus'>" .
	"<h3>Assignment Status</h3>";
	
	$assignmentStatusSelect = "<select onchange='filterAssignments()' id='assignmentStatusSelect'>" .
	"<option value='none'>No Filter</option>" .
	"<option value='pending'>Pending Assignments</option>" .
	"<option value='complete'>Complete Assignments</option></select>";
	
	$assignmentStatusDiv .= $assignmentStatusSelect . "</div>";
	
	$repDiv = "<div class='repDiv'>" .
	"<h3>Representative</h3>";
	
	$repDivSelector = $gremlin->createUserSelect();
	
	$repDiv .= $repDivSelector . "</div>";
	
	$filtersBox .= $assignmentStatusDiv . $repDiv;
	
	$filtersBox .= "</div>"; #close filtersBox
	
	#Col 1 - Event List
	$col1 = "<div id='homeCol1'>"; #open homeCol1
	#there's two tabs in col1
	
	#tab 1 - All Events
	$tab1 = "<div id='homeTab1'>"; #open homeTab1
	
	
	$allEventsTable = "<table class='eventsTable'>";
	
	$allEventsRows = "<tr><td><div class='headerRow'><h5>Pick Ups and Drop Offs</h5></div></td></tr>";
	
	
	#Build "Anytime Events"
	$allEventsRows .= $gremlin->buildPickupDropoffRows($user->ID, $user->teamID, $unixTime);
	
	
	$allEventsRows .= "<tr><td><div class='headerRow'><h5>Cases</h5></div></td></tr>";
	
	
	$allEventsRows .= $gremlin->buildCaseEventsRows($user->ID, $user->teamID, $unixTime);
	
	
	
	$allEventsTable .= $allEventsRows;
	
	$allEventsTable .= "</table>";
	
	$tab1 .= $allEventsTable;
	
	$tab1 .= "</div>"; #close homeTab1
	
	#tab 2 - My Events
	$tab2 = "<div id='homeTab2' style='display: none;'>"; #open homeTab2
	
	$myEventsTable = "<table class='eventsTable'>";
	
	$myEventsRows = "<tr><td><div class='headerRow'><h5>Pick Ups and Drop Offs</h5></div></td></tr>";
	
	$myEventsRows .= $gremlin->buildPickupDropoffRows($user->ID, $user->teamID, $unixTime, true);
	
	$myEventsRows .= "<tr><td><div class='headerRow'><h5>Cases</h5></div></td></tr>";
	
	$myEventsRows .= $gremlin->buildCaseEventsRows($user->ID, $user->teamID, $unixTime, true);
	
	$myEventsTable .= $myEventsRows;
	
	$myEventsTable .= "</table>";
	
	$tab2 .= $myEventsTable;
	
	$tab2 .= "</div>"; #close homeTab2
	
	#assemble col1 - Event List
	$col1 .= $tab1 . $tab2;
	
	$col1 .= "</div>"; #close homeCol1
	
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
	
	
	
	
	#assemble and print page
	$page .= $script . $colTabRow . $dateMenuBar . $filtersBox . $col1 . $col2;
	
	$page .= $gremlin->buildFooter();
	
	
	echo $page;

	
	
?>