// MultiSelect
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__multiselect';

	var PluginMultiSelect = function($el, opts) {
		return this.initialize($el, opts);
	};

	PluginMultiSelect.defaults = {
		templates: {
			li: '<li><a class="dropdown-item" tabindex="0"><label style="display: block;"></label></a></li>',
			filter: '<div class="input-group"><span class="input-group-prepend"><span class="input-group-text"><i class="fas fa-search"></i></span></span><input class="form-control multiselect-search" type="text"></div>'
		}
	};

	PluginMultiSelect.prototype = {
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
			this.options = $.extend( true, {}, PluginMultiSelect.defaults, opts );

			return this;
		},

		build: function() {
			this.$el.multiselect( this.options );

			return this;
		}
	};

	// expose to scope
	$.extend(theme, {
		PluginMultiSelect: PluginMultiSelect
	});

	// jquery plugin
	$.fn.themePluginMultiSelect = function(opts) {
		return this.each(function() {
			var $this = $(this);

			if ($this.data(instanceName)) {
				return $this.data(instanceName);
			} else {
				return new PluginMultiSelect($this, opts);
			}

		});
	}

}).apply(this, [window.theme, jQuery]);