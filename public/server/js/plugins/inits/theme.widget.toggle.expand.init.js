// Widget - Toggle
(function($) {

	'use strict';

	if ( $.isFunction($.fn[ 'themePluginWidgetToggleExpand' ]) ) {

		$(function() {
			$('[data-plugin-toggle-expand], .widget-toggle-expand').each(function() {
				var $this = $( this ),
					opts = {};

				var pluginOptions = $this.data('plugin-options');
				if (pluginOptions)
					opts = pluginOptions;

				$this.themePluginWidgetToggleExpand(opts);
			});
		});
	}

}).apply(this, [jQuery]);