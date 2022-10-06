// Codemirror
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__codemirror';

	var PluginCodeMirror = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginCodeMirror.defaults = {
		lineNumbers: true,
		styleActiveLine: true,
		matchBrackets: true,
		theme: 'monokai'
	};

	PluginCodeMirror.prototype = {
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
			this.options = $.extend( true, {}, PluginCodeMirror.defaults, opts );

			return this;
		},

		build: function() {
			CodeMirror.fromTextArea( this.$el.get(0), this.options );

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginCodeMirror: PluginCodeMirror
	});

	// jquery plugin
	$.fn.themePluginCodeMirror = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginCodeMirror($this, opts);
			}

		});
	}

}).apply(this, [window.theme, jQuery]);