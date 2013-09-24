	
	// Función que retorna las variables de la URL 
	function rutinagetUrlVars() {
		  var vars = {};
		  var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			  vars[key] = value;
		  });
		  return vars;
     }
