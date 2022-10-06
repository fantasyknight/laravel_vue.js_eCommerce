// SummerNote
(function($) {

	'use strict';

	if ( $.isFunction($.fn[ 'summernote' ]) ) {

		$(function() {
			$('[data-plugin-summernote]').each(function() {
				var $this = $( this ),
					opts = {};

				var pluginOptions = $this.data('plugin-options');
				if (pluginOptions)
					opts = pluginOptions;

				$this.themePluginSummerNote(opts);
			});
		});

	}

}).apply(this, [jQuery]);