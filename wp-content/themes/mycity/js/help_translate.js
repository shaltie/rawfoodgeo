jQuery(document).ready(function() {
	
	   "use strict";
	    var c_original; 
		jQuery('.edited').on('click', function(e) {
	        jQuery(this).attr('contentEditable', true);
			
			
			if (jQuery(this).attr("data-original") !== undefined) {
				c_original = jQuery(this).attr("data-original");
			} else {
				c_original = jQuery(this).html();
			}
			//alert(original);
			if(jQuery(this)[0].tagName=="A"){ 
				if (confirm("Edit?")) {e.preventDefault();} else {
					window.location=jQuery(this).prop("href");
				}
			}
			
			if(jQuery(this)[0].tagName=="BUTTON"){ 
				if (confirm("Edit?")) {
				 e.preventDefault();
				 event.returnValue = false;
			     event.cancelBubble = true;
				} else {
					//window.location=jQuery(this).prop("href");
				}
			}
	    });
		
	    jQuery('body').on('focus', '[contenteditable]', function() {
	        var $this = jQuery(this);
	        $this.data('before', $this.html());
	        return $this;
	    }).on('blur keyup paste input', '[contenteditable]', function() {
	        var $this = jQuery(this);
	        if ($this.data('before') !== $this.html()) {
	            $this.data('before', $this.html());
	            $this.trigger('change');
	        }
	        return $this;
	    });
		
		
	    jQuery(".edited").on("keydown", function(event) {	
			if(event.keyCode==13) { 
				jQuery.post("http://freelance.vioo.ru/edit_translate.php?editmain=1", {
					option: jQuery(this).attr("id"),
					val: jQuery(this).html(),
					lang: getCookie("lang"),
					original: c_original,
					page: window.location.href
				}, function(d) { 
					alert("Thank you for submitting recommendations for <"+getCookie("lang")+">!");		
				});
				event.stopPropagation();
				  event.preventDefault();  
				  event.returnValue = false;
				  event.cancelBubble = true;
				  return false;
			}
	        
	    });
	});