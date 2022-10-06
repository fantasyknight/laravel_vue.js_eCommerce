// Portlets
(function($) {

	'use strict';

	if ( typeof NProgress !== 'undefined' && $.isFunction( NProgress.configure ) ) {

		NProgress.configure({
			showSpinner: false,
			ease: 'ease',
			speed: 750
		});

	}

}).apply(this, [jQuery]);