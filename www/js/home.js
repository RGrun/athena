
//Javascript for Home page
//I'm going to do my best to keep this organized

//Home page functions
	//tab 1 toggle
	function tab1Toggle() {
		$('#homeTab2').hide('fast');
		$('#homeTab1').show('fast');
		
		$("#tab1Button").removeClass("unselected");
		$("#tab1Button").addClass("selected");
		
		$('#tab2Button').removeClass("selected");
		$("#tab2Button").addClass("unselected");
	}
	
	function tab2Toggle() {
		$('#homeTab1').hide('fast');
		$('#homeTab2').show('fast');
		
		$("#tab2Button").removeClass("unselected");
		$("#tab2Button").addClass("selected");
		
		$('#tab1Button').removeClass("selected");
		$("#tab1Button").addClass("unselected");
	}
