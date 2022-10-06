
(function($) {

	'use strict';

	// Navigation
	var $items = $( '.nav-main li.nav-parent' );

	function expand( $li ) {
		$li.children( 'ul.nav-children' ).slideDown( 'fast', function() {
			$li.addClass( 'nav-expanded' );
			$(this).css( 'display', '' );
			ensureVisible( $li );
		});
	}

	function collapse( $li ) {
		$li.children('ul.nav-children' ).slideUp( 'fast', function() {
			$(this).css( 'display', '' );
			$li.removeClass( 'nav-expanded' );
		});
	}

	function ensureVisible( $li ) {
		var scroller = $li.offsetParent();
		if ( !scroller.get(0) ) {
			return false;
		}

		var top = $li.position().top;
		if ( top < 0 ) {
			scroller.animate({
				scrollTop: scroller.scrollTop() + top
			}, 'fast');
		}
	}

	function buildSidebarNav( anchor, prev, next, ev ) {
		if ( anchor.prop('href') ) {
			var arrowWidth = parseInt(window.getComputedStyle(anchor.get(0), ':after').width, 10) || 0;
			if (ev.offsetX > anchor.get(0).offsetWidth - arrowWidth) {
				ev.preventDefault();
			}
		}

		if ( prev.get( 0 ) !== next.get( 0 ) ) {
			collapse( prev );
			expand( next );
		} else {
			collapse( prev );
		}
	}

	$items.find('> a').on('click', function( ev ) {

		var $html   = $('html'),
			$window = $(window),
		    $anchor = $( this ),
			$prev   = $anchor.closest('ul.nav').find('> li.nav-expanded' ),
			$next   = $anchor.closest('li'),
			$ev     = ev;

		if( $anchor.attr('href') == '#' ) {
			ev.preventDefault();
		}

		if( !$html.hasClass('sidebar-left-big-icons') ) {
			buildSidebarNav( $anchor, $prev, $next, $ev );
		} else if( $html.hasClass('sidebar-left-big-icons') && $window.width() < 768 ) {
			buildSidebarNav( $anchor, $prev, $next, $ev );
		}

	});

	$('.nav-main').on('touchend', function(e){
		var $target = $( e.target );

		if( $target.closest('li').hasClass( 'nav-parent' ) ) {
			setTimeout(function(){
				$('html').removeClass('sidebar-left-collapsed');
				$('.content-body').trigger('click');
			}, 100); 
		} else {
			if( $target.closest('a').attr('href') ) {
		        window.location.href = $target.closest('a').attr('href');
		    }
		}
	});

	// Chrome Fix
	$.browser.chrome = /chrom(e|ium)/.test(navigator.userAgent.toLowerCase());
	if( $.browser.chrome && !$.browser.mobile ) {
		var flag = true;
		$('.sidebar-left .nav-main li a').on('click', function(){
			flag = false;
			setTimeout(function(){
				flag = true;
			}, 200);
		});

		$('.nano').on('mouseenter', function(e){
			$(this).addClass('hovered');
		});

		$('.nano').on('mouseleave', function(e){
			if( flag ) {
				$(this).removeClass('hovered');
			}
		});	
	}

	$('.nav-main a').filter(':not([href])').attr('href', '#');

	// Layout Fixed + Modern - Page Header Bottom Border
	if( $('html').hasClass('fixed') && $('html').hasClass('modern') && $('.page-header.page-header-left-inline-breadcrumb').get(0) ) {
		$(window).on('scroll', function(){
			if( $(window).scrollTop() > 5 ) {
				$('.page-header.page-header-left-inline-breadcrumb').addClass('border border-top-0 border-right-0 border-left-0 border-color-light-grey-2');
			} else {
				$('.page-header.page-header-left-inline-breadcrumb').removeClass('border border-top-0 border-right-0 border-left-0 border-color-light-grey-2');
			}
		});
	}

	// Data Hash
	$('[data-hash]').each(function() {

		var target = $(this).attr('href'),
			offset = ($(this).is("[data-hash-offset]") ? $(this).data('hash-offset') : 0);

		if($(target).get(0)) {
			$(this).on('click', function(e) {
				e.preventDefault();

				if( !$(e.target).is('i') ) {

					// Close Collapse if open
					$(this).parents('.collapse.show').collapse('hide');

					$window.trigger('resize');

					scrollToTarget(target, offset);
					
				}

			});
		}

	});

	// Scroll To Target
	function scrollToTarget(target, offset) {
		$('body').addClass('scrolling');

		$('html, body').animate({
			scrollTop: $(target).offset().top - offset
		}, 600, function() {
			$('body').removeClass('scrolling');
		});
	}

}).apply(this, [jQuery]);