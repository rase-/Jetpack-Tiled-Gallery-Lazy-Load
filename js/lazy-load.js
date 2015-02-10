(function($) {
	lazy_load_init();
	$( 'body' ).bind( 'post-load', lazy_load_init ); // Work with WP.com infinite scroll

	function lazy_load_init() {
		$( 'img' ).show().lazyload( {
			threshold: 200,
			effect: 'fadeIn',
			data_attribute: 'lazy-src'
		} );
	}
})( jQuery );
