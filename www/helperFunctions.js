
	//helperFunctions.js
	//These are javascript helper functions
	
	function O(obj) {
		//shortens object code
		if(typeof obj == 'object') return obj;
		else return document.getElementById(obj);
	}
	
	function S(obj) {
		//this function makes styling easier
		return O(obj).style;
	}
	
	function C(name) {
		
		//returns an arry of every element with class "name"
		
		var elements = document.getElementsByTagName("*");
		var objects = [];
		
		for(var i = 0; i < elements.length; ++i) {
			if(elements[i].className == name) {
				objects.push(elements[i]);
			}
		}
		
		return objects;
	}
	
	function test() {
		var x = O('js');
		x.innerHTML = "This works!";
	}
	
	function trayFilter() {
		//get current value of selected item in dropdown
		var selector = O('filterselect');
		var currentValue = selector.value;
		var label = O('filterselect')[O('filterselect').selectedIndex].innerHTML;
		//O('js').innerHTML = label; // for testing
		var selections = [];
		
		//create array of all values in filter select
		var totalValues = O('filterselect');
		for (var i = 0; i < totalValues.length; i++) {
		selections.push(totalValues.options[i].value);
		}
		
		//filter all/open/loaned/scheduled trays
		if(currentValue == 'all') showAllElements();
		//filter site trays
		else if(currentValue.search("_class")) showSiteElement(label);
		
		
	}
	
	function assignmentFilter() {
		//get current value of selected item in dropdown
		var selector = O('assignment');
		var currentValue = selector.value;

		var selections = [];
		
		//create array of all values in filter select
		var totalValues = O('assignment');
		for (var i = 0; i < totalValues.length; i++) {
		selections.push(totalValues.options[i].value);
		}
		
		//filter assignments
		if(currentValue.search("asgn")) showAssignment(currentValue);
		
		
	}
	
	function hideAllAssignments() {
		var divs = document.getElementsByTagName("DIV");
			for(y=0; y < divs.length; y++) {
				var CN = divs[y].className;
				if(CN.indexOf("assignment") > -1) S(divs[y]).display = 'none';
			}
	
	}
	
	function showAssignment(asgnId) {
		hideAllAssignments();
		var divs = document.getElementsByTagName("DIV");
		var target = asgnId;
		
		for(x=0; x < divs.length; x++) {
			if (divs[x].className == target) S(divs[x]).display = 'block';
		}
	}
	
	function showCaseElements() {
		
		showAllElements();
		
		//get am array of all divs in the page
		var divs = document.getElementsByTagName("DIV");
		
		for(x = 0; x < divs.length; x++) {
			if(divs[x].className == 'caseelement') continue;
			if(divs[x].className == 'caseTray') continue;
			if((divs[x].className == 'header') 
			|| (divs[x].className == 'main') 
			|| (divs[x].className == 'headernav')
			|| (divs[x].className == 'filterform' )
			|| (divs[x].className == 'landingview')
			|| (divs[x].className == 'footer')) continue;
			
			S(divs[x]).display = 'none';
		}
	}
	
	function expand(trayId) {
		
		var name = "Tray " + trayId + "_class";
		var tray = O(name);
		
		//does not currently work, should invert arrow when tray is selected
		var arrow = tray.getElementsByTagName('em');
		
		var expandedViewName = name + "_expanded";
		
		var expandedView = O(expandedViewName);
		
		if(S(expandedView).display == 'none') { S(expandedView).display = 'block'; arrow.innerHTML = "&#9650"; }
		else { S(expandedView).display = 'none'; arrow.innerHTML = "&#9660"; }
	
	}
	
	function showSiteElement(label) {
	
		showAllElements();
	
		var siteLabel = label + "_class";
		var siteLabelExpanded = label + "_class_expanded";
		
		var divs = document.getElementsByTagName("DIV");
		
		for(x = 0; x < divs.length; x++) {
			if(divs[x].id == siteLabel) continue;
			if(divs[x].id == siteLabelExpanded) continue;
			if(divs[x].className == 'sitesTray') continue;
			if((divs[x].className == 'dashboard') 
			|| (divs[x].className == 'main') 
			|| (divs[x].className == 'headernav')
			|| (divs[x].id == 'header' )
			|| (divs[x].className == 'pagetitle')
			|| (divs[x].className == 'filterform')
			|| (divs[x].className == 'wrapper')
			|| (divs[x].className == 'username')
			|| (divs[x].className == 'extras')
			|| (divs[x].className == 'landingview')
			|| (divs[x].className == 'footer')) continue;
			
			S(divs[x]).display = 'none';
		}
	} 
	
	function showAllElements() {
		
		var divs = document.getElementsByTagName("DIV");	
		
		for(x = 0; x < divs.length; x++) {
			S(divs[x]).display = 'block';
		}
	}
	
	function showReturnedElements() {
		
		showAllElements();
		
		//get am array of all divs in the page
		var divs = document.getElementsByTagName("DIV");
		
		for(x = 0; x < divs.length; x++) {
			if(divs[x].className == 'returnedelement') continue;
			if(divs[x].className == 'returnedTray') continue;
			if((divs[x].className == 'header') 
			|| (divs[x].className == 'main') 
			|| (divs[x].className == 'headernav')
			|| (divs[x].className == 'filterform' )
			|| (divs[x].className == 'landingview')
			|| (divs[x].className == 'wrapper')
			|| (divs[x].className == 'username')
			|| (divs[x].className == 'extras')
			|| (divs[x].className == 'footer')) continue;
			
			S(divs[x]).display = 'none';
		}
	}
	
	function showLoanedElements() {
		
		showAllElements();
		
		//get am array of all divs in the page
		var divs = document.getElementsByTagName("DIV");
		
		for(x = 0; x < divs.length; x++) {
			if(divs[x].className == 'loanedelement') continue;
			if(divs[x].className == 'loanedTray') continue;
			if((divs[x].className == 'header') 
			|| (divs[x].className == 'main') 
			|| (divs[x].className == 'headernav')
			|| (divs[x].className == 'filterform' )
			|| (divs[x].className == 'landingview')
			|| (divs[x].className == 'footer')) continue;
			
			S(divs[x]).display = 'none';
		}
	}		
			
			
	function showScheduledElements() {
	
		showAllElements();
		
		//get am array of all divs in the page
		var divs = document.getElementsByTagName("DIV");
		
		for(x = 0; x < divs.length; x++) {
			if(divs[x].className == 'scheduledelement') continue;
			if(divs[x].className == 'scheduledTray') continue;
			if((divs[x].className == 'header') 
			|| (divs[x].className == 'main') 
			|| (divs[x].className == 'headernav')
			|| (divs[x].className == 'filterform' )
			|| (divs[x].className == 'landingview')
			|| (divs[x].className == 'footer')) continue;
			
			S(divs[x]).display = 'none';
		}
	}		
			
	//used in viewTrayDetail page
	function showHide() {
	
		var tds = document.getElementsByTagName("TD");
		
		var currentValue = O('confirm').value;
		
		var button = O('proceedButton');
		
		if (currentValue == 'show') {
			for(x=0; x < tds.length; x++) {
				if(tds[x].className == 'mod') S(tds[x]).visibility = 'hidden';
				button.disabled = false;
			}
		}
		
		if (currentValue == 'hide') {
			for(x=0; x < tds.length; x++) {
				if(tds[x].className == 'mod') S(tds[x]).visibility = 'visible';
				button.disabled = true;
			}
		}
	}
	
	//used in signature page
	function signature() {
	
		var button = O('proceed');
		
		if(button.disabled == true) button.disabled = false;
		else button.disabled = true;
	
	}
	
	function formatTimeSelect() {
	
		//used on pages with dateTime selectors
		var d = new Date();
		var currentMonth = d.getMonth() + 1; 
		var currentYear = d.getFullYear();
		var currentDay = d.getDate();
		var currentHour = d.getHours();
		var currentMin = d.getMinutes();
		
		//check month
		for(x = 1; x <= 12; x++) {
			var thisValue = "mo" + x.toString();
			if(O(thisValue).value == currentMonth) O(thisValue).selected = true;
		}
		
		//check year
		for(x = 14; x <= 31; x++) {
			var thisValue = "y" + x.toString();
			if(O(thisValue).value == currentYear) O(thisValue).selected = true;
		}
		
		//check day
		for(x = 1; x <=31; x++) {
			var thisValue = "d" + x.toString();
			if(O(thisValue).value == currentDay) O(thisValue).selected = true;
		}
		
		//check hour
		for(x = 0; x <=23; x++) {
			var thisValue = "h" + x.toString();
			if(O(thisValue).value == currentHour) O(thisValue).selected = true;
		}
	
		//check minute
		for(x = 1; x <=59; x++) {
			var thisValue = "m" + x.toString();
			if(O(thisValue).value == currentMin) O(thisValue).selected = true;
		}
	}
			
			
			