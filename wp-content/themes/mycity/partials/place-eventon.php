<div class='eventon_container'>	
    <?php 	
	$mycity_args = array(
        'show_et_ft_img'           => 'yes',
        'event_count'           => 4,
        'ft_event_priority'         => 'yes',
        'hide_past'      => 'no',
        'show_limit' => 'yes',
		
	);
	if( function_exists('add_eventon')) {
			add_eventon($mycity_args); 
	}
    ?>
    
    

</div>