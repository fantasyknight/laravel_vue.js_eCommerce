// Markdown
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__markdownEditor';

	var PluginMarkdownEditor = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginMarkdownEditor.defaults = {
		iconlibrary: 'fa',
		buttons: [
			[{
				data: [{
					icon: {
						fa: 'fa fa-bold'
					}
				}, {
					icon: {
						fa: 'fa fa-italic'
					}
				}, {
					icon: {
						fa: 'fa fa-heading'
					}
				}]
			}, {
				data: [{
					icon: {
						fa: 'fa fa-link'
					}
				}, {
					icon: {
						fa: 'fa fa-image'
					}
				}]
			}, {
				data: [{
						icon: {
							fa: 'fa fa-list'
						}
					},
					{
						icon: {
							fa: 'fa fa-list-ol'
						}
					},
					{
						icon: {
							fa: 'fa fa-code'
						}
					},
					{
						icon: {
							fa: 'fa fa-quote-left'
						}
					}
				]
			}, {
				data: [{
					icon: {
						fa: 'fa fa-search'
					}
				}]
			}]
		]
	};

	PluginMarkdownEditor.prototype = {
		initialize: function($el, opts) {
			if ( $el.data( instanceName ) ) {
				return this;
			}

			this.$el = $el;

			this
				.setData()
				.setOptions(opts)
				.build();

			return this;
		},

		setData: function() {
			this.$el.data(instanceName, this);

			return this;
		},

		setOptions: function(opts) {
			this.options = $.extend( true, {}, PluginMarkdownEditor.defaults, opts );

			return this;
		},

		build: function() {
			this.$el.markdown( this.options );

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginMarkdownEditor: PluginMarkdownEditor
	});

	// jquery plugin
	$.fn.themePluginMarkdownEditor = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginMarkdownEditor($this, opts);
			}

		});
	}

}).apply(this, [window.theme, jQuery]);