// Toggle
(function($) {

	'use strict';

	$(function() {
		$('[data-plugin-toggle]').each(function() {
			var $this = $( this ),
				opts = {};

			var pluginOptions = $this.data('plugin-options');
			if (pluginOptions)
				opts = pluginOptions;

			$this.themePluginToggle(opts);
		});
	});

}).apply(this, [jQuery]);