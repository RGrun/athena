
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
		
		var elements = document.getElementsByTagName('*');
		var objects = [];
		
		for(var i = 0; i < elements.length; ++i) {
			if(elements[i].className == name) {
				objects.push(elements[i]);
			}
		}
		
		return objects;
	}