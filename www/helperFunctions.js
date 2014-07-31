
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
		
	//	O('js2').innerHTML = selections.toString();
		
		
		//filter all/open/loaned/scheduled trays
		if(currentValue == 'all') showAllElements();
		else if(currentValue == 'open') showOpenElements();
		else if(currentValue == 'loaned') showLoanedElements();
		else if(currentValue == 'scheduled') showScheduledElements();	
		else if(currentValue == 'cases') showCaseElements();
		//filter site trays
		else if(currentValue.search("_class")) showSiteElement(label);
		
		
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
	
	function showSiteElement(label) {
	
		showAllElements();
	
		var siteLabel = label + "_class";
		
		var divs = document.getElementsByTagName("DIV");
		
		for(x = 0; x < divs.length; x++) {
			if(divs[x].className == siteLabel) continue;
			if(divs[x].className == 'sitesTray') continue;
			if((divs[x].className == 'header') 
			|| (divs[x].className == 'main') 
			|| (divs[x].className == 'headernav')
			|| (divs[x].className == 'filterform' )
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
	
	function showOpenElements() {
		
		showAllElements();
		
		//get am array of all divs in the page
		var divs = document.getElementsByTagName("DIV");
		
		for(x = 0; x < divs.length; x++) {
			if(divs[x].className == 'openelement') continue;
			if(divs[x].className == 'openTray') continue;
			if((divs[x].className == 'header') 
			|| (divs[x].className == 'main') 
			|| (divs[x].className == 'headernav')
			|| (divs[x].className == 'filterform' )
			|| (divs[x].className == 'landingview')
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
			
			
			