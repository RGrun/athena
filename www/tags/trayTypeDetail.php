<?php

	//trayTypeDetail.php
	//this is where you add tags to tray types
	
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$ttyp_id = $_GET['ttyp_id'];
	
	$userCompanies = $_SESSION['userCompanies'];
	
	
	//print tray type detail data
	
	echo "<div class='adminTable'>"; //open admintable
	
	$sql = "SELECT * FROM ttyp WHERE ttyp_id='$ttyp_id'";
	//echo $sql;
	
	$result = $worker->query($sql);
	
	$row = mysqli_fetch_assoc($result);
	
	$name = $row['name'];
	$cmp_id = $row['cmp_id'];
	$team_id = $row['team_id'];
	
	$company = $worker->findCompany($cmp_id, "name");
	$team = $worker->findTeam($team_id, "name");
	
	if($company == null) $company = "Global";
	if($team == null) $team = "None";
	
	echo "<h2>Detail for $name </h2>";
	
	$ttypTable = "<table>" .
	"<tr><td><em>Tray Type ID: </em></td><td>$ttyp_id</td></tr>" .
	"<tr><td><em>Name: </em></td><td>$name</td><td><a href='editTrayTypeInfo.php?mtd=name'>Edit</a></td></tr>" .
	"<tr><td><em>Company: </em></td><td>$company</td><td><a href='editTrayTypeInfo.php?mtd=company'>Edit</a></td></tr>" .
	"<tr><td><em>Team: </em></td><td>$team</td><td><a href='editTrayTypeInfo.php?mtd=team'>Edit</a></td></tr>" .
	"</table>";
	
	echo $ttypTable;
	
	echo "</div>"; //close admintable
	
	echo "<div class='landingview'>"; //open landingview
	
	//display tags here
	
	$tagSql = "SELECT tag FROM ttyp_tag WHERE ttyp_id='$ttyp_id'";
	//echo $tagSql;
	$tagResult = $worker->query($tagSql);
	$tagTable = "<div class='tagTable'>"; //open tagTable
	$tagTable .= "<div class='tagsView'>"; //open tagsView
	$tagTable .= "<h2>Tags attached to this tray type: </h2><br/>";
		
	while ($tagRow = mysqli_fetch_array($tagResult)) {
		
		$tagName = $tagRow[0];
		$tagTable .= "<div class='tag'>";
		$tagTable .= "<div class='tagName'>$tagName</div><div class='tagX'><a href='/athena/www/tags/deleteTrayTypeTags.php?del=1&ttyp_id=$ttyp_id&tag=$tagName'><img src='/athena/www/utils/images/blackX.png' height='16' width='16' /></a></div></div>";
		
		
	}
		
	$tagTable .= "</div>"; //close tagsView
	
	//add tags form
	$tagSql = "SELECT tag, cmp_id FROM tags";
	$tagResult = $worker->query($tagSql);
		
	$tagSelector = "<select name='newTag' size='1'>";
	while($tagRow = mysqli_fetch_array($tagResult)) {

		if(in_array($tagRow[1], $userCompanies) || $tagRow[1] == "0")
			$tagSelector .= "<option value='$tagRow[0]'>$tagRow[0]</option>";

	}
		
	$tagSelector .= "</select>";
		
	$tagTable .= "<p>Select new tags: </p>";
		
	$tagForm = "<form method='post' action='/athena/www/tags/addTrayTypeTags.php'>$tagSelector <br/> <input type='submit' value='Add Tag' /><input type='hidden' name='ttyp_id' value='$ttyp_id' /></form>";
		
		
	$tagTable .= $tagForm;
		
	$tagTable .= "</div>"; //close tagTable
		
	echo $tagTable;
	
	$_SESSION['currentTTYP'] = $ttyp_id;
	
	
	
	echo "</div>"; //close landingview
	$htmlUtils->makeFooter();
?>