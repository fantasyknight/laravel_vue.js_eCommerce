// Carousel
(function($) {

	'use strict';

	if ( $.isFunction($.fn[ 'owlCarousel' ]) ) {

		$(function() {
			$('[data-plugin-carousel]').each(function() {
				var $this = $( this ),
					opts = {};

				var pluginOptions = $this.data('plugin-options');
				if (pluginOptions)
					opts = pluginOptions;

				$this.themePluginCarousel(opts);
			});
		});

	}

}).apply(this, [jQuery]);