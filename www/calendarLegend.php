<?php
	
	//calendarLegend.php
	//this page is a legend for the calendar page
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	echo "<p>This page explains the calendar's various symbols.</p>";
	
	$PUDOTable = "<table><tr><th>Symbol</th><th>Meaning</th></tr>" .
	"<tr><td><img src='/athena/www/utils/images/downarrow.png' width='40' height='40' /></td><td>Dropoff</td></tr>" .
	"<tr><td><img src='/athena/www/utils/images/uparrow.png' width='40' height='40' /></td><td>Pickup</td></tr></table>";
	
	$dotsTable = "<table><tr><th>Symbol</th><th>Meaning</th></tr>" .
	"<tr><td><img src='/athena/www/utils/images/openCircle.png' height='18' width='18' /></td><td>Incomplete Assignment</td></tr>" .
	"<tr><td><img src='/athena/www/utils/images/closedCircle.png' height='18' width='18' /></td><td>Complete Assignment</td></tr>" .
	"<tr><td><img src='/athena/www/utils/images/check.png' height='40' width='40' /></td><td>All Assignments Complete</td></table>";
	
	
	$legend = "<div class='calendarLegend'>$PUDOTable $dotsTable </div>";
	
	echo $legend;
	
	
	$htmlUtils->makeFooter();
	
?>