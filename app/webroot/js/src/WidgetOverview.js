MW.components.WidgetOverview = function(settings) {
	this.init(settings);
}

MW.components.WidgetOverview.prototype = {
	init: function(settings) {
		this.settings = settings;

		this.loadContent();
	},

	setup: function(data) {
		var self = this;

		this.settings.loader.hide();

		Morris.Donut({
			element: self.settings.wrapper,
			data: [
				{value: data.expenses, label: 'Despesas'},
				{value: data.incoming, label: 'Receitas'},
			],
			labelColor: '#555',
			colors: [
				'red',
				'green'
			],
			formatter: function (x) { return "R$ " + x}
		});
	},

	loadContent: function() {
		var self = this,
			url = this.settings.wrapper.data('url');

		$.ajax({
			url: url,
			type: 'GET'
		}).done(function(data) {
			self.setup(data.overview);
		})
	}
}