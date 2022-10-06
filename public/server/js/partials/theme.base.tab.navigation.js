// Tab Navigation
(function($) {

	'use strict';

	if( $('html.has-tab-navigation').get(0) ) {

		var $window 	 	  = $( window ),
			$toggleMenuButton = $('.toggle-menu'),
			$navActive   	  = $('.tab-navigation nav > ul .nav-active'),
			$tabNav      	  = $('.tab-navigation'),
			$tabItem 	 	  = $('.tab-navigation nav > ul > li a'),
			$contentBody 	  = $('.content-body');

		$tabItem.on('click', function(e){
			if( $(this).parent().hasClass('dropdown') || $(this).parent().hasClass('dropdown-submenu') ) {
				if( $window.width() < 992 ) {
					if( $(this).parent().hasClass('nav-expanded') ) {
						$(this).closest('li').find( '> ul' ).slideUp( 'fast', function() {
							$(this).css( 'display', '' );
							$(this).closest('li').removeClass( 'nav-expanded' );
						});
					} else {
						if( $(this).parent().hasClass('dropdown') ) {
							$tabItem.parent().removeClass('nav-expanded');
						}

						$(this).parent().addClass('expanding');
						
						$(this).closest('li').find( '> ul' ).slideDown( 'fast', function() {
							$tabItem.parent().removeClass('expanding');
							$(this).closest('li').addClass( 'nav-expanded' );
							$(this).css( 'display', '' );

							if( ($(this).position().top + $(this).height()) < $window.scrollTop() ) {
								$('html,body').animate({ scrollTop: $(this).offset().top - 100 }, 300);
							}
						});
					}
				} else {
					if( !$(this).parent().hasClass('dropdown') ) {
						e.preventDefault();
						return false;
					}
					
					if( $(this).parent().hasClass('nav-expanded') ) {
						$tabItem.parent().removeClass('nav-expanded');
						$contentBody.removeClass('tab-menu-opened');
						return;
					}
					
					$tabItem.parent().removeClass('nav-expanded');
					$contentBody.addClass('tab-menu-opened');
					$(this).parent().addClass('nav-expanded');	
				}
			}
		});

		$window.on('scroll', function(){
			if( $window.width() < 992 ) {
				var tabNavOffset = ( $tabNav.position().top + $tabNav.height() ) + 100,
					windowOffset = $window.scrollTop();

				if( windowOffset > tabNavOffset ) {
					$tabNav.removeClass('show');
				}
			}
		});

		$toggleMenuButton.on('click', function(){
			if( !$tabNav.hasClass('show') ) {
				$('html,body').animate({ scrollTop: $tabNav.offset().top - 50 }, 300);
			}
		});
		
	}

}).apply(this, [jQuery]);