// Popover
(function($) {

	'use strict';

	if ( $.isFunction( $.fn['popover'] ) ) {
		$( '[data-toggle=popover]' ).popover();
	}

}).apply(this, [jQuery]);