// Mailbox
(function($) {

	'use strict';

	$(function() {
		$('[data-mailbox]').each(function() {
			var $this = $( this );

			$this.themeMailbox();
		});
	});

}).apply(this, [jQuery]);