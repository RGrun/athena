
//Javascript for Home page
//I'm going to do my best to keep this organized

//Home page functions
	//tab 1 toggle
	function tab1Toggle() {
		$('#homeTab2').hide('fast');
		$('#homeTab1').show('fast');
		
		$("#tab1Button").removeClass("tabUnselected");
		$("#tab1Button").addClass("tabSelected");
		
		$('#tab2Button').removeClass("tabSelected");
		$("#tab2Button").addClass("tabUnselected");
	}
	
	function tab2Toggle() {
		$('#homeTab1').hide('fast');
		$('#homeTab2').show('fast');
		
		$("#tab2Button").removeClass("tabUnselected");
		$("#tab2Button").addClass("tabSelected");
		
		$('#tab1Button').removeClass("tabSelected");
		$("#tab1Button").addClass("tabUnselected");
	}
	
	function toggleFilters() {
		$('.filtersBox').toggle('fast');
		
		if($('#showFiltersButton').hasClass('unselected')) {
			$('#showFiltersButton').removeClass('unselected').addClass('selected');
		} else {
			$('#showFiltersButton').removeClass('selected');
			$('#showFiltersButton').addClass('unselected');
		}
	}
	
	function filterAssignments() {
		//pending or complete?
		var selectValue = $("#assignmentStatusSelect").val();
		
		if(selectValue == "pending") {
		
			$("div").each(function(index) {
				if($(this).hasClass("normalRow") && $(this).hasClass("complete")) {
					$(this).hide();
				}
				if($(this).hasClass("normalRow") && $(this).hasClass("pending")) {
					$(this).show();
				}
				
			});
		}
		
		if(selectValue == "complete") {
		
			$("div").each(function(index) {
				if($(this).hasClass("normalRow") && $(this).hasClass("pending")) {
					$(this).hide();
				}
				if($(this).hasClass("normalRow") && $(this).hasClass("complete")) {
					$(this).show();
				}
			
			});
		}
		
		if(selectValue == "none") {
			
			$("div").each(function(index) {
				if($(this).hasClass("normalRow")) {
					$(this).show();
				}
			
			});
		
		}
	
	}
	
	function filterUsers() {
	
		if($("#repFilterSelect").val() == "none") {
			var selectValue = "none";
		} else {
			var selectValue = parseInt($("#repFilterSelect").val());
		}
		
		$("div").each(function(index) {
			if($(this).hasClass("normalRow") && $(this).attr("data-user") != undefined && selectValue == "none") {
				$(this).show();
			
			} else {
			
			 if($(this).hasClass("normalRow") && $(this).attr("data-user") != undefined) {
				var data = parseInt($(this).attr("data-user"));
				if(data == selectValue) {
					$(this).show();
				}
			}
		
			 if($(this).hasClass("normalRow") && $(this).attr("data-user") != undefined) {
				var data = parseInt($(this).attr("data-user"));
				if(data == selectValue) {
					$(this).show();
				}
			}
			 if($(this).hasClass("normalRow") && $(this).attr("data-user") != undefined) {
				var data = parseInt($(this).attr("data-user"));
				
				if(data != selectValue) {
					$(this).hide();
				}
				
			}
		}
		
		});
	
	
	}
	
