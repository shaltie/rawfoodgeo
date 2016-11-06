"use strict";
jQuery(document).ready(
"use strict";
	function(){
	   "use strict";
		jQuery('#txtm').on('keyup', function(e) {
		
		if (e.which == 13 && ! e.shiftKey) {
			snd();
		}
	});
	rel();
});
$(document).ready(function(){
	// $(document).keypress(function(event){

	// 	var keycode = (event.keyCode ? event.keyCode : event.which);
	// 	if(keycode == '13'){
	// 		alert('You pressed a "enter" key in somewhere');	
	// 	}

	// });
	//alert('1');
});

					
function snd() {
    "use strict";
	jQuery.post(pluginsUrl+"/GeoCity/ajax.php?msg_send="+user2,{msg:jQuery("#txtm").val()},function(d){
		$("#msg23").html(d);
		var elem = document.getElementById('msg23');
		elem.scrollTop = elem.scrollHeight;
		rel();
	});
	jQuery("#txtm").val("");
}
function rel() {
    "use strict";
	//alert(1);
	jQuery.get(pluginsUrl+"/GeoCity/ajax.php?msg_get="+user2,function(d){
	$("#msg23").html(d);
	var elem = document.getElementById('msg23');
	elem.scrollTop = elem.scrollHeight;
	});
}
					
setInterval(function(){  rel(); }, 3000);