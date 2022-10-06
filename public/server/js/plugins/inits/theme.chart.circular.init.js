// Chart Circular
(function($) {

	'use strict';

	if ( $.isFunction($.fn[ 'easyPieChart' ]) ) {

		$(function() {
			$('[data-plugin-chart-circular], .circular-bar-chart:not(.manual)').each(function() {
				var $this = $( this ),
					opts = {};

				var pluginOptions = $this.data('plugin-options');
				if (pluginOptions)
					opts = pluginOptions;

				$this.themePluginChartCircular(opts);
			});
		});

	}

}).apply(this, [jQuery]);