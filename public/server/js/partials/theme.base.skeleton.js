// Skeleton
(function(theme, $) {

	'use strict';

	theme = theme || {};

	var $body				= $( 'body' ),
		$html				= $( 'html' ),
		$window				= $( window ),
		isAndroid			= navigator.userAgent.toLowerCase().indexOf('android') > -1,
		isIpad      		= navigator.userAgent.match(/iPad/i) != null,
		updatingNanoScroll  = false;

	// mobile devices with fixed has a lot of issues when focus inputs and others...
	if ( typeof $.browser !== 'undefined' && $.browser.mobile && $html.hasClass('fixed') ) {
		$html.removeClass( 'fixed' ).addClass( 'scroll' );
	}

	var Skeleton = {

		options: {
			sidebars: {
				menu: '#content-menu',
				left: '#sidebar-left',
				right: '#sidebar-right'
			}
		},

		customScroll: ( !Modernizr.overflowscrolling && !isAndroid && $.fn.nanoScroller !== 'undefined'),

		initialize: function() {
			this
				.setVars()
				.build()
				.events();
		},

		setVars: function() {
			this.sidebars = {};

			this.sidebars.left = {
				$el: $( this.options.sidebars.left )
			};

			this.sidebars.right = {
				$el: $( this.options.sidebars.right ),
				isOpened: $html.hasClass( 'sidebar-right-opened' )
			};

			this.sidebars.menu = {
				$el: $( this.options.sidebars.menu ),
				isOpened: $html.hasClass( 'inner-menu-opened' )
			};

			return this;
		},

		build: function() {

			if ( typeof $.browser !== 'undefined' && $.browser.mobile ) {
				$html.addClass( 'mobile-device' );
			} else {
				$html.addClass( 'no-mobile-device' );
			}

			$html.addClass( 'custom-scroll' );
			if ( this.customScroll ) {
				this.buildSidebarLeft();
				this.buildContentMenu();
			}

			if( isIpad ) {
				this.fixIpad();
			}

			this.buildSidebarRight();

			return this;
		},

		events: function() {
			if ( this.customScroll ) {
				this.eventsSidebarLeft();
			}

			this.eventsSidebarRight();
			this.eventsContentMenu();

			if ( typeof $.browser !== 'undefined' && !this.customScroll && isAndroid ) {
				this.fixScroll();
			}

			return this;
		},

		fixScroll: function() {
			var _self = this;

			$window
				.on( 'sidebar-left-opened sidebar-right-toggle', function( e, data ) {
					_self.preventBodyScrollToggle( data.added );
				});

		},

		fixIpad: function() {
			var _self = this;

			$('.header, .page-header, .content-body').on('click', function(){
				$html.removeClass('sidebar-left-opened');
			});
		},

		buildSidebarLeft: function() {

			var initialPosition = 0;

			this.sidebars.left.isOpened = !$html.hasClass( 'sidebar-left-collapsed' ) || $html.hasClass( 'sidebar-left-opened' );

			this.sidebars.left.$nano = this.sidebars.left.$el.find( '.nano' );

			if (typeof localStorage !== 'undefined') {
				this.sidebars.left.$nano.on('update', function(e, values) {
					localStorage.setItem('sidebar-left-position', values.position);
				});

				if (localStorage.getItem('sidebar-left-position') !== null) {
					initialPosition = localStorage.getItem('sidebar-left-position');
					this.sidebars.left.$el.find( '.nano-content').scrollTop(initialPosition);
				}
			}

			this.sidebars.left.$nano.nanoScroller({
				scrollTop: initialPosition,
				alwaysVisible: true,
				preventPageScrolling: $html.hasClass( 'fixed' )
			});

			return this;
		},

		eventsSidebarLeft: function() {

			var _self = this,
				$nano = this.sidebars.left.$nano;

			var open = function() {
				if ( _self.sidebars.left.isOpened ) {
					return close();
				}

				_self.sidebars.left.isOpened = true;

				$html.addClass( 'sidebar-left-opened' );

				$window.trigger( 'sidebar-left-toggle', {
					added: true,
					removed: false
				});

				$html.on( 'click.close-left-sidebar', function(e) {
					e.stopPropagation();
					close(e);
				});


			};

			var close = function(e) {
				if ( !!e && !!e.target && ($(e.target).closest( '.sidebar-left' ).get(0) || !$(e.target).closest( 'html' ).get(0)) ) {
					e.preventDefault();
					return false;
				} else {

					$html.removeClass( 'sidebar-left-opened' );
					$html.off( 'click.close-left-sidebar' );

					$window.trigger( 'sidebar-left-toggle', {
						added: false,
						removed: true
					});

					_self.sidebars.left.isOpened = !$html.hasClass( 'sidebar-left-collapsed' );

				}
			};

			var updateNanoScroll = function() {
				if (updatingNanoScroll) {
					if ( $.support.transition ) {
						$nano.nanoScroller();
						$nano
							.one('bsTransitionEnd', updateNanoScroll)
							.emulateTransitionEnd(150)
					} else {
						updateNanoScroll();
					}

					updatingNanoScroll = true;

					setTimeout(function() {
						updatingNanoScroll = false;
					}, 200);
				}
			};

			var isToggler = function( element ) {
				return $(element).data('fire-event') === 'sidebar-left-toggle' || $(element).parents().data('fire-event') === 'sidebar-left-toggle';
			};

			this.sidebars.left.$el
				.on( 'click', function() {
					updateNanoScroll();

					$(window).trigger('resize');
				})
				.on('touchend', function(e) {
					_self.sidebars.left.isOpened = !$html.hasClass( 'sidebar-left-collapsed' ) || $html.hasClass( 'sidebar-left-opened' );
					if ( !_self.sidebars.left.isOpened && !isToggler(e.target) ) {
						e.stopPropagation();
						e.preventDefault();
						open();
					}

					$(window).trigger('resize');
				});

			$nano
				.on( 'mouseenter', function() {
					if ( $html.hasClass( 'sidebar-left-collapsed' ) ) {
						$nano.nanoScroller();
					}
				})
				.on( 'mouseleave', function() {
					if ( $html.hasClass( 'sidebar-left-collapsed' ) ) {
						$nano.nanoScroller();
					}
				});

			$window.on( 'sidebar-left-toggle', function(e, toggle) {
				if ( toggle.removed ) {
					$html.removeClass( 'sidebar-left-opened' );
					$html.off( 'click.close-left-sidebar' );
				}
				
				// Recalculate Owl Carousel sizes
				$('.owl-carousel').trigger('refresh.owl.carousel');
			});

			return this;
		},

		buildSidebarRight: function() {
			this.sidebars.right.isOpened = $html.hasClass( 'sidebar-right-opened' );

			if ( this.customScroll ) {
				this.sidebars.right.$nano = this.sidebars.right.$el.find( '.nano' );

				this.sidebars.right.$nano.nanoScroller({
					alwaysVisible: true,
					preventPageScrolling: true
				});
			}

			return this;
		},

		eventsSidebarRight: function() {
			var _self = this;

			var open = function() {
				if ( _self.sidebars.right.isOpened ) {
					return close();
				}

				_self.sidebars.right.isOpened = true;

				$html.addClass( 'sidebar-right-opened' );

				$window.trigger( 'sidebar-right-toggle', {
					added: true,
					removed: false
				});

				$html.on( 'click.close-right-sidebar', function(e) {
					if( !$( e.target ).data('toggle') ) {
						e.stopPropagation();
					}
					close(e);
				});
			};

			var close = function(e) {
				if ( !!e && !!e.target && ($(e.target).closest( '.sidebar-right' ).get(0) || !$(e.target).closest( 'html' ).get(0)) ) {
					return false;
				}

				$html.removeClass( 'sidebar-right-opened' );
				$html.off( 'click.close-right-sidebar' );

				$window.trigger( 'sidebar-right-toggle', {
					added: false,
					removed: true
				});

				_self.sidebars.right.isOpened = false;
			};

			var bind = function() {
				$('[data-open="sidebar-right"]').on('click', function(e) {
					var $el = $(this);
					e.stopPropagation();

					if ( $el.is('a') )
						e.preventDefault();

					open();
				});
			};

			this.sidebars.right.$el.find( '.mobile-close' )
				.on( 'click', function( e ) {
					e.preventDefault();
					$html.trigger( 'click.close-right-sidebar' );
				});

			bind();

			return this;
		},

		buildContentMenu: function() {
			if ( !$html.hasClass( 'fixed' ) ) {
				return false;
			}

			this.sidebars.menu.$nano = this.sidebars.menu.$el.find( '.nano' );

			this.sidebars.menu.$nano.nanoScroller({
				alwaysVisible: true,
				preventPageScrolling: true
			});

			return this;
		},

		eventsContentMenu: function() {
			var _self = this;

			var open = function() {
				if ( _self.sidebars.menu.isOpened ) {
					return close();
				}

				_self.sidebars.menu.isOpened = true;

				$html.addClass( 'inner-menu-opened' );

				$window.trigger( 'inner-menu-toggle', {
					added: true,
					removed: false
				});

				$html.on( 'click.close-inner-menu', function(e) {

					close(e);
				});

			};

			var close = function(e) {
				var hasEvent,
					hasTarget,
					isCollapseButton,
					isInsideModal,
					isInsideInnerMenu,
					isInsideHTML,
					$target;

				hasEvent = !!e;
				hasTarget = hasEvent && !!e.target;

				if ( hasTarget ) {
					$target = $(e.target);
				}

				isCollapseButton = hasTarget && !!$target.closest( '.inner-menu-collapse' ).get(0);
				isInsideModal = hasTarget && !!$target.closest( '.mfp-wrap' ).get(0);
				isInsideInnerMenu = hasTarget && !!$target.closest( '.inner-menu' ).get(0);
				isInsideHTML = hasTarget && !!$target.closest( 'html' ).get(0);

				if ( (!isCollapseButton && (isInsideInnerMenu || !isInsideHTML)) || isInsideModal ) {
					return false;
				}

				e.stopPropagation();

				$html.removeClass( 'inner-menu-opened' );
				$html.off( 'click.close-inner-menu' );

				$window.trigger( 'inner-menu-toggle', {
					added: false,
					removed: true
				});

				_self.sidebars.menu.isOpened = false;
			};

			var bind = function() {
				$('[data-open="inner-menu"]').on('click', function(e) {
					var $el = $(this);
					e.stopPropagation();

					if ( $el.is('a') )
						e.preventDefault();

					open();
				});
			};

			bind();

			/* Nano Scroll */
			if ( $html.hasClass( 'fixed' ) ) {
				var $nano = this.sidebars.menu.$nano;

				var updateNanoScroll = function() {
					if ( $.support.transition ) {
						$nano.nanoScroller();
						$nano
							.one('bsTransitionEnd', updateNanoScroll)
							.emulateTransitionEnd(150)
					} else {
						updateNanoScroll();
					}
				};

				this.sidebars.menu.$el
					.on( 'click', function() {
						updateNanoScroll();
					});
			}

			return this;
		},

		preventBodyScrollToggle: function( shouldPrevent, $el ) {
			setTimeout(function() {
				if ( shouldPrevent ) {
					$body
						.data( 'scrollTop', $body.get(0).scrollTop )
						.css({
							position: 'fixed',
							top: $body.get(0).scrollTop * -1
						})
				} else {
					$body
						.css({
							position: '',
							top: ''
						})
						.scrollTop( $body.data( 'scrollTop' ) );
				}
			}, 150);
		}

	};

	// expose to scope
	$.extend(theme, {
		Skeleton: Skeleton
	});

}).apply(this, [window.theme, jQuery]);