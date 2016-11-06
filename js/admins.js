"use strict";
	jQuery(document).ready(function() {
	   "use strict";
	    jQuery('.edited').on('click', function() {
	        jQuery(this).attr('contentEditable', true);
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
	    jQuery(".edited").on("change", function() {	
	        jQuery.post(pluginsUrl + "/GeoCity/ajax.php?editmain=1", {
	            option: jQuery(this).attr("id"),
	            val: jQuery(this).html()
	        }, function(d) { 
				//alert(d);		
	        });
	    });
	});

jQuery(document).ready(function() {
	if (jQuery('a').is('.evcal_db_ui_1') == true) {
		jQuery('.evcal_db_ui_1').hide();
		jQuery('.evcal_db_ui_2').hide();
		setTimeout(function(){
			jQuery('.evcal_db_ui_3').click();
		}, 3000);

	}
});