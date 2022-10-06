// Word Rotator
(function($) {

	'use strict';

	if ( $.isFunction($.fn[ 'themePluginWordRotator' ]) ) {

		$(function() {
			$('[data-plugin-wort-rotator], .wort-rotator:not(.manual)').each(function() {
				var $this = $( this ),
					opts = {};

				var pluginOptions = $this.data('plugin-options');
				if (pluginOptions)
					opts = pluginOptions;

				$this.themePluginWordRotator(opts);
			});
		});

	}

}).apply(this, [jQuery]);