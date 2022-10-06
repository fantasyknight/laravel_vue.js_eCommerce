// Sidebar Widgets
(function($) {

	'use strict';

	function expand( content ) {
		content.children( '.widget-content' ).slideDown( 'fast', function() {
			$(this).css( 'display', '' );
			content.removeClass( 'widget-collapsed' );
		});
	}

	function collapse( content ) {
		content.children('.widget-content' ).slideUp( 'fast', function() {
			content.addClass( 'widget-collapsed' );
			$(this).css( 'display', '' );
		});
	}

	var $widgets = $( '.sidebar-widget' );

	$widgets.each( function() {

		var $widget = $( this ),
			$toggler = $widget.find( '.widget-toggle' );

		$toggler.on('click.widget-toggler', function() {
			$widget.hasClass('widget-collapsed') ? expand($widget) : collapse($widget);
		});
	});

}).apply(this, [jQuery]);