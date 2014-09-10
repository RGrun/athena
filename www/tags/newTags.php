<?php

	//newTags.php
	//this page is where users can create new tags that they can add to trays
	
	require_once "includes.php";
	
	$htmlUtils = new htmlUtils();
	$worker = new dbWorker();
	
	$htmlUtils->makeHeader();
	
	$userId = $_SESSION['userId'];
	$isAdmin = $_SESSION['isAdmin'];
	
	$usersCompanies = $_SESSION['userCompanies']; //could be zero if no company is assigned (will display global tags only)
	
	//mechanism for adding new tags
	if(isset($_POST['creation'])) {
	
		$tag = $_POST['newTag'];
		if(isset($_POST['newCompany'])) $company = $_POST['newCompany'];
		else $company = 0;
		$sql = "INSERT INTO tags (tag, cmp_id) VALUES ('$tag', '$company')";
		//echo $sql;
		
		if(isset($_POST['isGlobal'])) {
			$company = 0;
			$sql = "INSERT INTO tags (tag, cmp_id) VALUES ('$tag', '0')";
		}
		
		$worker->query($sql);
	}
	
	
	echo "<div class='landingview'>"; //open landingview
	
	
	echo "<h2>Create/Remove Tags</h2>";
	
	$tagCreator = "<div class='tagCreator'>";
	
	$tagCreator .= "<h3>Enter New Tag: </h3><br/>";
	$tagCreator .= "<form method='post' name='frm' action='newTags.php'>";
	$tagCreator .= "<input type='hidden' name='creation' value='1' />" .
	"<input type='text' name='newTag' size='30' /><br/>";
	
	if($isAdmin) $tagCreator .= "<label>Global Tag<input type='checkbox' name='isGlobal' value='1' onchange='disableSelect()' /></label><br/>";
	
	//print_r($usersCompanies);
	
	//create company selectors
	if(is_array($usersCompanies)) {
		$companySelector = "<select name='newCompany' size='1'>";
		for($i = 0; $i < count($usersCompanies); $i++) {
			$companyName = $worker->findCompany($usersCompanies[$i], "name");
			$companySelector .= "<option value='$usersCompanies[$i]'>$companyName</option>";
		}
		$companySelector .= "</select>";
		$tagCreator .= "Tag belongs to: $companySelector <br/>";
		
	}
	

	$tagCreator .= "<input type='submit' value='Create Tag' /> </form> </div>";
	
	echo $tagCreator;
	
	//display already-created tags
	echo "<div class='tagTable'>"; //open tagTable
	
	//$sql = "SELECT * FROM tags ORDER BY cmp_id ASC";
	//echo $sql;
	$tagTable = "";
	
	//$result = $worker->query($sql);
	
	$alreadyPrintedCompanies = array();
	
	//triggers if user belongs to no companies, only prints global tags
	if(!is_array($usersCompanies)) {
		$tagTable .= "<div class='tagsView'>"; //open tagsView
		$tagTable .= "<h2>Global Tags: </h2><br/>";
		

		while($row = mysqli_fetch_assoc($result)) {
			$tagName = $row['tag'];
		
			$tagTable .= "<div class='tag'>";
			$tagTable .= "<div class='tagX'><a href='deleteTags.php?del=1&cmp_id=$current&tag=$tagName'><img src='/athena/www/utils/images/blackX.png' height='16' width='16' /></a></div></div>";
		
		
		}
		$tagTable .= "</div>"; //close tagsView
		//$tagTable .= "<div class='divider'></div>";
	}
	
	if(is_array($usersCompanies)) {
		//figure out how many company's tags will be printed
		$sql2 = "SELECT cmp_id FROM tags ORDER BY cmp_id ASC";
		$result2 = $worker->query($sql2);
		$totalCompanies = array(0);
		$noOfCompanies = 1;
		while($row2 = mysqli_fetch_array($result2)) {
			if(!in_array($row2[0], $totalCompanies )) {
				array_push($totalCompanies, $row2[0]);
				$noOfCompanies++;
			}
		}

		
		//while($row = mysqli_fetch_assoc($result)) {
		
			//$currentCmp = $row['cmp_id'];
			
			//only print company tags for companies user is part of
			//admins can see all tags
			
			foreach($totalCompanies as $current) {
				if($current == 0) {
					//global tags
					
					$tagTable .= "<div class='tagsView'>"; //open tagsView
					$tagTable .= "<h2>Global Tags: </h2><br/>";
					
					$tagNameSql = "SELECT tag FROM tags WHERE cmp_id='$current'";
					$resultNameSql = $worker->query($tagNameSql);
					
					while($rowNameSql = mysqli_fetch_array($resultNameSql)) {
						$tagName = $rowNameSql[0];
						$tagTable .= "<div class='tag'>";
						$tagTable .= "<div class='tagName'>$tagName</div><div class='tagX'><a href='deleteTags.php?del=1&cmp_id=$current&tag=$tagName'><img src='/athena/www/utils/images/blackX.png' height='16' width='16' /></a></div></div>";
					}
					$tagTable .= "</div>"; //close tagsView
					//$tagTable .= "<div class='divider'></div>";
				} else if(in_array($current, $usersCompanies) && !in_array($current, $alreadyPrintedCompanies)) {
					//company tags
					$companyName = $worker->findCompany($current, "name");
					
					$tagTable .= "<div class='tagsView'>"; //open tagsView
					
					$tagTable .= "<h2>$companyName" . "'s Tags: </h2><br/>";
					
					$tagNameSql = "SELECT tag FROM tags WHERE cmp_id='$current'";
					$resultNameSql = $worker->query($tagNameSql);
				
					while($rowNameSql = mysqli_fetch_array($resultNameSql)) {
						$tagName = $rowNameSql[0];
						$tagTable .= "<div class='tag'>";
						$tagTable .= "<div class='tagName'>$tagName</div><div class='tagX'><a href='deleteTags.php?del=1&cmp_id=$current&tag=$tagName'><img src='/athena/www/utils/images/blackX.png' height='16' width='16' /></a></div></div>";
					}
					$tagTable .= "</div>"; //close tagsView
					array_push($alreadyPrintedCompanies, $current);
				
				}
			
			
			
			}
			
		
		
		//}
	
	}
	$tagTable .= "</div>"; //end tagTable
	
	echo $tagTable;
	
	
	

	echo "</div>"; //end landingview
	
	$htmlUtils->makeFooter();
	
?>	