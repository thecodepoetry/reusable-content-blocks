jQuery( document ).ready( function ( $ ) {
								
	$( document ).on( 'change', '.reusecb_data_source', function() {																	
		if ( $( this ).val() == 'db_other' ) {
			$( '.dynamic_block' ).hide();
			$( '.db_other' ).show();
			$( '.reusecb_other_id' ).focus();			
		} else {
			$( '.dynamic_block' ).show();
			$( '.db_other' ).hide();
		}
	});
	
	$( document ).on( 'widget-updated', function () {
		$( '.reusecb_data_source' ).change();
	})
	
	$( '.reusecb_data_source' ).change();
	
});
