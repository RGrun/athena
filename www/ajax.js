
//ajax.js
//functions relating to ajax


//this function creates the ajax object
function ajaxRequest() {
	try { //non-IE browser?
		var request = new XMLHttpRequest();
	} catch (e1) {
		try { //IE 6+?
			request = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e2) { //no Ajax support
			request = false;
		}
	}
	return request;
}