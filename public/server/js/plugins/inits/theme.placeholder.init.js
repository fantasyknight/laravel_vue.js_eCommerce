(function($) {

	'use strict';

	if ( $.isFunction( $.fn[ 'placeholder' ]) ) {

		$('input[placeholder]').placeholder();

	}

}).apply(this, [jQuery]);
