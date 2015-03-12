<?php

	#home.php
	#this is the main screen for logged-in users
	#includes calendar screen and notifications, colTabRow, 2 tabs, 2 col[3:1] 
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
	
	
	
	$colTabRow .= "</div>"; #close colTabRow
	
	#Col 1 - Event List
	$col1 = "<div id='homeCol1'>"; #open homeCol1
	#there's two tabs in col1
	
	#tab 1 - All Events
	$tab1 = "<div id='homeTab1'>"; #open homeTab1
	
	
	
	$tab1 .= "</div>"; #close homeTab1
	
	#tab 2 - My Events
	$tab2 = "<div id='homeTab2'>"; #open homeTab2
	
	
	
	$tab2 .= "</div>"; #close homeTab2
	
	#assemble col2 - Notifications
	$col1 .= $tab1 . $tab2;
	
	$col1 .= "</div>"; #close homeCol1
	
	#Col 2
	$col2 = "<div id='homeCol2'>"; #open homeCol2
	
	
	
	$col2 .= "</div>"; #close homeCol2
	
	
	
	
	#assemble and print page
	$page .= $colTabRow . $col1 . $col2;
	
	$page .= $gremlin->buildFooter();
	
	
	echo $page;

	
	
?>