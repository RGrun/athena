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
	
	$page .= $gremlin->buildMenu("$user->uname" . "'s Home");
	
	
	#build colTabRow
	
	$colTabRow = "<div class='colTabRow'>"; #open colTabRow
	
	########START DUMMY
	
	$dmyTabRow = "<div class='tabRowHeader'><h3>Calendar</h3></div>"; #dmyTabRow
	
	$dmyTabRow .= "<div id='tab1Button' class='selected'>All Events</div><div id='tab2Button' class='unselected'>My Events</div>";
	
	$dmyTabRow .= "</div>"; #end dmyTabRow
	
	$colTabRow .= $dmyTabRow;
	
	########END DUMMY	
	
	//$colTabRow .= "</div>"; #close colTabRow
	
	#menu bar with date selection stuff
	
	$dateMenuBar = "<div class='dateMenuBar'>"; #open dateMenuBar
	
	########START DUMMY
	
	$dmyTodayButton = "<div id='todayButton' class='selected'><small>Today</small></div>";

	$dmyArrowButtonsBox = "<div id='arrowButtonsBox'>";
	
	$dmyArrowButtonLeft = "<div class='unselected' id='arrowButtonLeft'>&lt;</div>";
	
	$dmyArrowButtonRight = "<div class='unselected' id='arrowButtonRight'>&gt;</div>";
	
	$dmyArrowButtonsBox .= $dmyArrowButtonLeft . $dmyArrowButtonRight;
	
	$dmyArrowButtonsBox .= "</div>";
	
	$dmyDateBox = "<div id='dateBox' class='unselected'>";
	
	
	$dmyCalDate = "<div id='calDate'><small>Today</small><br/><h3>Tuesday, March 24</h3></div>";
	
	$dmyDateBox .= $dmyCalDate;
	
	$dmyDateBox .= "</div>";
	
	$dmyCalListBox = "<div id='calListBox'>";
	
	$dmyCalButton = "<div class='selected' id='calButton'><small>[Cal]</small></div>";
	
	$dmyListButton = "<div class='unselected' id='listButton'><small>[List]</small></div>";
	
	$dmyCalListBox .= $dmyCalButton . $dmyListButton;
	
	$dmyCalListBox .= "</div>";
	
	$showFiltersButton = "<div class='unselected' id='showFiltersButton'>Show Filters</div>";
	
	$dateMenuBar .= $dmyTodayButton . $dmyArrowButtonsBox .
	$dmyDateBox . $dmyCalListBox . $showFiltersButton;
	
	########END DUMMY
	
	$dateMenuBar .= "</div>"; #close dateMenuBar
	
	
	#Col 1 - Event List
	$col1 = "<div id='homeCol1'>"; #open homeCol1
	#there's two tabs in col1
	
	#tab 1 - All Events
	$tab1 = "<div id='homeTab1'>"; #open homeTab1
	
	########START DUMMY
	
	$dmyAllEventsTable = "<table class='eventsTable'>";
	
	$dmyAllEventsRows = "<tr><td><div class='headerRow'><h5>Anytime Events</h5></div></td></tr>";
	
	$dmyAllEventsRows .= "<tr><td>" .
	"<div class='normalRow'><div class='rowBox'><span>Drop</span><span><br/> Off</span></div>" .
	"<div class='rowText'>Drop off <a href='#'>Foot Surgery Tray</a> at <a href='#'>Mercy Hospital</a> for foot surgery w/ Dr. Bill</div>" .
	"<div class='rowSelect'><select><option>Unassigned</option><option>Russell Wilson</option><option>Marshawn Lynch</option></select></div>" .
	"</div></td></tr>";
	
	$dmyAllEventsRows .= "<tr><td>" .
	"<div class='normalRowAlternate'><div class='rowBox'><span>Drop</span><span><br/> Off</span></div>" .
	"<div class='rowText'>Drop off <a href='#'>Brain Surgery Tray</a> at <a href='#'>Mercy Hospital</a> for brain surgery w/ Dr. Bob</div>" .
	"<div class='rowSelect'><select><option>Unassigned</option><option>Russell Wilson</option><option>Marshawn Lynch</option></select></div>" .
	"</div></td></tr>";
	
	$dmyAllEventsRows .= "<tr><td>" .
	"<div class='normalRow'><div class='rowBox'><span>Pick</span><span><br/> Up</span></div>" .
	"<div class='rowText'>Pick up <a href='#'>Shoulder Surgery Tray</a>, <a href='#'>FlipCutter1</a> at <a href='#'>Interfaith Hospital</a></div>" .
	"<div class='rowSelect'><select><option>Unassigned</option><option>Russell Wilson</option><option>Marshawn Lynch</option></select></div>" .
	"</div></td></tr>";
	
	$dmyAllEventsRows .= "<tr><td>" .
	"<div class='normalRowAlternate'><div class='rowBox'><span>Pick</span><span><br/> Up</span></div>" .
	"<div class='rowText'>Pick up <a href='#'>Brain Surgery Tray</a>, <a href='#'>FlipCutter2</a> at <a href='#'>Mercy Hospital</a></div>" .
	"<div class='rowSelect'><select><option>Unassigned</option><option>Russell Wilson</option><option>Marshawn Lynch</option></select></div>" .
	"</div></td></tr>";
	
	$dmyAllEventsRows .= "<tr><td><div class='headerRow'><h5>Scheduled Events</h5></div></td></tr>";
	
	$dmyAllEventsRows .= "<tr><td>" .
	"<div class='normalRow'><div class='rowCircle'><h3>9am</h3></div>" .
	"<div class='rowTextScheduled'>Tib. Ostiotomy at St. Joseph’s Paterson w/ Dr. Longobardi</div>" .
	"<div class='traysNeeded'><select><option>Transtibila ACL 4</option><option>Master Graft 1</option> <option>Graft Bolt 2</option></select></div>" .
	"<div class='rowSelectAlternate'><select><option>Unassigned</option><option>Russell Wilson</option><option>Marshawn Lynch</option></select></div>" .
	"</div></td></tr>";
	
	$dmyAllEventsRows .= "<tr><td>" .
	"<div class='normalRowAlternate'><div class='rowCircle'><h3>9am</h3></div>" .
	"<div class='rowTextScheduled'>Distal Biceps at Ramapo Valley w/ Dr. Pflum</div>" .
	"<div class='traysNeeded'><select><option>Transtibila ACL 4</option><option>Master Graft 1</option> <option>Graft Bolt 2</option></select><select><option>Transtibila ACL 4</option><option>Master Graft 1</option> <option>Graft Bolt 2</option></select></div>" .
	"<div class='rowSelectAlternate'><select><option>Unassigned</option><option>Russell Wilson</option><option>Marshawn Lynch</option></select></div>" .
	"</div></td></tr>";
	
	$dmyAllEventsRows .= "<tr><td>" .
	"<div class='normalRow'><div class='rowCircle'><h3>10am</h3></div>" .
	"<div class='trayNotOnSite'><small>Tray not on site!</small></div>" .
	"<div class='rowTextScheduled'>[Procedure Name] at Hospital Name w/ [Doctor Name]</div>" .
	"<div class='traysNeeded'><select><option>Transtibila ACL 4</option><option>Master Graft 1</option> <option>Graft Bolt 2</option></select><select><option>Transtibila ACL 4</option><option>Master Graft 1</option> <option>Graft Bolt 2</option></select></div>" .
	"<div class='rowSelectAlternate'><select><option>Unassigned</option><option>Russell Wilson</option><option>Marshawn Lynch</option></select></div>" .
	"</div></td></tr>";
	
	$dmyAllEventsRows .= "<tr><td>" .
	"<div class='normalRowAlternate'><div class='rowCircle'><h3>10am</h3></div>" .
	"<div class='rowTextScheduled'>[Procedure Name] at Hospital Name w/ [Doctor Name]</div>" .
	"<div class='traysNeeded'><select><option>Transtibila ACL 4</option><option>Master Graft 1</option> <option>Graft Bolt 2</option></select><select><option>Transtibila ACL 4</option><option>Master Graft 1</option> <option>Graft Bolt 2</option></select><select><option>Transtibila ACL 4</option><option>Master Graft 1</option> <option>Graft Bolt 2</option></select></div>" .
	"<div class='rowSelectAlternate'><select><option>Unassigned</option><option>Russell Wilson</option><option>Marshawn Lynch</option></select></div>" .
	"</div></td></tr>";	
	
	$dmyAllEventsTable .= $dmyAllEventsRows;
	
	$dmyAllEventsTable .= "</table>";
	
	$tab1 .= $dmyAllEventsTable;
	
	########END DUMMY
	
	$tab1 .= "</div>"; #close homeTab1
	
	#tab 2 - My Events
	$tab2 = "<div id='homeTab2'>"; #open homeTab2
	
	
	
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
	$page .= $colTabRow . $dateMenuBar . $col1 . $col2;
	
	$page .= $gremlin->buildFooter();
	
	
	echo $page;

	
	
?>