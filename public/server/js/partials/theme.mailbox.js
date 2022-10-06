// Mailbox
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__mailbox';

	var capitalizeString = function( str ) {
    	return str.charAt( 0 ).toUpperCase() + str.slice( 1 );
	}

	var Mailbox = function($wrapper) {
		return this.initialize($wrapper);
	};

	Mailbox.prototype = {
		initialize: function($wrapper) {
			if ( $wrapper.data( instanceName ) ) {
				return this;
			}

			this.$wrapper = $wrapper;

			this
				.setVars()
				.setData()
				.build()
				.events();

			return this;
		},

		setVars: function() {
			this.view = capitalizeString( this.$wrapper.data( 'mailbox-view' ) || "" );

			return this;
		},

		setData: function() {
			this.$wrapper.data(instanceName, this);

			return this;
		},

		build: function() {

			if ( typeof this[ 'build' + this.view ] === 'function' ) {
				this[ 'build' + this.view ].call( this );
			}


			return this;
		},

		events: function() {
			if ( typeof this[ 'events' + this.view ] === 'function' ) {
				this[ 'events' + this.view ].call( this );
			}

			return this;
		},

		buildFolder: function() {
			this.$wrapper.find('.mailbox-email-list .nano').nanoScroller({
				alwaysVisible: true,
				preventPageScrolling: true
			});
		},

		buildEmail: function() {
			this.buildComposer();
		},

		buildCompose: function() {
			this.buildComposer();
		},

		buildComposer: function() {
			this.$wrapper.find( '#compose-field' ).summernote({
				height: 250,
				toolbar: [
					['style', ['style']],
					['font', ['bold', 'italic', 'underline', 'clear']],
					['fontname', ['fontname']],
					['color', ['color']],
					['para', ['ul', 'ol', 'paragraph']],
					['height', ['height']],
					['table', ['table']],
					['insert', ['link', 'picture', 'video']],
					['view', ['fullscreen']],
					['help', ['help']]
				]
			});
		},

		eventsCompose: function() {
			var $composer,
				$contentBody,
				$html,
				$innerBody;

			$composer		= $( '.note-editable' );
			$contentBody	= $( '.content-body' );
			$html			= $( 'html' );
			$innerBody		= $( '.inner-body' );

			var adjustComposeSize = function() {
				var composerHeight,
					composerTop,
					contentBodyPaddingBottom,
					innerBodyHeight,
					viewportHeight,
					viewportWidth;


				contentBodyPaddingBottom	= parseInt( $contentBody.css('paddingBottom'), 10 ) || 0;
				viewportHeight				= Math.max( document.documentElement.clientHeight, window.innerHeight || 0 );
				viewportWidth				= Math.max( document.documentElement.clientWidth, window.innerWidth || 0 );

				$composer.css( 'height', '' );

				if ( viewportWidth < 767 || $html.hasClass('mobile-device') ) {
					composerTop	   = $composer.offset().top;
					composerHeight = viewportHeight - composerTop;
				} else {
					if ( $html.hasClass( 'fixed' ) ) {
						composerTop	= $composer.offset().top;
					} else {
						composerTop	= $composer.position().top;
					}
					composerHeight = $innerBody.outerHeight() - composerTop;
				}

				composerHeight -= contentBodyPaddingBottom;

				$composer.css({
					height: composerHeight
				});
			};

			var timer;
			$(window)
				.on( 'resize orientationchange sidebar-left-toggle mailbox-recalc', function() {
					clearTimeout( timer );
					timer = setTimeout(function() {
						adjustComposeSize();
					}, 100);
				});

			adjustComposeSize();
		}
	};

	// expose to scope
	$.extend(theme, {
		Mailbox: Mailbox
	});

	// jquery plugin
	$.fn.themeMailbox = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new Mailbox($this);
			}

		});
	}

}).apply(this, [window.theme, jQuery]);