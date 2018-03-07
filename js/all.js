$( window ).load( function() {

	var common = {
		sendPost: function( request ) {
			console.info( '-- sendPost' );

			var data = $( 'textarea' ).val();
			var options = new OPTIONS( request );
			options.setURL( "utils/encrypt.php" );
			options.setData( data );
			
			var posting = $.post( options.getURL(), options );

			posting.done(function( data ) {
				list = new LIST( data );
				$('#result').html( list.getData() );
				console.log( data );
			});
		},
		
		encrypt: function() {
			this.sendPost( "encryptMsg" );
		},
		
		decrypt: function() {
			this.sendPost( "decryptMsg" );
		},
	
	};
	
	$( '#encrypt' ).click(function() {
		common.encrypt();
	});
	
	$( '#decrypt' ).click(function() {
		common.decrypt();
	});
});